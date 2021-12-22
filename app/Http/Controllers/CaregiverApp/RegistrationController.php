<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    use ApiResponser;
    public function registration(Request $request){
        $phone = $request->phone;
        $dob = date_create($request->dob);
        $ssn = $request->ssn;
        $gender = $request->gender;
        $address = $request->address;

        $validator = Validator::make($request->all(),[
            'phone' => 'required',
            'dob' => 'required',
            'ssn' => 'required',
            'gender' => 'required',
            'address' => 'required'
        ],[
            'phone.required' => 'Phone number is required. Please enter a valid phone number.',
            'dob.required' => 'Date of Birth is required. Please enter a valid dob.',
            'ssn.required' => 'Social Security Number is required. Please enter a valid SSN.',
            'gender.required' => 'Gender is required. Please select appropriate gender.',
            'address.required' => 'Address is required. Please enter a valid address.'
        ]);

        if($validator->fails()){
            return $this->error('Registration failed.', $validator->errors(), 'null', 400);
        }else{
            $check_phone_no_exist = Registration::where('phone', $phone)->exists();
            $check_ssn_exist = Registration::where('ssn', $ssn)->exists();

            if($check_phone_no_exist == true){
                return $this->error('Phone number already exists.', null, 'null', 403);
            }else if($check_ssn_exist == true){
                return $this->error('Social Security Number already exists.', null, 'null', 403);
            }else{
                $create = Registration::create([
                    'phone' => $phone,
                    'dob' => date_format($dob,'Y-m-d'),
                    'ssn' => $ssn,
                    'gender' => $gender,
                    'address' => $address,
                    'user_id' => auth('sanctum')->user()->id
    
                ]);
    
                if($create){
                    return $this->success('Registration successful.', null, 'null', 201);
                }else{
                    return $this->error('Whoops! Something went wrong. Registration unsuccessful.', null,' null', 500);
                }
            }
        }
    }
}
