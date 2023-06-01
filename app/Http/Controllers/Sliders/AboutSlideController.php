<?php

namespace App\Http\Controllers\Sliders;

use App\Http\Controllers\Controller;
use App\Models\About;
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

class AboutSlideController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function getAboutSlide(
    ): View|Application|Factory|ContractsFoundation
    {
        $id        = Auth::user()->id;
        $userData  = User::find($id);
        $aboutPage = About::find(1);

        return view('admin.about_slide.index', compact('aboutPage'),
            compact('userData'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAbout(Request $request): RedirectResponse
    {
        $slideId = $request->id;

        $slideDB = About::where('id', $slideId);

        if ($request->file('about_image')) {
            $image = $request->file('about_image');
            $dir   = 'upload/about_slide/';

            if ( ! is_dir(public_path($dir))) {
                mkdir(public_path($dir));
            }

            $name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(523, 605)->save($dir.$name);
            $save_url = $dir.$name;

            if (About::where('id', $slideId)->exists()) {
                About::findOrFail($slideId)->update([
                    'title'             => $request->title,
                    'short_title'       => $request->short_title,
                    'short_description' => $request->short_description,
                    'long_description'  => $request->long_description,
                    'about_image'       => $save_url,

                ]);
            } else {
                About::create([
                    'title'             => $request->title,
                    'short_title'       => $request->short_title,
                    'short_description' => $request->short_description,
                    'long_description'  => $request->long_description,
                    'about_image'       => $save_url,
                ]);
            }

            $notification = [
                'message'    => 'About Page Updated with Image Successfully',
                'alert_type' => 'success',
            ];
        } else {
            if (About::where('id', $slideId)->exists()) {
                About::findOrFail($slideId)->update([
                    'title'             => $request->title,
                    'short_title'       => $request->short_title,
                    'short_description' => $request->short_description,
                    'long_description'  => $request->long_description,

                ]);
            } else {
                About::create([
                    'title'             => $request->title,
                    'short_title'       => $request->short_title,
                    'short_description' => $request->short_description,
                    'long_description'  => $request->long_description,

                ]);
            }
            $notification = [
                'message'    => 'About Page Updated without Image Successfully',
                'alert_type' => 'success',
            ];
        }

        return redirect()->back()->with($notification);
    }

    public function getAboutSlideMultiImage(
    ): View|Application|Factory|ContractsFoundation
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('admin.about_slide.multi_image', compact('userData'));
    }

    public function insertMultiImage(Request $request)
    {
        $images = $request->file('multi_image');

        $dir = 'upload/multiimage/';

        if ( ! is_dir(public_path($dir))) {
            mkdir(public_path($dir));
        }

        foreach ($images as $image) {
            $name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)
                 ->resize(220, 220)
                 ->save($dir.$name);
            $url = $dir.$name;
            MultiImage::insert([
                'multi_image' => $url,
            ]);
        }
        $notification = [
            'message'    => 'Multi Image Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('about.multiimage.all')->with($notification);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function getAllMultiImage(
    ): View|Application|Factory|ContractsFoundation
    {
        $id            = Auth::user()->id;
        $userData      = User::find($id);
        $allMultiImage = MultiImage::all();

        return view('admin.about_slide.all_multi_image',
            compact('allMultiImage'), compact('userData'));
    }

    public function editMultiImage($id)
    {
        $userId     = Auth::user()->id;
        $userData   = User::find($userId);
        $multiImage = MultiImage::findOrFail($id);

        return view('admin.about_slide.edit_multi_image',
            compact('multiImage'), compact('userData'));
    }


    public function updateMultiImage(Request $request)
    {
        $multi_image_id = $request->id;

        $dir = 'upload/multiimage/';

        if ( ! is_dir(public_path($dir))) {
            mkdir(public_path($dir));
        }

        $image    = $request->file('multi_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // 3434343443.jpg

        Image::make($image)
             ->resize(220, 220)
             ->save($dir.$name_gen);
        $save_url = $dir.$name_gen;

        MultiImage::findOrFail($multi_image_id)->update([
            'multi_image' => $save_url,
        ]);
        $notification = [
            'message'    => 'Multi Image Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('about.multiimage.all')->with($notification);
    }

    public function deleteMultiImage($id){

        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);



    }

}
