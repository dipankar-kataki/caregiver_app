<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AgencyController extends Controller
{
    public function approvedAgencyList(){
        $approved_agencies = User::with('business_information')->where('is_user_approved', 1)->where('role', 3)->orderBy('created_at', 'DESC')->get();   
        return view('admin.agency.approved-agency')->with(['approved_agencies' => $approved_agencies]);
    }

    public function newJoiner(Request $request){
        $request_for_approval = User::where('is_business_info_added', 1)->where('is_authorize_info_added', 1)->where('is_user_approved', 0)->where('role', 3)->orderBy('created_at', 'DESC')->get();   
        return view('admin.agency.request-for-approval')->with(['request_for_approval' => $request_for_approval]);
    }

    public function viewProfile($id){
        $user_id = Crypt::decrypt($id);
        $details = User::with('jobs', 'business_information', 'address', 'profile')->where('id', $user_id)->where('role', 3)->first();
        return view('admin.agency.view-profile')->with('details' , $details);
    }
}
