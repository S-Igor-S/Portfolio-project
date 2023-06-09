<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Blog;
use App\Models\Footer;
use App\Models\HomeSlide;
use App\Models\MultiImage;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        $route = Route::current()->getName();
        $homeSlide = HomeSlide::find(1);
        $aboutContent = About::find(1);
        $blogs = Blog::latest()->limit(3)->get();
        $aboutImages = MultiImage::all();
        $footer = Footer::find(1);
        $aboutBlock = [
            'content' => $aboutContent,
            'images'     => $aboutImages,
        ];
        return view('frontend.index', compact('homeSlide', 'aboutBlock', 'blogs', 'footer', 'route'));
    }
}
