<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\GetInTouchMail;
use Exception;
use Illuminate\Support\Facades\Mail;

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

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        try {
            Mail::to('alok.deka@ekodus.com')->send(new GetInTouchMail($details));
            $icon = "success";
            $title = "Success";
            $text = "Email is sent";
        } catch (Exception $e) {
            $icon = "error";
            $title = "Error";
            $text = $e;
        }

        return response()->json([
            'icon' => $icon,
            'title' => $title,
            'text' => $text
        ]);
    }

    public function blogs(Request $request, $id = null)
    {
        if (!$id) {
            return view('site.blog.index');
        } else {
            return view('site.blog.blogDetails');
        }
    }
}
