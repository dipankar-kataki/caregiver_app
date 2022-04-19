<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\JobByAgency;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SearchController extends Controller
{   
    use ApiResponser;
    public function search($caretype = null, $city = null){
        $job_details = JobByAgency::where('care_type', 'like', '%' .$caretype. '%')->where('city', 'like', '%'. $city. '%')->where('is_activate', 1)->get();
        $new_details = [];
        foreach($job_details as $key => $item){
            $details = [
                'id' => $job_details[$key]['id'],
                'agency_name' => $job_details[$key]['user']['business_name'],
                'job_title' => $job_details[$key]['job_title'],
                'amount_per_hour' => $job_details[$key]['amount_per_hour'],
                'care_type' => $job_details[$key]['care_type'],
                'patient_age' => $job_details[$key]['patient_age'],
                'start_date_of_care' => $job_details[$key]['start_date_of_care'],
                'end_date_of_care' => $job_details[$key]['end_date_of_care'],
                'start_time' => $job_details[$key]['start_time'],
                'end_time' => $job_details[$key]['end_time'],
                'location' => $job_details[$key]['street'].', '. $job_details[$key]['city'].', '. $job_details[$key]['zip_code'].', '. $job_details[$key]['state'],
                'job_description' =>  $job_details[$key]['job_description'],
                'medical_history' => $job_details[$key]['medical_history'],
                'essential_prior_expertise' => $job_details[$key]['essential_prior_expertise'],
                'other_requirements' => $job_details[$key]['other_requirements'],
                'created_at' => $job_details[$key]['created_at'],
                
            ];
            array_push($new_details, $details);
        }
        return $this->success('Jobs fetched successfully', $new_details , 'null', 200);
    }
}
