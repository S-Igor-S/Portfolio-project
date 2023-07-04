<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\FooterController;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\ContentElement;
use App\Models\Footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BlogController extends Controller
{

    public function blog()
    {
        $route      = Route::current()->getName();

        $footer = ContentElement::where('name', FooterController::TEMPLATE_NAME)->first();
        $footer->content = json_decode($footer->content);

        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $blogs      = Blog::latest()->paginate(3);

        return view('frontend.blog',
            compact('blogs', 'categories', 'footer', 'route'));
    }

    public function index($id)
    {
        $route      = Route::current()->getName();

        $footer = ContentElement::where('name', FooterController::TEMPLATE_NAME)->first();
        $footer->content = json_decode($footer->content);

        $blogs      = Blog::latest()->limit(5)->get();
        $blog       = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();

        return view('frontend.blog_details',
            compact('blog', 'blogs', 'categories', 'footer', 'route'));
    }

    public function category($id)
    {
        $route = Route::current()->getName();

        $footer = ContentElement::where('name', FooterController::TEMPLATE_NAME)->first();
        $footer->content = json_decode($footer->content);

        $blog         = Blog::where('blog_category_id', $id)
                            ->orderBy('id', 'DESC')
                            ->get();
        $blogs        = Blog::latest()->limit(5)->get();
        $categories   = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $categoryName = BlogCategory::findOrFail($id);

        return view('frontend.blog_category',
            compact('blog', 'blogs', 'categories', 'categoryName', 'footer', 'route'));
    }

}
