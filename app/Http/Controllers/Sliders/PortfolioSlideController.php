<?php

namespace App\Http\Controllers\Sliders;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PortfolioSlideController extends Controller
{

    public function getAllPortfolio()
    {
        $id        = Auth::user()->id;
        $userData  = User::find($id);
        $portfolio = Portfolio::latest()->get();

        return view('admin.portfolio_slide.all_portfolio', compact('portfolio'),
            compact('userData'));
    }

    public function addPortfolio()
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('admin.portfolio_slide.add_portfolio', compact('userData'));
    }


    public function savePortfolio(Request $request)
    {
        $request->validate([
            'portfolio_name'  => 'required',
            'portfolio_title' => 'required',
            'portfolio_image' => 'required',

        ], [

            'portfolio_name.required'  => 'Portfolio Name is Required',
            'portfolio_title.required' => 'Portfolio Titile is Required',
        ]);

        $image = $request->file('portfolio_image');
        $dir   = 'upload/portfolio/';

        if ( ! is_dir(public_path($dir))) {
            mkdir(public_path($dir));
        }

        $name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(1020, 519)->save($dir.$name);
        $savePath = $dir.$name;

        Portfolio::insert([
            'portfolio_name'        => $request->portfolio_name,
            'portfolio_title'       => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image'       => $savePath,
        ]);
        $notification = [
            'message'    => 'Portfolio Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('portfolio.all')->with($notification);
    }

    public function editPortfolio($id)
    {
        $userId   = Auth::user()->id;
        $userData = User::find($userId);

        $portfolio = Portfolio::findOrFail($id);

        return view('admin.portfolio_slide.edit_portfolio',
            compact('portfolio'), compact('userData'));
    }

    public function updatePortfolio(Request $request)
    {
        $portfolio_id = $request->id;

        if ($request->file('portfolio_image')) {
            $image    = $request->file('portfolio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)
                 ->resize(1020, 519)
                 ->save('upload/portfolio/'.$name_gen);
            $save_url = 'upload/portfolio/'.$name_gen;

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name'        => $request->portfolio_name,
                'portfolio_title'       => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image'       => $save_url,

            ]);
            $notification = [
                'message'    => 'Portfolio Updated with Image Successfully',
                'alert-type' => 'success',
            ];
        } else {
            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name'        => $request->portfolio_name,
                'portfolio_title'       => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
            ]);
            $notification = [
                'message'    => 'Portfolio Updated without Image Successfully',
                'alert-type' => 'success',
            ];
        }

        return redirect()->route('portfolio.all')->with($notification);
    }

    public function deletePortfolio($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $img       = $portfolio->portfolio_image;
        unlink($img);

        Portfolio::findOrFail($id)->delete();

        $notification = [
            'message'    => 'Portfolio Image Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    public function portfolioDetails($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        return view('frontend.portfolio_details', compact('portfolio'));
    }

}
