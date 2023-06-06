<?php

namespace App\Http\Controllers\Sliders;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogCategoryController extends Controller
{
    public function getAllBlogCategories(){
        $id       = Auth::user()->id;
        $userData = User::find($id);
        $blogCategories = BlogCategory::latest()->get();
        return view('admin.blog.all_blog_category',compact('blogCategories'), compact('userData'));
    }

    public function addBlogCategory(){
        $id       = Auth::user()->id;
        $userData = User::find($id);
        return view('admin.blog.add_blog_category', compact('userData'));
    }


    public function saveBlogCategory(Request $request){
        $request->validate([
            'blog_category' => 'required'
        ],[
            'blog_category.required' => 'Blog Cateogry Name is Required',
        ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,

        ]);

        $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('blog.category.all')->with($notification);
    }

    public function editBlogCategory($id){
        $userId       = Auth::user()->id;
        $userData = User::find($userId);
        $blogCategory = BlogCategory::findOrFail($id);
        return view('admin.blog.edit_blog_category',compact('blogCategory'), compact('userData'));
    }

    public function updateBlogCategory(Request $request,$id){
        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category,

        ]);

        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('blog.category.all')->with($notification);
    }

    public function deleteBlogCategory($id){
        BlogCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
