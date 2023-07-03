<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\ContentElement;
use App\Models\MultiImage;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application as ContractsFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AboutController extends Controller
{

    const TEMPLATE_NAME = 'about';

    public array $removeKeys = ['_token', 'name', 'image'];

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(): View|Application|Factory|ContractsFoundation
    {
        $id             = Auth::user()->id;
        $userData       = User::find($id);
        $element        = ContentElement::where('name', self::TEMPLATE_NAME)
                                        ->first();
        $image          = $element->image ?? '';
        $elementContent = isset($element->content) ? json_decode($element->content) : [];
        $templateName   = self::TEMPLATE_NAME;

        return view('admin.about.index',
            compact('elementContent', 'image', 'templateName', 'userData'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $content    = $request->all();
        $name       = $content['name'];
        $updateData = [];

        if ($request->file('image')) {
            $image = $request->file('image');
            $dir   = 'upload/about_images/';

            if ( ! is_dir(public_path($dir))) {
                mkdir(public_path($dir));
            }

            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(636, 852)->save($dir.$imageName);

            $savePath            = $dir.$imageName;
            $updateData['image'] = $savePath;
            $notification        = [
                'message'    => 'About content updated with image successfully',
                'alert_type' => 'success',
            ];
        } else {
            $notification = [
                'message'    => 'About content updated without image successfully',
                'alert_type' => 'success',
            ];
        }

        $content               = array_diff_key($content,
            array_flip($this->removeKeys));
        $updateData['content'] = json_encode($content);
        ContentElement::updateOrCreate(
            ['name' => $name],
            $updateData,
        );

        return redirect()->back()->with($notification);
    }

    public function addImage(
    ): View|Application|Factory|ContractsFoundation
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('admin.about.add_image', compact('userData'));
    }

    public function insertImage(Request $request): RedirectResponse
    {
        $images = $request->file('image');
        $id = $request->get('id');

        $dir = 'upload/about_images/';

        if ( ! is_dir(public_path($dir))) {
            mkdir(public_path($dir));
        }

        foreach ($images as $image) {
            $name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)
                 ->resize(220, 220)
                 ->save($dir.$name);
            $url = $dir.$name;
            MultiImage::updateOrCreate(
                ['id' => $id],
                ['multi_image' => $url]
            );
        }
        $notification = [
            'message'    => 'Image Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('dashboard.about.images.all')->with($notification);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function getImagesList(
    ): View|Application|Factory|ContractsFoundation
    {
        $id            = Auth::user()->id;
        $userData      = User::find($id);
        $allMultiImage = MultiImage::all();

        return view('admin.about.all_images',
            compact('allMultiImage'), compact('userData'));
    }

    public function editImage($id): View|Application|Factory|ContractsFoundation
    {
        $userId     = Auth::user()->id;
        $userData   = User::find($userId);
        $multiImage = MultiImage::findOrFail($id);

        return view('admin.about.edit_image',
            compact('multiImage'), compact('userData'));
    }

    public function deleteImage($id): RedirectResponse
    {
        $multi = MultiImage::findOrFail($id);
        $img   = $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

        $notification = [
            'message'    => 'Multi Image Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

}
