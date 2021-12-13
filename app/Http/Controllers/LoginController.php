<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            return $this->error('Login failed. Incomplete data insertion.', $validator->errors(), 400);
        }else{
            if ( ! Auth::attempt(['email' => $request->email, 'password' => $request->password]) )
            {
                return $this->error('Invalid credentials. User unauthorized',null,401);
            }else{
                $user = User::where('email', $request->email)->firstOrFail();
                $token = $user->createToken('auth_token')->plainTextToken;
                return $this->success( 'Login Successful', $user , $token, 200);
            }
        }
    }
    

    public function logout(){
       Auth::user()->tokens()->delete();
        return $this->success( 'Logout Successful', null , null , 200);
    }
}
