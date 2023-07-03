<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function getAllBlog(){
        $userId       = Auth::user()->id;
        $userData = User::find($userId);
        $blogs = Blog::latest()->get();
        return view('admin.blog.all_blog',compact('blogs'), compact('userData'));
    }

    public function addBlog(){
        $userId       = Auth::user()->id;
        $userData = User::find($userId);
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('admin.blog.add_blog',compact('categories'), compact('userData'));
    }

    public function saveBlog(Request $request){

        $image = $request->file('blog_image');
        $name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        $dir = 'upload/blog/';

        if (!is_dir(public_path($dir))) {
            mkdir(public_path($dir));
        }

        Image::make($image)->resize(430,327)->save($dir.$name);
        $savePath = 'upload/blog/'.$name;

        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' => $savePath,
        ]);
        $notification = array(
            'message' => 'Blog Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('dashboard.blog.all')->with($notification);
    }

    public function editBlog($id){
        $userId       = Auth::user()->id;
        $userData = User::find($userId);
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('admin.blog.edit_blog',compact('blogs','categories', 'userData'));

    }

    public function updateBlog(Request $request){

        $blog_id = $request->id;

        if ($request->file('blog_image')) {
            $image = $request->file('blog_image');
            $dir = 'upload/blog/';
            $name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(430,327)->save($dir.$name);
            $savePath = 'upload/blog/'.$name;

            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $savePath,

            ]);
            $notification = array(
                'message' => 'Blog Updated with Image Successfully',
                'alert-type' => 'success'
            );
        } else{
            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,

            ]);

            $notification = array(
                'message' => 'Blog Updated without Image Successfully',
                'alert-type' => 'success'
            );
        }

        return redirect()->route('dashboard.blog.all')->with($notification);
    }



    public function deleteBlog($id){
        $blogs = Blog::findOrFail($id);
        $img = $blogs->blog_image;
        unlink($img);

        Blog::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
