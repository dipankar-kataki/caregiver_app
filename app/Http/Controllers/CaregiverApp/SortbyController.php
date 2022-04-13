<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\JobByAgency;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SortbyController extends Controller
{
    use ApiResponser;
    public function price($amount = null){
        if($amount == null){
            return $this->error('Whoops! Amount is null', null , 'null', 200);
        }else{
            $jobsByPrice = JobByAgency::where('amount_per_hour', 'like', '%' . $amount . '%')->where('is_activate', 1)->get();
            return $this->success('Jobs fetched successfully', $jobsByPrice , 'null', 200);
        }
        
    }
}
