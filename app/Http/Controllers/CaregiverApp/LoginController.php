<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendPasswordConfirmationMail;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    use ApiResponser;
    public function login(Request $request){
        
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ]);

        if($validator->fails()){
            return $this->error('Login failed. Incomplete data insertion.', $validator->errors(), 'null', 400);
        }else{
            if ( ! Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 2]) )
            {
                return $this->error('Invalid credentials. User unauthorized',null, 'null', 401);
            }else{
                $user = User::where('email', $request->email)->firstOrFail();

                if($user->is_logged_in == 1){
                    auth()->user()->tokens()->delete();
                    
                    $token = $user->createToken('auth_token')->plainTextToken;
                    $details = [
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'email' => $user->email,
                        'is_registration_completed' => $user->is_registration_completed,
                        'is_questions_answered' => $user->is_questions_answered,
                        'is_documents_uploaded' => $user->is_documents_uploaded,
                        'is_user_approved' => $user->is_user_approved
                    ];
                    return $this->success( 'Login Successful', $details , $token, 200);
                }else{
                    $token = $user->createToken('auth_token')->plainTextToken;
                    $details = [
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'email' => $user->email,
                        'is_registration_completed' => $user->is_registration_completed,
                        'is_questions_answered' => $user->is_questions_answered,
                        'is_documents_uploaded' => $user->is_documents_uploaded,
                        'is_user_approved' => $user->is_user_approved
                    ];
                    User::where('email', $request->email)->update([
                        'is_logged_in' => 1
                    ]);
                    return $this->success( 'Login Successful', $details , $token, 200);
                }
               
            }
        }
    }


    public function changePassword(Request $request){

        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Not able to change password', $validator->errors(), 'null', 400);
        }else{
            if($request->new_password != $request->confirm_password){
                return $this->error('Whoops! Confirm password not matched.', null, 'null', 400);
            }else{
                $details = User::where('id', auth('sanctum')->user()->id)->where('role', 2)->first();
                if(! (Hash::check($request->old_password, $details->password))){
                    return $this->error('Invalid old password.', null, 'null', 400);
                }else{
                    
                    $update = User::where('id', auth('sanctum')->user()->id)->where('role', 2)->update([
                        'password' => Hash::make($request->confirm_password)
                    ]);

                    if($update){
                        Mail::to(auth('sanctum')->user()->email)->send(new SendPasswordConfirmationMail() );
                        return $this->success('Password changed successfully.', null, 'null', 200);
                    }else{
                        return $this->error('Whoops! Something went wrong. Failed to change password.', null, 'null', 400);
                    }
                }
            }
        }
    }
}
