<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    public function signup(Request $request){
       
        $validator = Validator::make($request->all(),
            [
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
                return response()->json(['success' => 'false','error' => $validator->errors(), 'status' => 400]);
            }else{
                $create = User::create([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

                if($create){
                    return response()->json(['success' => 'true', 'message' => 'Signup successfull', 'status' => 201]);
                }else{
                    return response()->json(['success' => 'false', 'message' => 'Something went wrong. Signup failed', 'status' => 500]);
                }
            }
    }
}
