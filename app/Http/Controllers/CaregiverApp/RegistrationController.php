<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function registration(Request $request){
        return response($request->all());
    }
}
