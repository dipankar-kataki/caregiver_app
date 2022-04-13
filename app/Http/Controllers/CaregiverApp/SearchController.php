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
        return $this->success('Jobs fetched successfully', $job_details , 'null', 200);
    }
}
