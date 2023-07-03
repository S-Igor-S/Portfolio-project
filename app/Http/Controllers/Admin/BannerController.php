<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentElement;
use App\Models\HomeSlide;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Foundation\Application as ContractsFoundation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    const TEMPLATE_NAME = 'banner';

    public array $removeKeys = ['_token', 'name', 'image'];

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(): View|Application|Factory|ContractsFoundation
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);
        $element = ContentElement::where('name', self::TEMPLATE_NAME)->first();
        $image = $element->image ?? '';
        $elementContent = json_decode($element->content) ?? [];
        $templateName = self::TEMPLATE_NAME;
        return view('admin.banner.index', compact('elementContent', 'image', 'templateName', 'userData'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $content = $request->all();
        $name = $content['name'];
        $updateData = [];

        if ($request->file('image')) {
            $image = $request->file('image');
            $dir = 'upload/banner_images/';

            if (!is_dir(public_path($dir))) {
                mkdir(public_path($dir));
            }

            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(636,852)->save($dir . $imageName);

            $savePath = $dir . $imageName;
            $updateData['image'] = $savePath;
            $notification = array(
                'message' => 'Banner Updated with Image Successfully',
                'alert_type' => 'success'
            );
        } else{
            $notification = array(
                'message' => 'Banner Updated without Image Successfully',
                'alert_type' => 'success'
            );
        }
        $content = array_diff_key($content, array_flip($this->removeKeys));
        $updateData['content'] = json_encode($content);
        ContentElement::updateOrCreate(
            ['name' => $name],
            $updateData,
        );

        return redirect()->back()->with($notification);
    }
}
