<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CreateJobController extends Controller
{
    use ApiResponser;
    
    public function createJob(Request $request){
        return $this->success('Document fetched successfully.',  null, 'null', 200);
    }
}
