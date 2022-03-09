<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\JobByAgency;
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
            'medical_history' => 'required',
            'essential_prior_expertise' => 'required',
            'other_requirements' => 'required',
        ]);
        if($validator->fails()){
            return $this->error('Whoops! Failed to create job.',  $validator->fails(), 'null', 200);
        }else{

            // $jobs = JobByAgency::where('user_id', auth('sanctum')->user()->id)->where('is_activate', 1)->first();
                
            // return $this->success('Job posted successfully.',  $jobs->medical_history, 'null', 200);
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
                'user_id' => auth('sanctum')->user()->id
            ]);
            if($create){
                // $jobs = JobByAgency::where('user_id', auth('sanctum')->user()->id)->where('is_activate', 1)->get();

                return $this->success('Job posted successfully.',  null, 'null', 201);
            }else{
                return $this->error('Whoops! Something went wrong. Failed to post job.',  null, 'null', 500);
            }
        }
    }

    public function getActiveJob(){
        $jobs = JobByAgency::where('user_id', auth('sanctum')->user()->id)->where('is_activate', 1)->orderBy('created_at', 'DESC')->get();
        return $this->success('Job posted successfully.',  $jobs, 'null', 200);
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
}
