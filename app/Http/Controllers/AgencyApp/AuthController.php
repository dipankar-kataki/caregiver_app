<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;
    public function signup(Request $request){

        $validator = Validator::make($request->all(),[
            'business_name' => 'required',
            'email' => 'required|email',
            'password' => 'required | min:6',
        ],[
            'business_name.required' => 'Business Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ]);

        if($validator->fails()){
            return $this->error('Signup failed. Incomplete data insertion.', $validator->errors(),'null', 400);
        }else{
            $check_user_exists = User::where('email',$request->email)->exists();
            if($check_user_exists == true){
                return $this->error('Email already exists with another user.', null , 'null', 409);
            }else{
                $create = User::create([
                    'business_name' => $request->business_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 3
                ]);
                $token = $create->createToken('auth_token')->plainTextToken;
                if($create){
                    return $this->success( 'Signup Successful', null , $token, 201);
                }else{
                    return $this->error('Something went wrong', null , 'null', 500);
                }
            }
        }
    }

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
            if ( ! Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 3]) )
            {
                return $this->error('Invalid credentials. User unauthorized',null, 'null', 401);
            }else{
                $user = User::where('email', $request->email)->firstOrFail();
                $token = $user->createToken('auth_token')->plainTextToken;
                $details = [
                    'business_name' => $user->business_name,
                    'email' => $user->email,
                    'is_business_info_added' => $user->is_business_info_added,
                    'is_authorize_info_added' => $user->is_authorize_info_added,
                    'is_user_approved' => $user->is_user_approved
                ];

                return $this->success( 'Login Successful', $details , $token, 200);
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
                $details = User::where('id', auth('sanctum')->user()->id)->where('role', 3)->first();
                if(! (Hash::check($request->old_password, $details->password))){
                    return $this->error('Enter a valid password.', null, 'null', 400);
                }else{
                    
                    $update = User::where('id', auth('sanctum')->user()->id)->where('role', 3)->update([
                        'password' => Hash::make($request->confirm_password)
                    ]);

                    if($update){
                        return $this->success('Password changed successfully.', null, 'null', 200);
                    }else{
                        return $this->error('Whoops! Something went wrong. Failed to change password.', null, 'null', 400);
                    }
                }
            }
        }
    }
}
