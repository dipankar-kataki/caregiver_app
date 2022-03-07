<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\AuthorizedOfficer;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Carbon\Carbon;

class AuthorizedOfficerController extends Controller
{
    use ApiResponser;
    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required | email | unique:authorized_officers',
            'phone' => 'required',
            'dob' => 'required',
            'ssn' => 'required',
            'citizenship_of_country' => 'required',
            'percentage_of_ownership' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Registration failed.', $validator->errors(), 'null', 400);
        }else{
            $check_phone_no_exist = AuthorizedOfficer::where('phone', $request->phone)->exists();
            $check_ssn_exist = AuthorizedOfficer::where('ssn', $request->ssn)->exists();

            if($check_phone_no_exist == true){
                return $this->error('Phone number already exists.', null, 'null', 403);
            }else if($check_ssn_exist == true){
                return $this->error('Social Security Number already exists.', null, 'null', 403);
            }else{

                $create = AuthorizedOfficer::create([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'dob' => DateTime::createFromFormat('m-d-Y',$request->dob),
                    'ssn' => $request->ssn,
                    'citizenship_of_country' => $request->citizenship_of_country,
                    'percentage_of_ownership' => $request->percentage_of_ownership,
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'user_id' => auth('sanctum')->user()->id
                ]);
    
                if($create){
                    User::where('id', auth('sanctum')->user()->id)->where('role', 3)->update([
                        'is_authorize_info_added' => 1
                    ]);
    
                    $authorized_details = AuthorizedOfficer::where('user_id', auth('sanctum')->user()->id)->get();
                    return $this->success('Authorized information added successfully.', $authorized_details, 'null', 201);
                }else{
                    return $this->error('Whoops! Something went wrong. Registration failed.', null,' null', 500);
                }
            }
        }
    }
}
