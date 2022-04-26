<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\AcceptedJob;
use App\Models\Answer;
use App\Models\Education;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\JobByAgency;
use App\Models\Question;
use App\Models\User;
use DateTime;
use Carbon\Carbon;

class CreateJobController extends Controller
{
    use ApiResponser;
    
    public function createJob(Request $request){
        $validator = Validator::make($request->all(),[
            'job_title' => 'required',
            'care_type' => 'required',
            'patient_age' => 'required',
            'amount_per_hour' => 'required',
            'start_date_of_care' => 'required',
            'end_date_of_care' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'job_description' => 'required',
        ]);
        if($validator->fails()){
            return $this->error('Whoops! Failed to create job.',  $validator->fails(), 'null', 400);
        }else{
            $user_approval = User::where('id', auth('sanctum')->user()->id)->first();
            if( $user_approval->is_user_approved == 0){
                return $this->error('Whoops! Failed to create job. Account not approved',  null, 'null', 400);
            }else{
                if($request->end_date_of_care == '' || $request->end_date_of_care == null){
                    $request->end_date_of_care = $request->start_date_of_care;
                }
    
                $create = JobByAgency::create([
                    'job_title' => $request->job_title,
                    'care_type' => $request->care_type,
                    'patient_age' => $request->patient_age,
                    'amount_per_hour' => $request->amount_per_hour,
                    'start_date_of_care' => DateTime::createFromFormat('m-d-Y',$request->start_date_of_care),
                    'end_date_of_care' => DateTime::createFromFormat('m-d-Y',$request->end_date_of_care),
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'job_description' => $request->job_description,
                    'medical_history' => serialize($request->medical_history),
                    'essential_prior_expertise' => serialize($request->essential_prior_expertise),
                    'other_requirements' => serialize($request->other_requirements),
                    'user_id' => auth('sanctum')->user()->id,
                    'is_activate' => 0,
                    'job_status' => 0
                ]);
                if($create){
                    $job_id = JobByAgency::where('user_id', auth('sanctum')->user()->id)->latest()->first();
                    return $this->success('Job posted successfully.',  $job_id->id, 'null', 201);
                }else{
                    return $this->error('Whoops! Something went wrong. Failed to post job.',  null, 'null', 500);
                }
            }
            
        }
    }

    public function editJob(Request $request){
        $validator = Validator::make($request->all(),[
            'job_title' => 'required',
            'care_type' => 'required',
            'patient_age' => 'required',
            'amount_per_hour' => 'required',
            'start_date_of_care' => 'required',
            'end_date_of_care' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'job_description' => 'required',
        ]);
        if($validator->fails()){
            return $this->error('Whoops! Failed to update job.',  $validator->fails(), 'null', 400);
        }else{

            if($request->end_date_of_care == '' || $request->end_date_of_care == null){
                $request->end_date_of_care = $request->start_date_of_care;
            }

            $update = JobByAgency::where('id', $request->job_id)->where('user_id', auth('sanctum')->user()->id)->where('is_activate', 1)->update([
                'job_title' => $request->job_title,
                'care_type' => $request->care_type,
                'patient_age' => $request->patient_age,
                'amount_per_hour' => $request->amount_per_hour,
                'start_date_of_care' => DateTime::createFromFormat('m-d-Y',$request->start_date_of_care),
                'end_date_of_care' => DateTime::createFromFormat('m-d-Y',$request->end_date_of_care),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'job_description' => $request->job_description,
                'medical_history' => serialize($request->medical_history),
                'essential_prior_expertise' => serialize($request->essential_prior_expertise),
                'other_requirements' => serialize($request->other_requirements),
            ]);
            if($update){
                return $this->success('Job updated successfully.',  null, 'null', 200);
            }else{
                return $this->error('Whoops! Something went wrong. Failed to update job.',  null, 'null', 500);
            }
        }
    }

    public function getActiveJob(){
        $jobs = JobByAgency::where('user_id', auth('sanctum')->user()->id)->where('is_activate', 1)->orderBy('created_at', 'DESC')->get();
        return $this->success('Job posted successfully.',  $jobs, 'null', 200);
    }

    public function getOngoingJob(){
        $jobs = AcceptedJob::with('jobByAgency')->where('agency_id', auth('sanctum')->user()->id)->where('is_activate', 1)->orderBy('created_at', 'DESC')->get();

        $new_details = [];
        foreach($jobs as $key => $item){
            $user = User::with('profile')->where('id', $item->caregiver_id)->first();
            $caregiver_details = [
                'name' => $user->firstname.', '.$user->lastname,
                'work_type' => $user->profile->work_type,
                'rating' => $user->profile->rating
            ];
            $details = [
                'job_title' => $item->jobByAgency->job_title,
                'amount' => '$'.$item->jobByAgency->amount_per_hour,
                'care_type' => $item->jobByAgency->care_type,
                'job_accepted_on' =>  Carbon::parse($item->jobByAgency->created_at)->diffForHumans(),
                'patient_age' => $item->jobByAgency->patient_age,
                'start_date' => $item->jobByAgency->start_date_of_care,
                'end_date' => $item->jobByAgency->end_date_of_care,
                'start_time' => $item->jobByAgency->start_time,
                'end_time' => $item->jobByAgency->end_time,
                'location' => $item->jobByAgency->street.', '.$item->jobByAgency->city.', '.$item->jobByAgency->state.', '.$item->jobByAgency->zip_code,
                'description' => $item->jobByAgency->job_description,
                'medical_history' => $item->jobByAgency->medical_history,
                'essential_prior_expertise' => $item->jobByAgency->essential_prior_expertise,
                'other_requirements' => $item->jobByAgency->other_requirements,
                'is_activate' => $item->jobByAgency->is_activate,
                'accepted_caregiver_details' => $caregiver_details,
                'accepted_by' => $item->caregiver_id,
    
            ];

            array_push($new_details, $details);
        }
        return $this->success('Ongoing job fetched successfully.',  $new_details, 'null', 200);
    }

    public function updateJobStatus(Request $request){
        $update = JobByAgency::where('id', $request->job_id)->where('user_id', auth('sanctum')->user()->id)->update([
            'is_activate' => $request->job_status
        ]);
        if($update){
            return $this->success('Job status changed successfully.',  null, 'null', 201);
        }else{
            return $this->error('Whoops! Something went wrong.',  null, 'null', 500);
        }
    }

    public function deleteJob(Request $request){
        $delete = JobByAgency::where('id', $request->job_id)->where('user_id', auth('sanctum')->user()->id)->delete();
        if($delete){
            return $this->success('Job deleted successfully.',  null, 'null', 200);
        }else{
            return $this->error('Whoops! Something went wrong.',  null, 'null', 500);
        }
    }

    public function getCaregiverProfile(){

        if(! isset($_GET['id']) ){
            return $this->error('Whoops! Invalid params passed. ',  null, 'null', 404);
        }else{
            $details = User::with('profile', 'address')->where('id', $_GET['id'])->first();
            $education = Education::where('user_id', $_GET['id'])->get();
            $answer = Answer::where('user_id', $_GET['id'])->get();
            $final_question = [];
            foreach($answer as $key => $item){
                $question = Question::where('id', $answer[$key]['question_id'])->get();
                foreach($question as $key => $item2){
                    $new_question = [
                        'question' => $item2->slug,
                        'answer' => $item->answer
                    ];

                    array_push($final_question, $new_question);
                }
            }
            if($details == null){
                return $this->error('Whoops! Caregiver not found. ',  null, 'null', 404);
            }else{
                $dobFormat = $diff = date_diff(date_create( $details->profile->dob), date_create(date('Y-m-d')));
                $profile = [
                    'image' =>  $details->profile->profile_image,
                    'name' =>  $details->firstname.' '.$details->lastname,
                    'email' => $details->email,
                    'phone' => $details->profile->phone,
                    'work_type' => $details->profile->work_type.' caregiver',
                    'rating' => $details->profile->rating,
                    'experience' => $details->profile->experience.' yrs',
                    'age' => $dobFormat->format('%y').' yrs',
                    'care_completed' => $details->profile->total_care_completed,
                    'total_review' => $details->profile->total_reviews,
                    'bio' => $details->profile->bio,
                    'address' => $details->address->street.', '.$details->address->city.', '.$details->address->state.', '.$details->address->zip_code,
                    'education' => $education,
                    'reviews' => [],
                    'question' => $final_question
                ];
                
                return $this->success('Caregiver profile fetched successfully.',  $profile, 'null', 200);
            }
        }
    }

    public function getClosedJob(){
        $closed_job = AcceptedJob::with('jobByAgency')->where('agency_id', auth('sanctum')->user()->id)->where('is_activate', 0)->orderBy('created_at', 'DESC')->get();
        $new_details = [];
        foreach($closed_job as $key => $item){
            $agency_name = User::where('id', $item->agency_id)->first();
            $user = User::with('profile')->where('id', $item->caregiver_id)->first();
            $caregiver_details = [];
            if($user->profile != null){
                $caregiver_details = [
                    'name' => $user->firstname.', '.$user->lastname,
                    'work_type' => $user->profile->work_type,
                    'rating' => $user->profile->rating
                ];
            }else{
                $caregiver_details = [
                    'name' => $user->firstname.', '.$user->lastname,
                    'work_type' => null,
                    'rating' => 0
                ];
            }
            
            $details = [

                'id' => $item->jobByAgency->id,
                'agency_name' => $agency_name->business_name,
                'job_title' => $item->jobByAgency->job_title,
                'amount' => $item->jobByAgency->amount_per_hour,
                'care_type' => $item->jobByAgency->care_type,
                'patient_age' => $item->jobByAgency->patient_age,
                'job_accepted_on' =>  Carbon::parse($item->jobByAgency->updated_at)->diffForHumans(), // variable name asked by android developer.
                'start_date' => $item->jobByAgency->start_date_of_care,
                'end_date' => $item->jobByAgency->end_date_of_care,
                'start_time' => $item->jobByAgency->start_time,
                'end_time' => $item->jobByAgency->end_time,
                'location' => $item->jobByAgency->street.', '. $item->jobByAgency->city.', '. $item->jobByAgency->zip_code.', '. $item->jobByAgency->state,
                'description' =>  $item->jobByAgency->job_description,
                'medical_history' => $item->jobByAgency->medical_history,
                'essential_prior_expertise' => $item->jobByAgency->essential_prior_expertise,
                'other_requirements' => $item->jobByAgency->other_requirements,
                'accepted_caregiver_details' =>  $caregiver_details,
                'accepted_by' => $item->caregiver_id,
                'job_created_on' => $item->jobByAgency->created_at,
                
            ];
            array_push($new_details, $details);
        }

        return $this->success('Past job fetched successfully.',   $new_details, 'null', 200);
        $details = JobByAgency::where('is_activate', 0)->where('user_id', auth('sanctum')->user()->id)->get();
        return $this->success('Closed job fetched successfully.',  $details, 'null', 200);
    }

}
