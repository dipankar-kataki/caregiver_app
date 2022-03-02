<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Mail\SendPasswordConfirmationMail;
use App\Mail\SendResetPasswordLink;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    use ApiResponser;
    public function sendResetLink(Request $request){
        // return view('mail.reset-password-template');
        $validator = Validator::make($request->all(),[
            'email' => 'required | email'
        ],[
            'email.required' => 'Email is required. Please enter a valid email.',
        ]);

        if($validator->fails()){
            return $this->error('Failed to send email.', $validator->errors(), 'null', 400);
        }else{
            $details = User::where('email', $request->email)->first();
            if($details == null){
                return $this->error('Failed to send email. User not found.', $validator->errors(), 'null', 400);
            }else{
                $name = $details->firstname.' '.$details->lastname;
                $otp = rand(100000, 999999);
                Cache::put('otp', $otp, now()->addMinutes(5));
                Mail::to($request->email)->send(new SendResetPasswordLink($name, $otp));
                return $this->success('Otp sent successfully to email.', null, 'null', 200);
            }
           
        }
    }

    public function updatePassword(Request $request){
        $otp = $request->otp;
        $password = $request->password;
        $validator = Validator::make($request->all(),[
            'otp' => 'required',
            'email' => 'required',
            'password' => 'required',
        ],[
            'otp.required' => 'OTP is required. Please enter a valid otp.',
            'password.required' => 'Please enter a strong password.'
        ]);

        if($validator->fails()){
            return $this->error('Failed to reset password.', $validator->errors(), 'null', 400);
        }else{
            if(Cache::get('otp') != $otp){
                return $this->error('Failed to reset password. Invalid OTP.', null, 'null', 400);
            }else{
               $details = User::where('email', $request->email)->first();
                if($details == null){
                    return $this->error('Failed to reset password. Something went wrong. Not a valid user', null, 'null', 400);
                }else{
                    $update = User::where('email', $request->email)->update([
                        'password' => Hash::make($password)
                    ]);
                    if($update){
                        Cache::forget('otp');
                        Mail::to($request->email)->send(new SendPasswordConfirmationMail() );
                        return $this->success('Password changed successfully.', null, 'null', 200);
                    }else{
                        return $this->error('Whoops! Something went wrong. Failed to reset password.', null, 'null', 400);
                    }
               }
            }
        }
    }
}
