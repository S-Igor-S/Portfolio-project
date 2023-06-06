<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog(){
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        $blogs = Blog::latest()->get();
        return view('frontend.blog',compact('blogs','categories'));

    }

    public function index($id)
    {
        $blogs      = Blog::latest()->limit(5)->get();
        $blog       = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();

        return view('frontend.blog_details',
            compact('blog', 'blogs', 'categories'));
    }

    public function сategory($id)
    {
        $blog         = Blog::where('blog_category_id', $id)
                            ->orderBy('id', 'DESC')
                            ->get();
        $blogs        = Blog::latest()->limit(5)->get();
        $categories   = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $categoryName = BlogCategory::findOrFail($id);

        return view('frontend.blog_category',
            compact('blog', 'blogs', 'categories', 'categoryName'));
    }

}
