<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Blog;
use App\Models\HomeSlide;
use App\Models\MultiImage;

class HomeController extends Controller
{
    public function index()
    {
        $homeSlide = HomeSlide::find(1);
        $aboutContent = About::find(1);
        $blogs = Blog::latest()->limit(3)->get();
        $aboutImages = MultiImage::all();
        $aboutBlock = [
            'content' => $aboutContent,
            'images'     => $aboutImages,
        ];
        return view('frontend.index', compact('homeSlide', 'aboutBlock', 'blogs'));
    }
}
