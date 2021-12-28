<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class SignUpController extends Controller
{
    use ApiResponser;

    public function signup(Request $request){
       
        $validator = Validator::make($request->all(),[
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ],[
                'firstname.required' => 'First Name is required',
                'lastname.required' => 'Last Name is required',
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
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
                if($create){
                    return $this->success( 'Signup Successful', null , 'null', 201);
                }else{
                    return $this->error('Something went wrong', null , 'null',500);
                }
            }
        }
    }
}
