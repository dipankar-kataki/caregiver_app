<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Registration;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use ApiResponser;
    public function index(Request $request){
        $today = date('Y-m-d');
        $details = User::with('profile','education')->where('id',auth('sanctum')->user()->id)->first();
        $age = date_diff(date_create($details->profile->dob), date_create($today));
        $profile = [
            'firstname' => $details->firstname,
            'lastname' => $details->lastname,
            'work_type' => $details->profile->work_type,
            'rating' => $details->profile->rating,
            'experience' => $details->profile->experience,
            'age' =>  $age->format('%y'),
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
            'address' => 'required'
        ],[
            'firstname.required' => 'Firstname cannot be empty.',
            'lastname.required' => 'Lastname cannot be empty.',
            'phone.required' => 'Phone number is required. Please enter a valid phone number.',
            'dob.required' => 'Date of Birth is required. Please enter a valid dob.',
            'ssn.required' => 'Social Security Number is required. Please enter a valid SSN.',
            'gender.required' => 'Gender is required. Please select appropriate gender.',
            'address.required' => 'Address is required. Please enter a valid address.'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Profile not updated.', $validator->errors(), 'null', 400);
        }else{
            User::where('id', auth('sanctum')->user()->id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname
            ]);

            Registration::where('user_id', auth('sanctum')->user()->id)->update([
                'phone' => $request->phone,
                'dob' => date_create($request->dob),
                'ssn' => $request->ssn,
                'gender' => $request->gender,
                'address' => $request->address,
                'bio' => $request->bio,
                'experience' => $request->experience
            ]);

            $education = Education::where('id', $request->id)->where('user_id', auth('sanctum')->user()->id)->exists();

            if($education){
                Education::where('id', $request->id)->where('user_id', auth('sanctum')->user()->id)->update([
                    'institution' => $request->institution ,
                    'course' => $request->course,
                    'city' => $request->city,
                    'state' => $request->state,
                    'duration' => $request->duration,
                    'grade_percentage' => $request->grade_percentage,
                 ]);
            }else{
                if( ($request->institution != null) || ($request->institution != '')){
                    Education::create([
                        'institution' => $request->institution ,
                        'course' => $request->course,
                        'city' => $request->city,
                        'state' => $request->state,
                        'duration' => $request->duration,
                        'grade_percentage' => $request->grade_percentage,
                        'user_id' => auth('sanctum')->user()->id
                    ]);
                }
               
            }
            return $this->success('Profile updated successfully', null, 'null', 201);
        }
    }
}
