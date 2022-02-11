<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        if($request->isMethod('get')){
            if (Auth::user()) {   // Check is user logged in
                return redirect()->route('admin.dashboard');
            } else {
                return view('admin.login');
            }
        } else{
            $validated = $request->validate([
                'email' => 'required|max:255',
                'password' => 'required',
            ],[
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]);

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return redirect()->back()->with('error', 'Invalid Credientials');   
            }else{
                return redirect()->route('admin.dashboard');
            }
        }
    }

    public function logout(Request $request){
        Auth::logout(); 
        $request->session()->invalidate();     
        $request->session()->regenerateToken();     
        return redirect()->route('auth.login');
    }
}
