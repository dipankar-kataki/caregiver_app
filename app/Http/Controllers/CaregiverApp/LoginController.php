<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            return $this->error('Login failed. Incomplete data insertion.', $validator->errors(), 'null', 400);
        }else{
            if ( ! Auth::attempt(['email' => $request->email, 'password' => $request->password]) )
            {
                return $this->error('Invalid credentials. User unauthorized',null, 'null', 401);
            }else{
                $user = User::where('email', $request->email)->firstOrFail();
                $token = $user->createToken('auth_token')->plainTextToken;
                return $this->success( 'Login Successful', $user , $token, 200);
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
            return $this->error('Whoops! Not able to change password', $validator->errors(), 'null', 200);
        }else{
            if($request->new_password != $request->confirm_password){
                return $this->success('Whoops! Confirm password not matched.', null, 'null', 200);
            }else{
                $details = User::where('id', auth('sanctum')->user()->id)->first();
                if(! (Hash::check($request->old_password, $details->password))){
                    return $this->success('Whoops! Old password not matched with your active password.', null, 'null', 200);
                }else{
                    
                    $update = User::where('id', auth('sanctum')->user()->id)->update([
                        'password' => Hash::make($request->confirm_password)
                    ]);

                    if($update){
                        return $this->success('Password changed successfully.', null, 'null', 200);
                    }else{
                        return $this->success('Whoops! Something went wrong. Failed to change password.', null, 'null', 200);
                    }
                }
            }
        }
    }
}
