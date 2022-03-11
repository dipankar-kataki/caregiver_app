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
}
