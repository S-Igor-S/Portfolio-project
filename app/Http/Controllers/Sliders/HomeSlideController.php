<?php

namespace App\Http\Controllers\Sliders;

use App\Http\Controllers\Controller;
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

class HomeSlideController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function getHomeSlide(): View|Application|Factory|ContractsFoundation
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);
        $homeSlide = HomeSlide::find(1);
        return view('admin.home_slide.index',compact('homeSlide'), compact('userData'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateHomeSlide(Request $request): RedirectResponse
    {
        $slideId = $request->id;

        if ($request->file('home_slide')) {
            $image = $request->file('home_slide');
            $dir = 'upload/home_slide/';

            if (!is_dir(public_path($dir))) {
                mkdir(public_path($dir));
            }

            $name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(636,852)->save($dir . $name);
            $savePath = $dir . $name;

            HomeSlide::findOrFail($slideId)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
                'home_slide' => $savePath,
            ]);
            $notification = array(
                'message' => 'Home Slide Updated with Image Successfully',
                'alert_type' => 'success'
            );
        } else{
            HomeSlide::findOrFail($slideId)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
            ]);

            $notification = array(
                'message' => 'Home Slide Updated without Image Successfully',
                'alert_type' => 'success'
            );
        }

        return redirect()->back()->with($notification);
    }
}
