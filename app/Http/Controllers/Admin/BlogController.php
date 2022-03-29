<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(){
        $details = Blog::where('is_activate', 1)->orderBy('created_at', 'DESC')->get();
        return view('admin.blog.get-blogs')->with(['details' => $details]);
    }

    public function createBlog(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'blogImage' => 'required|image|mimes:jpg,png,jpeg|max:1024',
            'blogContent' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Whoops! Something went wrong. Not able to create blog', 'error' => $validator->errors(), 'status' => 2]);
        }else{
            $title = $request->title;
            $blogImage = $request->blogImage;
            $blogContent = $request->blogContent;
            $file = '';
            if (isset($blogImage) && !empty($blogImage)) {
                $new_name = date('d-m-Y-H-i-s') . '_' . $blogImage->getClientOriginalName();
                $blogImage->move(public_path('/admin/assets/files/blog/'), $new_name);
                $file = '/admin/assets/files/blog/' . $new_name;
            }

           $create =  Blog::create([
                'title' => $title,
                'image' => $file,
                'content' =>  $blogContent,
            ]);

            if($create){
                return response()->json(['message' => 'Blog created successfully',  'status' => 1]);
            }else{
                return response()->json(['message' => 'Whoops! Something went wrong. Not able to create blog.',  'status' => 2]);
            }

        }


    }
}
