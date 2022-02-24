<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Registration;
use App\Models\User;
use App\Traits\ApiResponser;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    use ApiResponser;
    public function registration(Request $request){
        $phone = $request->phone;
        $dob = $request->dob;
        $ssn = $request->ssn;
        $gender = $request->gender;
        $street = $request->street;
        $city = $request->city;
        $state = $request->state;
        $zip_code = $request->zip_code;

        $validator = Validator::make($request->all(),[
            'phone' => 'required',
            'dob' => 'required',
            'ssn' => 'required',
            'gender' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required'
        ],[
            'phone.required' => 'Phone number is required. Please enter a valid phone number.',
            'dob.required' => 'Date of Birth is required. Please enter a valid dob.',
            'ssn.required' => 'Social Security Number is required. Please enter a valid SSN.',
            'gender.required' => 'Gender is required. Please select appropriate gender.',
            'street.required' => 'Street is required. Please enter a valid street address.',
            'city.required' => 'City is required. Please enter a valid city.',
            'state.required' => 'State is required. Please enter a valid state.',
            'zip_code.required' => 'Zip Code is required. Please enter a valid zip code.',
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
                $createReg = Registration::create([
                    'phone' => $phone,
                    'dob' => DateTime::createFromFormat('m-d-Y',$dob),
                    'ssn' => $ssn,
                    'gender' => $gender,
                    'user_id' => auth('sanctum')->user()->id
                ]);

                $createAdd = Address::create([
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'user_id' => auth('sanctum')->user()->id
                ]);


    
                if($createReg && $createAdd){
                    User::where('id', auth('sanctum')->user()->id )->update([
                        'is_registration_completed' => 1
                    ]);
                    
                    return $this->success('Registration successful.', null, 'null', 201);
                }else{
                    return $this->error('Whoops! Something went wrong. Registration unsuccessful.', null,' null', 500);
                }
            }
        }
    }
}
