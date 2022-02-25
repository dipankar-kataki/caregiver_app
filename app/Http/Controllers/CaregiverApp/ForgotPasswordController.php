<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use ApiResponser;
    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required | email'
        ],[
            'email.required' => 'Email is required. Please enter a valid email.',
        ]);

        if($validator->fails()){
            return $this->error('Failed to send otp to email.', $validator->errors(), 'null', 400);
        }else{
            return $this->success('Otp sent successfully to email.', $request->all(), 'null', 200);
        }
    }
}
