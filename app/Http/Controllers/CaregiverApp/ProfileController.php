<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Registration;
use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use ApiResponser;
    public function index(Request $request){
        $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
        $reg = '';
        $question = '';
        $docs = '';

        if($details->is_registration_completed == 0){
            $reg = 0;
        }else{
            $reg = 30;
        }

        if($details->is_questions_answered == 0){
            $question = 0;
        }else{
            $question = 30;
        }

        if($details->is_documents_uploaded == 0){
            $docs = 0;
        }else{
            $docs = 30;
        }
        $total_percet_sum = ($reg + $question + $docs) + 10;
        $total_profile_percentage = ($total_percet_sum / 100 ) * 100;

        if(($details != null ) && ($details->profile == null)){
            $profile = [
                'firstname' => $details->firstname,
                'lastname' => $details->lastname,
                'total_percent' =>  $total_profile_percentage
            ];
            return $this->success('Profile Details.', $profile, 'null', 200);
        }else{
            $dobFormat = $diff = date_diff(date_create( $details->profile->dob), date_create(date('Y-m-d')));
            $profile = [
                'firstname' => $details->firstname,
                'lastname' => $details->lastname,
                'profile_image' => $details->profile->profile_image,
                'bio' => $details->profile->bio,
                'work_type' => $details->profile->work_type,
                'rating' => $details->profile->rating,
                'experience' => $details->profile->experience,
                'age' =>  $dobFormat->format('%y'),
                'total_care_completed' => $details->profile->total_care_completed,
                'total_reviews' => $details->profile->total_reviews,
                'total_percent' =>  $total_profile_percentage
            ];
            return $this->success('Profile Details.', $profile, 'null', 200);
        }
    }

    public function editProfile(Request $request){

        $validator = Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'ssn' => 'required',
            'gender' => 'required',
            'bio' => 'required',
            'experience' => 'required',
            'work_type' => 'required'
        ],[
            'firstname.required' => 'Firstname cannot be empty.',
            'lastname.required' => 'Lastname cannot be empty.',
            'phone.required' => 'Phone number is required. Please enter a valid phone number.',
            'dob.required' => 'Date of Birth is required. Please enter a valid dob.',
            'ssn.required' => 'Social Security Number is required. Please enter a valid SSN.',
            'gender.required' => 'Gender is required. Please select appropriate gender.',
            'bio' => 'Bio is required',
            'experience' => 'Experience is required',
            'work_type' => 'Work type is required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Profile not updated.', $validator->errors(), 'null', 400);
        }else{
            $updateUser = User::where('id', auth('sanctum')->user()->id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname
            ]);

            $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
            $check_phone_no_exist = Registration::where('phone', $request->phone)->where('user_id', '!=', auth('sanctum')->user()->id)->exists();
            $check_ssn_exist = Registration::where('ssn', $request->ssn)->where('user_id', '!=', auth('sanctum')->user()->id)->exists();

            if($check_phone_no_exist == true){
                return $this->error('Phone number already exists.', null, 'null', 403);
            }else if($check_ssn_exist == true){
                return $this->error('Social Security Number already exists.', null, 'null', 403);
            }else{
                if($details->profile == null){
                    $create = Registration::create([
                        'phone' => $request->phone,
                        'dob' => DateTime::createFromFormat('m-d-Y',$request->dob),
                        'ssn' => $request->ssn,
                        'gender' => $request->gender,
                        'bio' => $request->bio,
                        'experience' => $request->experience,
                        'work_type' => $request->work_type,
                        'user_id' => auth('sanctum')->user()->id
        
                    ]);
    
                    if($create){
                        $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
                        $profile = [
                            'bio' => $details->profile->bio ,
                            'firstname' => $details->firstname,
                            'lastname' => $details->lastname,
                            'gender' => $details->profile->gender,
                            'dob' => Carbon::parse($details->profile->dob)->format('m-d-Y'),
                            'phone' => $details->profile->phone,
                            'ssn' => $details->profile->ssn,
                            'experience' => $details->profile->experience,
                            'work_type' => $details->profile->work_type
                        ];
    
                        if(($details->is_registration_completed == 0) && ($details->profile->address != null)){
                            User::where('id', auth('sanctum')->user()->id )->update([
                                'is_registration_completed' => 1
                            ]);
                        }else{
                            User::where('id', auth('sanctum')->user()->id )->update([
                                'is_registration_completed' => 0
                            ]);
                        }
                        return $this->success('Profile updated successfully', $profile, 'null', 201);
                    }else{
                        return $this->error('Whoops!, Updated failed', null, 'null', 200);
                    }
                }else{
                    $updateReg = Registration::where('user_id', auth('sanctum')->user()->id)->update([
                        'phone' => $request->phone,
                        'dob' => DateTime::createFromFormat('m-d-Y',$request->dob),
                        'ssn' => $request->ssn,
                        'gender' => $request->gender,
                        'bio' => $request->bio,
                        'experience' => $request->experience,
                        'work_type' => $request->work_type
                    ]);
    
                    $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
                    if(($updateUser ==  true) && ($updateReg == true)){
                        $profile = [
                            'bio' => $details->profile->bio ,
                            'firstname' => $details->firstname,
                            'lastname' => $details->lastname,
                            'gender' => $details->profile->gender,
                            'dob' => Carbon::parse($details->profile->dob)->format('m-d-Y'),
                            'phone' => $details->profile->phone,
                            'ssn' => $details->profile->ssn,
                            'experience' => $details->profile->experience,
                            'work_type' => $details->profile->work_type
                        ];
                        if(($details->is_registration_completed == 0) && ($details->profile->address != null)){
                            User::where('id', auth('sanctum')->user()->id )->update([
                                'is_registration_completed' => 1
                            ]);
                        }else{
                            User::where('id', auth('sanctum')->user()->id )->update([
                                'is_registration_completed' => 0
                            ]);
                        }
                        return $this->success('Profile updated successfully', $profile, 'null', 201);
                    }else{
                        return $this->error('Whoops!, Updated failed', null, 'null', 200);
                    }
                }
            }
            
        }
    }

    public function getBasicDetails(){

        $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
        if(($details != null ) && ($details->profile == null)){
            $profile = [
                'firstname' => $details->firstname,
                'lastname' => $details->lastname,
            ];
            return $this->success('Profile Details.', $profile, 'null', 200);
        }else{
            $profile = [
                'bio' => $details->profile->bio,
                'firstname' => $details->firstname,
                'lastname' => $details->lastname,
                'gender' => $details->profile->gender,
                'dob' => Carbon::parse($details->profile->dob)->format('m-d-Y'),
                'phone' => $details->profile->phone,
                'ssn' => $details->profile->ssn,
                'experience' => $details->profile->experience,
                'work_type' => $details->profile->work_type
            ];
            return $this->success('Profile Details.', $profile, 'null', 200);
        }
    }

    public function uploadProfilePhoto(Request $request){
        $validator = Validator::make($request->all(), [
            'profilePic' => 'required|image|mimes:jpg,png,jpeg|max:1024'
        ],[
            'profilePic.required' => 'Please choose an image to upload.'
        ]);

        if($validator->fails()){
            return $this->error('Whoops!, Updated failed', $validator->errors(), 'null', 200);
        }else{
            $profilePic = $request->profilePic;
            $file = '';

            if($request->hasFile('profilePic')){
                $new_name = date('d-m-Y-H-i-s') . '_' . $profilePic->getClientOriginalName();
                $profilePic->move(public_path('caregiver-app/profile/'), $new_name);
                $file = 'caregiver-app/profile/' . $new_name;
            }

            $update = Registration::where('user_id', auth('sanctum')->user()->id)->update([
                'profile_image' => $file
            ]);

            

            if($update){
                return $this->success('Profile image updated successfully', ['profile_image' => $file], 'null', 201);
            }else{
                return $this->error('Whoops!, Failed to add profile image', null, 'null', 200);
            }
        }
    }


    public function getBio(Request $request){
        $details = Registration::where('user_id', auth('sanctum')->user()->id)->first();
        if($details == null){
            return $this->error('Whoops!, No details found.', null, 'null', 400);
        }else{
            return $this->success('Bio details', $details->bio, 'null', 200);
        }
    }

    public function getAddress(Request $request){
        $details = Registration::where('user_id', auth('sanctum')->user()->id)->first();
        if($details == null){
            return $this->success('Whoops!, No details found.', null, 'null', 400);
        }else{
            return $this->success('Address details', $details->address, 'null', 200);
        }
    }

    public function editAddress(Request $request){

        $validator = Validator::make($request->all(),[
            'address' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops!, Updated failed', $validator->errors(), 'null', 200);
        }else{
            $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
            if($details->profile == null){
                $create = Registration::create([
                    'address' => $request->address,
                    'user_id' => auth('sanctum')->user()->id
                ]);
                if($create){

                    $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
                    $address = [
                        'address' => $details->profile->address
                    ];
                    if((($details->profile->phone == null) || ($details->profile->gender == null) || ($details->profile->dob == null) || ($details->profile->ssn == null)) && ($details->is_registration_completed == 0) ){
                        User::where('id', auth('sanctum')->user()->id )->update([
                            'is_registration_completed' => 0
                        ]);
                    }else{
                        User::where('id', auth('sanctum')->user()->id )->update([
                            'is_registration_completed' => 1
                        ]);
                    }
                    return $this->success('Address updated successfully', $address, 'null', 201);
                }
            }else{
                $update = Registration::where('user_id', auth('sanctum')->user()->id)->update([
                    'address' => $request->address
                ]);
                if($update){
                
                    $details = User::with('profile')->where('id',auth('sanctum')->user()->id)->first();
                    $address = [
                        'address' => $details->profile->address
                    ];
                    if((($details->profile->phone == null) || ($details->profile->gender == null) || ($details->profile->dob == null) || ($details->profile->ssn == null)) && ($details->is_registration_completed == 0) ){
                        User::where('id', auth('sanctum')->user()->id )->update([
                            'is_registration_completed' => 0
                        ]);
                    }else{
                        User::where('id', auth('sanctum')->user()->id )->update([
                            'is_registration_completed' => 1
                        ]);
                    }
                    return $this->success('Address updated successfully', $address, 'null', 201);
                }else{
                    return $this->error('Whoops!, Updated failed', null, 'null', 200);
                }
            }
        }
        
    }

    public function getEducation(Request $request){
        $details = Education::where('user_id', auth('sanctum')->user()->id)->get();
        if($details == null){
            return $this->error('Whoops!, No details found.', null, 'null', 400);
        }else{
            return $this->success('Education details', $details, 'null', 200);
        }
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
                    $details = Education::where('user_id', auth('sanctum')->user()->id)->get();
                    return $this->success('Education updated successfully', $details, 'null', 201);
                }else{
                    return $this->error('Whoops!, Updated failed', null, 'null', 200);
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
                    $details = Education::where('user_id', auth('sanctum')->user()->id)->get();
                    return $this->success('Education added successfully', $details, 'null', 201);
                }else{
                    return $this->error('Whoops!, Updated failed', null, 'null', 200);
                }
                
            }
        }
    }

    public function profileCompletionStatus(){
        $details = User::where('id',auth('sanctum')->user()->id)->first();
        $profile_completion_status = [
            'is_registration_completed' => $details->is_registration_completed,
            'is_questions_answered' => $details->is_questions_answered,
            'is_documents_uploaded' => $details->is_documents_uploaded,
            
        ];

        return $this->success('Profile completion status fetched successfully.', $profile_completion_status, 'null', 200);
    }
}
