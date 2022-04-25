<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\AcceptedJob;
use Illuminate\Http\Request;
use App\Models\JobByAgency;
use App\Models\Registration;
use App\Traits\ApiResponser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class JobController extends Controller
{
    use ApiResponser;
    public function recomendedJobs(){
        $jobs = JobByAgency::with('user')->where('is_activate', 1)->orderBy('created_at', 'DESC')->get();
        $new_details = [];
        foreach($jobs as $key => $item){
            $details = [
                'id' => $jobs[$key]['id'],
                'agency_name' => $jobs[$key]['user']['business_name'],
                'job_title' => $jobs[$key]['job_title'],
                'amount_per_hour' => $jobs[$key]['amount_per_hour'],
                'care_type' => $jobs[$key]['care_type'],
                'patient_age' => $jobs[$key]['patient_age'],
                'start_date_of_care' => $jobs[$key]['start_date_of_care'],
                'end_date_of_care' => $jobs[$key]['end_date_of_care'],
                'start_time' => $jobs[$key]['start_time'],
                'end_time' => $jobs[$key]['end_time'],
                'location' => $jobs[$key]['street'].', '. $jobs[$key]['city'].', '. $jobs[$key]['zip_code'].', '. $jobs[$key]['state'],
                'job_description' =>  $jobs[$key]['job_description'],
                'medical_history' => $jobs[$key]['medical_history'],
                'essential_prior_expertise' => $jobs[$key]['essential_prior_expertise'],
                'other_requirements' => $jobs[$key]['other_requirements'],
                'created_at' => $jobs[$key]['created_at'],
                
            ];
            array_push($new_details, $details);
        }
        return $this->success('Recomended jobs fetched successfully.',   $new_details, 'null', 200);
    }

    public function recomendedJobsCount(){
        $jobs = JobByAgency::where('is_activate', 1)->count();
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
                    'business_name' => $profile_details->business_name,
                    'phone' => $profile_details->business_information->business_number,
                    'year_started' => $year_started->format('Y').' ('.$profile_details->business_information->years_in_business.' '.'years)',
                    'legal_structure_of_business' => $profile_details->business_information->legal_structure,
                    'no_of_employees' => $profile_details->business_information->no_of_employee,
                    'address' => $profile_details->address->street.', '. $profile_details->address->city.', '. $profile_details->address->zip_code.', '. $profile_details->address->state,
                    'annual_business_revenue' => '$ '.$profile_details->business_information->annual_business_revenue,
                    'bio' => $profile_details->business_information->bio,
                    'our_beneficiaries' => $beneficiary,
                    'homecare_services' => $homecare_service
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
            $check_user = User::where('id', auth('sanctum')->user()->id)->first();
            if($check_user->is_user_approved == 0){
                $profile_completion_status = [
                    'is_registration_completed' => $check_user->is_registration_completed,
                    'is_questions_answered' => $check_user->is_questions_answered,
                    'is_documents_uploaded' => $check_user->is_documents_uploaded,
                    'is_user_approved' => $check_user->is_user_approved
                ];
                return $this->error('Whoops! Failed to accept job.', $profile_completion_status , 'null', 400);
            }else{
                $get_agency = JobByAgency::where('id', $request->job_id)->first();
                $createJob = AcceptedJob::create([
                    'job_by_agencies_id' =>  $request->job_id,
                    'caregiver_id' => auth('sanctum')->user()->id,
                    'agency_id' => $get_agency->user_id,
                    'is_activate' => 1
                ]);
                if($createJob){
                    JobByAgency::where('id', $request->job_id)->update([
                        'job_status' => 1
                    ]);
                    return $this->success('Job accepted successfully.',  null, 'null', 200);
                }else{
                    return $this->error('Whoops! Something went wrong. Failed to accept job.', null , 'null', 400);
                }
            }
        }
    }

    public function ongoingJob(){
        $ongoing_job = AcceptedJob::with('jobByAgency')->where('caregiver_id', auth('sanctum')->user()->id)->where('is_activate', 1)->orderBy('created_at', 'DESC')->get();
        $new_details = [];
        foreach($ongoing_job as $key => $item){
            $agency_name = User::where('id', $item->agency_id)->first();
            $details = [

                'id' => $item->jobByAgency->id,
                'agency_name' => $agency_name->business_name,
                'job_title' => $item->jobByAgency->job_title,
                'amount_per_hour' => $item->jobByAgency->amount_per_hour,
                'care_type' => $item->jobByAgency->care_type,
                'patient_age' => $item->jobByAgency->patient_age,
                'start_date_of_care' => $item->jobByAgency->start_date_of_care,
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
            $registration = Registration::where('user_id', auth('sanctum')->user()->id)->first();
            $details = AcceptedJob::where('job_by_agencies_id', $request->job_id)->first();
            $updateJobByAgencyTable = JobByAgency::where('id', $details->job_by_agencies_id)->update([
                'is_activate' => 0,
                'job_status' => 2
            ]);
            $updateJobAcceptedTable = AcceptedJob::where('job_by_agencies_id', $request->job_id)->update([
                'is_activate' => 0
            ]);

            Registration::where('user_id', auth('sanctum')->user()->id)->update([
                'total_care_completed' =>  $registration->total_care_completed + 1
            ]);

            if(($updateJobByAgencyTable) && ($updateJobAcceptedTable)){
                return $this->success('Job completed successfully',  null, 'null', 200);
            }else{
                return $this->error('Whoops! Something went wrong. Failed to complete job.', null , 'null', 400);
            }
        }
        
    }

    public function pastJob(){
        $ongoing_job = AcceptedJob::with('jobByAgency')->where('caregiver_id', auth('sanctum')->user()->id)->where('is_activate', 0)->orderBy('created_at', 'DESC')->get();
        $new_details = [];
        foreach($ongoing_job as $key => $item){
            $agency_name = User::where('id', $item->agency_id)->first();
            $details = [

                'id' => $item->jobByAgency->id,
                'agency_name' => $agency_name->business_name,
                'job_title' => $item->jobByAgency->job_title,
                'amount_per_hour' => $item->jobByAgency->amount_per_hour,
                'care_type' => $item->jobByAgency->care_type,
                'patient_age' => $item->jobByAgency->patient_age,
                'start_date_of_care' => $item->jobByAgency->start_date_of_care,
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
