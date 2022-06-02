<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\AuthorizedOfficer;
use App\Models\Registration;
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
            'firstname' => 'required | string',
            'lastname' => 'required | string',
            'email' => 'required | email | unique:authorized_officers',
            'phone' => 'required | numeric ',
            'dob' => 'required',
            'ssn' => 'required | numeric',
            'citizenship_of_country' => 'required',
            'percentage_of_ownership' => 'required | numeric',
            'street' => 'required',
            'city' => 'required | string',
            'state' => 'required | string',
            'zip_code' => 'required | numeric'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Registration failed. '.$validator->errors()->first(), null, 'null', 400);
        }else{
            $check_phone_no_exist = AuthorizedOfficer::where('phone', $request->phone)->exists();

            $check_ssn_exist_in_caregiver = Registration::where('ssn', $request->ssn)->exists();
            $check_ssn_exist_in_agency = AuthorizedOfficer::where('ssn', $request->ssn)->exists();

            if($check_phone_no_exist == true){
                return $this->error('Phone number already exists.', null, 'null', 403);
            }else if($check_ssn_exist_in_caregiver == true && $check_ssn_exist_in_agency == true){
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

    public function editAuthorizedOfficer(Request $request){
        $validator = Validator::make($request->all(),[
            'firstname' => 'required | string',
            'lastname' => 'required | string',
            'email' => 'required | email ',
            'phone' => 'required | digits | exists:authorized_officers,phone',
            'dob' => 'required',
            'ssn' => 'required | numeric',
            'citizenship_of_country' => 'required',
            'percentage_of_ownership' => 'required | numeric',
            'street' => 'required',
            'city' => 'required | string',
            'state' => 'required | string',
            'zip_code' => 'required | numeric'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Failed to update authorized officer. '.$validator->errors()->first(), null, 'null', 400);
        }else{
            $check_ssn_exist_in_caregiver = Registration::where('ssn', $request->ssn)->exists();
            $check_ssn_exist_in_agency = AuthorizedOfficer::where('ssn', $request->ssn)->exists();

            if($check_ssn_exist_in_caregiver == true && $check_ssn_exist_in_agency == true){
                return $this->error('Social Security Number already exists.', null, 'null', 403);
            }else{
                $update = AuthorizedOfficer::where('id',$request->authorized_officer_id)->where('user_id', auth('sanctum')->user()->id)->update([
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
                ]);
        
                if($update){
                    return $this->success('Authorized information updated successfully.', null, 'null', 200);
                }else{
                    return $this->error('Whoops! Something went wrong.', null,' null', 500);
                }
            }
            
        }
    }

    public function getAuthorizedOfficer(Request $request){
        $authorized_details = AuthorizedOfficer::where('user_id', auth('sanctum')->user()->id)->orderBy('created_at','DESC')->get();
        return $this->success('Authorized officer details.', $authorized_details, 'null', 200);
    }

    public function deleteAuthorizedOfficer(Request $request){
        $count_officers = AuthorizedOfficer::where('user_id', auth('sanctum')->user()->id)->count();
        if($count_officers > 1){
            $delete = AuthorizedOfficer::where('id', $request->authorized_officer_id)->where('user_id', auth('sanctum')->user()->id)->delete();
            if($delete){
                $authorized_details = AuthorizedOfficer::where('user_id', auth('sanctum')->user()->id)->orderBy('created_at','DESC')->get();
                return $this->success('Authorized officer deleted successfully.',  $authorized_details, 'null', 200);
            }else{
                return $this->error('Whoops! Something went wrong.',  null, 'null', 500);
            }
        }else{
            return $this->success('Whoops! Cannot delete authorized officer. Atleast one officer need to be present.',  null, 'null', 200);
        }
    }
}
