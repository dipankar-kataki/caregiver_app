<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\JobByAgency;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SortbyController extends Controller
{
    use ApiResponser;
    public function price(){

        if(! (isset($_GET['startprice']) && isset($_GET['endprice'])) ){
            return $this->error('Whoops! Invalid price filter variables passed.', null , 'null', 200);
        }else{
            $jobsByPrice = JobByAgency::whereBetween('amount_per_hour', [$_GET['startprice'], $_GET['endprice']])->where('is_activate', 1)->latest()->paginate(5);
            $new_details = [];
            foreach($jobsByPrice as $key => $item){
                $details = [
                    'id' => $jobsByPrice[$key]['id'],
                    'agency_name' => $jobsByPrice[$key]['user']['business_name'],
                    'job_title' => $jobsByPrice[$key]['job_title'],
                    'amount_per_hour' => $jobsByPrice[$key]['amount_per_hour'],
                    'care_type' => $jobsByPrice[$key]['care_type'],
                    'patient_age' => $jobsByPrice[$key]['patient_age'],
                    'start_date_of_care' => $jobsByPrice[$key]['start_date_of_care'],
                    'end_date_of_care' => $jobsByPrice[$key]['end_date_of_care'],
                    'start_time' => $jobsByPrice[$key]['start_time'],
                    'end_time' => $jobsByPrice[$key]['end_time'],
                    'location' => $jobsByPrice[$key]['street'].', '. $jobsByPrice[$key]['city'].', '. $jobsByPrice[$key]['zip_code'].', '. $jobsByPrice[$key]['state'],
                    'job_description' =>  $jobsByPrice[$key]['job_description'],
                    'medical_history' => $jobsByPrice[$key]['medical_history'],
                    'essential_prior_expertise' => $jobsByPrice[$key]['essential_prior_expertise'],
                    'other_requirements' => $jobsByPrice[$key]['other_requirements'],
                    'created_at' => $jobsByPrice[$key]['created_at'],
                    
                ];
                array_push($new_details, $details);
            }
            return $this->success('Jobs fetched successfully', $new_details , 'null', 200);
        }
    }
}
