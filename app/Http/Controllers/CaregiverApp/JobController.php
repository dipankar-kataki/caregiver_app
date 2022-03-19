<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobByAgency;
use App\Traits\ApiResponser;


class JobController extends Controller
{
    use ApiResponser;
    public function recomendedJobs(){
        $jobs = JobByAgency::where('is_activate', 1)->orderBy('created_at', 'DESC')->get();
        return $this->success('Recomended jobs fetched successfully.',  $jobs, 'null', 200);
    }

    public function recomendedJobsCount(){
        $jobs = JobByAgency::where('is_activate', 1)->count();
        return $this->success('Total recomended jobs.',  $jobs, 'null', 200);
    }
}
