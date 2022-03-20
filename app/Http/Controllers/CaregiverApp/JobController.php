<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobByAgency;
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
                $details = [
                    'business_name' => $profile_details->business_name,
                    'phone' => $profile_details->business_information->business_number,
                    'year_started' => $year_started->format('Y').' ('.$profile_details->business_information->years_in_business.' '.'years)',
                    'legal_structure_of_business' => $profile_details->business_information->legal_structure,
                    'no_of_employees' => $profile_details->business_information->no_of_employee,
                    'address' => $profile_details->address->street.', '. $profile_details->address->city.', '. $profile_details->address->zip_code.', '. $profile_details->address->state,
                    'annual_business_revenue' => '$ '.$profile_details->business_information->annual_business_revenue,
                    'bio' => $profile_details->business_information->bio,
                    'our_beneficiaries' => $profile_details->business_information->beneficiary,
                    'homecare_services' => $profile_details->business_information->homecare_service
                ];
                return $this->success('Profile details fetched successfully.',  $details, 'null', 200);
            }else{
                return $this->success('Profile details fetched successfully.', null, 'null', 200);
            }
        }
    }
}
