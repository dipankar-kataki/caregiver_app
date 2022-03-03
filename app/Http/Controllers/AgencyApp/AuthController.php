<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponser;
    public function signup(Request $request){
        return $this->success('Signup Details', $request->all(), 'null', 200);
    }
}
