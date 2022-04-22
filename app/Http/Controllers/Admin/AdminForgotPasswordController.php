<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminSendPasswordChangeConfirmation;
use App\Mail\AdminSendResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request){
        return view('admin.forgot-password.forgot-password');
    }

    public function sendResetLink(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required | email'
        ],[
            'email.required' => 'Email is required. Please enter a valid email.',
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Whoops! Something went wrong.', 'error' => $validator->errors()]);
        }else{
            $details = User::where('email', $request->email)->where('role', 1)->first();
            if($details == null){
                return response()->json(['message' => 'Whoops! User not found.', 'status' => 400]);
            }else{
                $name = $details->firstname.' '.$details->lastname;
                
                $otp = rand(100000, 999999);
                Cache::put('otp', $otp, now()->addMinutes(5));
                Mail::to($request->email)->queue(new AdminSendResetPasswordMail($name, $otp));
                return response()->json(['message' => 'Reset email sent successfully.', 'status' => 200]);
            }
           
        }
    }


    public function verifyOtp(Request $request){

        $validator = Validator::make($request->all(),[
            'otp_val_1' => 'required',
            'otp_val_2' => 'required',
            'otp_val_3' => 'required',
            'otp_val_4' => 'required',
            'otp_val_5' => 'required',
            'otp_val_6' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Whoops! Something went wrong. Failed to verify OTP.', 'error' => 'OTP is required'  ]);
        }else{
            $otp = $request->otp_val_1.$request->otp_val_2.$request->otp_val_3.$request->otp_val_4.$request->otp_val_5.$request->otp_val_6 ;
            if(Cache::get('otp') != $otp){
                return response()->json(['message' => 'Whoops! Failed to verify OTP.', 'status' => 400 ]);
            }else{
                Cache::forget('otp');
                return response()->json(['message' => 'OTP verified successfully.', 'status' => 200 ]);
            }
        }
    }

    public function changePassword(Request $request){
        $password = $request->password;
        $validator = Validator::make($request->all(),[
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Whoops! Failed to reset password.', 'error' => $validator->errors() ]);
        }else{
            $details = User::where('email', $request->email)->where('role', 1)->first();
            if($details == null){
                return response()->json(['message' => 'Failed to reset password. Not a valid user.', 'status' => 400]);
            }else{
                $update = User::where('email', $request->email)->update([
                    'password' => Hash::make($password)
                ]);
                if($update){
                    Mail::to($request->email)->send(new AdminSendPasswordChangeConfirmation() );
                    return response()->json(['message' => 'Password changed successfully.', 'status' => 200]);
                }else{
                    return response()->json(['message' => 'Whoops! Something went wrong. Failed to reset password.', 'status' => 500]);
                }
            }
        }
    }
}
