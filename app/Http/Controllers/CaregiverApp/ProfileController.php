<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Registration;
use App\Models\User;
use App\Traits\ApiResponser;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use ApiResponser;
    public function index(Request $request){
        $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
        $dobFormat = $diff = date_diff(date_create( $details->profile->dob), date_create(date('Y-m-d')));
        $profile = [
            'firstname' => $details->firstname,
            'lastname' => $details->lastname,
            'profile_image' => $details->profile->profile_image,
            'work_type' => $details->profile->work_type,
            'rating' => $details->profile->rating,
            'experience' => $details->profile->experience,
            'age' =>  $dobFormat->format('%y'),
            'total_care_completed' => $details->profile->total_care_completed,
            'total_reviews' => $details->profile->total_reviews,
        ];
        return $this->success('Profile Details.', $profile, 'null', 200);
    }

    public function editProfile(Request $request){

        $validator = Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'ssn' => 'required',
            'gender' => 'required',
        ],[
            'firstname.required' => 'Firstname cannot be empty.',
            'lastname.required' => 'Lastname cannot be empty.',
            'phone.required' => 'Phone number is required. Please enter a valid phone number.',
            'dob.required' => 'Date of Birth is required. Please enter a valid dob.',
            'ssn.required' => 'Social Security Number is required. Please enter a valid SSN.',
            'gender.required' => 'Gender is required. Please select appropriate gender.',
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Profile not updated.', $validator->errors(), 'null', 400);
        }else{
            $updateUser = User::where('id', auth('sanctum')->user()->id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname
            ]);

            $updateReg = Registration::where('user_id', auth('sanctum')->user()->id)->update([
                'phone' => $request->phone,
                'dob' => DateTime::createFromFormat('m-d-Y',$request->dob),
                'ssn' => $request->ssn,
                'gender' => $request->gender,
                'bio' => $request->bio,
                'experience' => $request->experience,
                'work_type' => $request->work_type
            ]);

            if(($updateUser ==  true) && ($updateReg == true)){
                return $this->success('Profile updated successfully', null, 'null', 201);
            }else{
                return $this->success('Whoops!, Updated failed', null, 'null', 200);
            }
            
        }
    }


    public function getBio(Request $request){
        $details = Registration::where('user_id', auth('sanctum')->user()->id)->first();
        return $this->success('Bio details', $details->bio, 'null', 200);
    }

    public function getAddress(Request $request){
        $details = Registration::where('user_id', auth('sanctum')->user()->id)->first();
        return $this->success('Address details', $details->address, 'null', 200);
    }

    public function editAddress(Request $request){
        $update = Registration::where('user_id', auth('sanctum')->user()->id)->update([
            'address' => $request->address
        ]);

        if($update){
            return $this->success('Address updated successfully', null, 'null', 201);
        }else{
            return $this->success('Whoops!, Updated failed', null, 'null', 200);
        }
    }

    public function getEducation(Request $request){
        $details = Education::where('user_id', auth('sanctum')->user()->id)->get();
        return $this->success('Address details', $details, 'null', 200);
    }


    public function editEducation(Request $request){

        $validator = Validator::make($request->all(),[
            'institution' => 'required',
            'course' =>  'required',
            'city' =>  'required',
            'state' =>  'required',
            'duration' =>  'required',
            'grade_percentage' =>  'required',
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Profile not updated.', $validator->errors(), 'null', 400);
        }else{
            $education = Education::where('id', $request->id)->where('user_id', auth('sanctum')->user()->id)->exists();

            if($education){
                $update = Education::where('id', $request->id)->where('user_id', auth('sanctum')->user()->id)->update([
                    'institution' => $request->institution ,
                    'course' => $request->course,
                    'city' => $request->city,
                    'state' => $request->state,
                    'duration' => $request->duration,
                    'grade_percentage' => $request->grade_percentage,
                ]);
    
                if($update){
                    return $this->success('Education updated successfully', null, 'null', 201);
                }else{
                    return $this->success('Whoops!, Updated failed', null, 'null', 200);
                }
            }else{
                
                $create = Education::create([
                    'institution' => $request->institution ,
                    'course' => $request->course,
                    'city' => $request->city,
                    'state' => $request->state,
                    'duration' => $request->duration,
                    'grade_percentage' => $request->grade_percentage,
                    'user_id' => auth('sanctum')->user()->id
                ]);

                if($create){
                    return $this->success('Education added successfully', null, 'null', 201);
                }else{
                    return $this->success('Whoops!, Updated failed', null, 'null', 200);
                }
                
            }
        }
    }
}
