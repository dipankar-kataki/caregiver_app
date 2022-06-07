<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Common\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\AcceptedJob;
use App\Models\CaregiverBankAccount;
use Illuminate\Http\Request;
use App\Models\JobByAgency;
use App\Models\Registration;
use App\Models\Review;
use App\Traits\ApiResponser;
use App\Models\User;
use App\Traits\PushNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class JobController extends Controller
{
    use ApiResponser, PushNotification;
    public function recomendedJobs(){
        if(isset($_GET['current_date_time']) == null){
            return $this->success('Failed to fetch recomended jobs. Current time not provided', null, 'null', 200);
        }else{
            $jobs = JobByAgency::with('user', 'agency_profile')->where('is_activate', 1)->where('job_status', JobStatus::Open)->orderBy('created_at', 'DESC')->paginate(5);
            $new_details = [];    
            
              

            foreach($jobs as $key => $item){

                $converted_start_time = $item->start_date_of_care.' '.date_create($item->start_time)->format('H:i');
              
                // Declare and define two dates
                $current_time = strtotime($_GET['current_date_time']);
                $start_time = strtotime($converted_start_time);
                

                if($start_time >= $current_time){
                    $details = [
                        'id' => $item->id,
                        'agency_name' => $item->user->business_name,
                        'profile_image' =>  $item->agency_profile->profile_image,
                        'job_title' => $item->job_title,
                        'amount_per_hour' => $item->amount_per_hour,
                        'care_type' => $item->care_type,
                        'patient_age' => $item->patient_age,
                        'start_date_of_care' => Carbon::parse($item->start_date_of_care)->format('m-d-Y'),
                        'end_date_of_care' => $item->end_date_of_care,
                        'start_time' => $item->start_time,
                        'end_time' => $item->end_time,
                        'location' => $item->street.', '. $item->city.', '. $item->state.', '.  $item->zip_code,
                        'job_description' =>  $item->job_description,
                        'medical_history' => $item->medical_history,
                        'essential_prior_expertise' => $item->essential_prior_expertise,
                        'other_requirements' => $item->other_requirements,
                        'created_at' => $item->created_at,
                        
                    ];
                    array_push($new_details, $details);
                }
                
            }
            return $this->success('Recomended jobs fetched successfully.',   $new_details, 'null', 200);
        }
    }

    public function recomendedJobsCount(){
        $jobs = JobByAgency::where('is_activate', 1)->where('job_status', JobStatus::Open)->count();
        return $this->success('Total recomended jobs.',  $jobs, 'null', 200);
    }

    public function jobOwnerProfile(Request $request){

        $validator = Validator::make($request->all(),[
            'job_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Failed to fetch agency profile.', $validator->errors(), 'null', 400);
        }else{
            $job_id = $request->job_id;

            $get_job_details =  JobByAgency::where('id', $job_id)->first();
            $profile_details = User::with('address', 'business_information')->where('id', $get_job_details->user_id)->first();

            $review = Review::with('agency')->where('review_to', $get_job_details->user_id)->latest()->get();
            $new_review_details = [];
            foreach($review as $key => $item){
                $user = User::with('profile')->where('id', $item->review_by)->first();
                $details = [
                    'rating' => $item->rating,
                    'content' => $item->content,
                    'posted_by' => $user->firstname.''.$user->lastname,
                    'photo' => $user->profile->profile_image,
                    'created_at' => $item->created_at->diffForHumans()
                ];
                
                array_push($new_review_details, $details);
            }

            if($profile_details->business_information  != null){
                $year_started =  Carbon::now()->subYears($profile_details->business_information->years_in_business);
                
                $beneficiary = '';
                if($profile_details->business_information->beneficiary == null){
                    $beneficiary = null;
                }else{
                    $beneficiary = $profile_details->business_information->beneficiary;
                }

                $homecare_service = '';
                if($profile_details->business_information->homecare_service == null){
                    $homecare_service = null;
                }else{
                    $homecare_service = $profile_details->business_information->homecare_service;
                }

                $details = [
                    'profile_image' => $profile_details->business_information->profile_image,
                    'business_name' => $profile_details->business_name,
                    'phone' => $profile_details->business_information->business_number,
                    'year_started' => $year_started->format('Y').' ('.$profile_details->business_information->years_in_business.' '.'years)',
                    'legal_structure_of_business' => $profile_details->business_information->legal_structure,
                    'no_of_employees' => $profile_details->business_information->no_of_employee,
                    'address' => $profile_details->address->street.', '. $profile_details->address->city.', '.$profile_details->address->state.', '.$profile_details->address->zip_code,
                    'annual_business_revenue' => '$ '.$profile_details->business_information->annual_business_revenue,
                    'bio' => $profile_details->business_information->bio,
                    'our_beneficiaries' => $beneficiary,
                    'homecare_services' => $homecare_service,
                    'rating' =>  $profile_details->business_information->rating,
                    'review' => $new_review_details
                ];
                return $this->success('Profile details fetched successfully.',  $details, 'null', 200);
            }else{
                return $this->success('Profile details fetched successfully.', null, 'null', 200);
            }
        }
    }

    public function acceptJob(Request $request){
        $validator = Validator::make($request->all(),[
            'job_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Something went wrong. Failed to accept job.', $validator->errors(), 'null', 400);
        }else{

            $check_if_job_is_deleted = JobByAgency::where('id', $request->job_id)->first();
            if($check_if_job_is_deleted->trashed()){
                return $this->error('Whoops! This job has already been removed.', null, 'null', 400);
            }else{
                $check_if_job_is_already_accepted = AcceptedJob::where('job_by_agencies_id', $request->job_id)->exists();

                $check_user = User::with('caregiverBank')->where('id', auth('sanctum')->user()->id)->first();
                $check_bank = CaregiverBankAccount::where('user_id', auth('sanctum')->user()->id)->first();
                $check_no_of_jobs_accepted = AcceptedJob::where('caregiver_id', auth('sanctum')->user()->id)->where('is_activate', 1)->exists();
                $get_agency = JobByAgency::where('id', $request->job_id)->first();
                $get_fcm_token = User::where('id', $get_agency->user_id)->first();
        
                $is_bank_added = 0;
                if($check_bank != null){
                    $is_bank_added = 1;
                }else{
                    $is_bank_added = 0;
                }
        
                $is_job_already_accepted = 0;
                if($check_no_of_jobs_accepted){
                    $is_job_already_accepted = 1;
                }else{
                    $is_job_already_accepted = 0;
                }
                $profile_completion_status = [];
                if($check_user->is_user_approved == 0){
                    $profile_completion_status = [
                        'is_registration_completed' => $check_user->is_registration_completed,
                        'is_questions_answered' => $check_user->is_questions_answered,
                        'is_documents_uploaded' => $check_user->is_documents_uploaded,
                        'is_user_approved' => $check_user->is_user_approved,
                        'is_bank_details_added' =>  $is_bank_added,
                        'is_job_already_accepted' => $is_job_already_accepted
                    ];
                    return $this->error('Whoops! Failed to accept job.', $profile_completion_status , 'null', 400);
                }else if($check_user->is_user_approved == 1 &&  $check_bank == null){
                    $profile_completion_status = [
                        'is_registration_completed' => $check_user->is_registration_completed,
                        'is_questions_answered' => $check_user->is_questions_answered,
                        'is_documents_uploaded' => $check_user->is_documents_uploaded,
                        'is_user_approved' => $check_user->is_user_approved,
                        'is_bank_details_added' =>  $is_bank_added,
                        'is_job_already_accepted' => $is_job_already_accepted
                    ];
                    return $this->error('Whoops! Failed to accept job.', $profile_completion_status , 'null', 400);
                }else if($check_if_job_is_already_accepted){
                    $profile_completion_status = [
                        'is_registration_completed' => $check_user->is_registration_completed,
                        'is_questions_answered' => $check_user->is_questions_answered,
                        'is_documents_uploaded' => $check_user->is_documents_uploaded,
                        'is_user_approved' => $check_user->is_user_approved,
                        'is_bank_details_added' =>  $is_bank_added,
                        'is_job_already_accepted' => $is_job_already_accepted
                    ];
                    return $this->error('Whoops! This job has already been accepted.', $profile_completion_status, 'null', 400);
                }else if($check_no_of_jobs_accepted){
                    $profile_completion_status = [
                        'is_registration_completed' => $check_user->is_registration_completed,
                        'is_questions_answered' => $check_user->is_questions_answered,
                        'is_documents_uploaded' => $check_user->is_documents_uploaded,
                        'is_user_approved' => $check_user->is_user_approved,
                        'is_bank_details_added' =>  $is_bank_added,
                        'is_job_already_accepted' => $is_job_already_accepted
                    ];
                    return $this->error('Whoops! Failed to accept job. Existing job not completed. Caregiver can accept only one job at a time.',  $profile_completion_status , 'null', 400);
                }else{
                    $createJob = AcceptedJob::create([
                        'job_by_agencies_id' =>  $request->job_id,
                        'caregiver_id' => auth('sanctum')->user()->id,
                        'agency_id' => $get_agency->user_id,
                        'is_activate' => 1
                    ]);
                    if($createJob){
                        JobByAgency::where('id', $request->job_id)->update([
                            'job_status' => JobStatus::Accept
                        ]);
    
                        if($get_fcm_token->fcm_token != null){
                            $data=[];
                            $data['message']= "Job Accepted Successfully by ".$check_user->firstname.' '.$check_user->lastname;
                            $token = [];
                            $token[] = $get_fcm_token->fcm_token;
                            $this->sendNotification($token, $data);
                        }
                        
                        return $this->success('Job accepted successfully.',  null, 'null', 200);
                    }else{
                        return $this->error('Whoops! Something went wrong. Failed to accept job.', null , 'null', 400);
                    }
                }
            }
        }
    }

    public function ongoingJob(){
        $ongoing_job = AcceptedJob::with('jobByAgency', 'agency_profile')->where('caregiver_id', auth('sanctum')->user()->id)->where('is_activate', 1)->orderBy('created_at', 'DESC')->get();
        $new_details = [];
        foreach($ongoing_job as $key => $item){
            $agency_name = User::where('id', $item->agency_id)->first();
            $details = [

                'id' => $item->jobByAgency->id,
                'profile_image' => $item->agency_profile->profile_image,
                'agency_name' => $agency_name->business_name,
                'job_title' => $item->jobByAgency->job_title,
                'amount_per_hour' => $item->jobByAgency->amount_per_hour,
                'care_type' => $item->jobByAgency->care_type,
                'patient_age' => $item->jobByAgency->patient_age,
                'start_date_of_care' => Carbon::parse($item->jobByAgency->start_date_of_care)->format('m-d-Y'),
                'end_date_of_care' => $item->jobByAgency->end_date_of_care,
                'start_time' => $item->jobByAgency->start_time,
                'end_time' => $item->jobByAgency->end_time,
                'location' => $item->jobByAgency->street.', '. $item->jobByAgency->city.', '. $item->jobByAgency->zip_code.', '. $item->jobByAgency->state,
                'job_description' =>  $item->jobByAgency->job_description,
                'medical_history' => $item->jobByAgency->medical_history,
                'essential_prior_expertise' => $item->jobByAgency->essential_prior_expertise,
                'other_requirements' => $item->jobByAgency->other_requirements,
                'created_at' => $item->jobByAgency->created_at,
                
            ];
            array_push($new_details, $details);
        }

        return $this->success('Ongoing job fetched successfully.',   $new_details, 'null', 200);
    }

    public function completeJob(Request $request){
        $validator = Validator::make($request->all(),[
            'job_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->error('Whoops! Something went wrong. Failed to complete job.', $validator->errors() , 'null', 500);
        }else{
            $registration = Registration::with('user')->where('user_id', auth('sanctum')->user()->id)->first();
            $details = AcceptedJob::where('job_by_agencies_id', $request->job_id)->first();
            $updateJobByAgencyTable = JobByAgency::where('id', $details->job_by_agencies_id)->update([
                'is_activate' => 0,
                'job_status' => JobStatus::Closed
            ]);
            $updateJobAcceptedTable = AcceptedJob::where('job_by_agencies_id', $request->job_id)->update([
                'is_activate' => 0
            ]);

            Registration::where('user_id', auth('sanctum')->user()->id)->update([
                'total_care_completed' =>  $registration->total_care_completed + 1
            ]);

            if(($updateJobByAgencyTable) && ($updateJobAcceptedTable)){

                $get_fcm_token = User::where('id', $details->agency_id)->first();
                if($get_fcm_token->fcm_token != null){
                    $data=[];
                    $data['message']= "Job Completed Successfully by ".$registration->user->firstname.' '.$registration->user->lastname;
                    $token = [];
                    $token[] = $get_fcm_token->fcm_token;
                    $this->sendNotification($token, $data);
                }

                return $this->success('Job completed successfully',  null, 'null', 200);
            }else{
                return $this->error('Whoops! Something went wrong. Failed to complete job.', null , 'null', 400);
            }
        }
        
    }

    public function pastJob(){
        $ongoing_job = AcceptedJob::with('jobByAgency', 'agency_profile')->where('caregiver_id', auth('sanctum')->user()->id)->where('is_activate', 0)->orderBy('created_at', 'DESC')->get();
        $new_details = [];
        foreach($ongoing_job as $key => $item){
            $agency_name = User::where('id', $item->agency_id)->first();
            $details = [

                'id' => $item->jobByAgency->id,
                'profile_image' => $item->agency_profile->profile_image,
                'agency_name' => $agency_name->business_name,
                'job_title' => $item->jobByAgency->job_title,
                'amount_per_hour' => $item->jobByAgency->amount_per_hour,
                'care_type' => $item->jobByAgency->care_type,
                'patient_age' => $item->jobByAgency->patient_age,
                'start_date_of_care' => Carbon::parse($item->jobByAgency->start_date_of_care)->format('m-d-Y'),
                'end_date_of_care' => $item->jobByAgency->end_date_of_care,
                'start_time' => $item->jobByAgency->start_time,
                'end_time' => $item->jobByAgency->end_time,
                'location' => $item->jobByAgency->street.', '. $item->jobByAgency->city.', '. $item->jobByAgency->zip_code.', '. $item->jobByAgency->state,
                'job_description' =>  $item->jobByAgency->job_description,
                'medical_history' => $item->jobByAgency->medical_history,
                'essential_prior_expertise' => $item->jobByAgency->essential_prior_expertise,
                'other_requirements' => $item->jobByAgency->other_requirements,
                'created_at' => $item->jobByAgency->created_at,
                
            ];
            array_push($new_details, $details);
        }

        return $this->success('Past job fetched successfully.',   $new_details, 'null', 200);
    }
}
