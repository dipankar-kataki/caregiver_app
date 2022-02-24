<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('site.index');
    }

    public function contact(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ],
            [
                'name.required' => 'Please enter your name',
                'email.required' => 'Please enter your email',
                'subject.required' => 'Please enter subject',
                'message.required' => 'Please enter your message',
            ]
        );

        return response()->json([
			'icon' => 'Success',
			'title' => 'Success',
			'text' => 'Your query has been submitted'
		]);
    }

    public function blogs(Request $request, $id=null){
        if(!$id){
            return view('site.blog.index');
        } else{
            return view('site.blog.blogDetails');
        }
    }
}
