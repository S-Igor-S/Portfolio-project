<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\FooterController;
use App\Models\Blog;
use App\Models\ContentElement;
use App\Models\MultiImage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AboutController;

class HomeController extends Controller
{
    public function index()
    {
        $route = Route::current()->getName();
        $banner = ContentElement::where('name', BannerController::TEMPLATE_NAME)->first();
        $banner->content = json_decode($banner->content);

        $about = ContentElement::where('name', AboutController::TEMPLATE_NAME)->first();
        $about->content = json_decode($about->content);

        $blogs = Blog::latest()->limit(3)->get();
        $aboutImages = MultiImage::all();

        $footer = ContentElement::where('name', FooterController::TEMPLATE_NAME)->first();
        $footer->content = json_decode($footer->content);
        $aboutBlock = [
            'content' => $about,
            'images'     => $aboutImages,
        ];
        return view('frontend.index', compact('banner', 'aboutBlock', 'blogs', 'footer', 'route'));
    }
}
