<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        if($request->isMethod('get')){
            if (Auth::user()) {   // Check is user logged in
                return redirect()->route('admin.dashboard.home');
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
                return redirect()->route('admin.dashboard.home');
            }
        }
    }

    public function logout(Request $request){
        Auth::logout(); 
        $request->session()->invalidate();     
        $request->session()->regenerateToken();     
        return redirect()->route('auth.login');
    }

    public function getSetting(){
        return view('admin.setting.get-setting');
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => 'Whoops! Something went wrong.', 'error' => $validator->errors()]);
        }else{
            $password = User::where('id', Auth::user()->id)->first();
            if ( ! Hash::check($request->oldPassword, $password->password)) {
               return response()->json(['message' => 'Whoops! Old password not matched.', 'status' => 2]);
            }else{
                if($request->newPassword != $request->confirmPassword){
                    return response()->json(['message' => 'Whoops! Confirm password not matched.', 'status' => 2]);
                }else{
                    $update = User::where('id', Auth::user()->id)->update([
                        'password' => Hash::make($request->newPassword)
                    ]);
                    if($update){
                        return response()->json(['message' => 'Password updated successfully', 'status' => 1]);
                    }else{
                        return response()->json(['message' => 'Whoops! Something went wrong. Failed to update password.', 'status' => 2]);
                    }
                }
            }
        }
    }

    public function updateBasicInfo(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required | email'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Whoops! Something went wrong.', 'error' => $validator->errors()]);
        }else{
            $update = User::where('id', Auth::user()->id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email
            ]);

            if($update){
                return response()->json(['message' => 'Basic information updated successfully', 'status' => 1]);
            }else{
                return response()->json(['message' => 'Whoops! Something went wrong. Failed to update password.', 'status' => 2]);
            }
        }
    }
}
