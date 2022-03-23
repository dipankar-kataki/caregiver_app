<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AgencyController extends Controller
{
    public function approvedAgencyList(){
        $approved_list = User::with('profile')->where('is_user_approved', 0)->where('role', 3)->orderBy('created_at', 'DESC')->get();   
        return view('admin.agency.approved-agency')->with('approved_list', $approved_list);
    }

    public function newJoiner(Request $request){
        $new_joiner = User::where('is_user_approved', 0)->where('role', 3)->orderBy('created_at', 'DESC')->get();   
        return view('admin.agency.new-joiners')->with('new_joiner', $new_joiner);
    }

    public function viewProfile($id){
        $user_id = Crypt::decrypt($id);
        $details = User::with('jobs', 'business_information', 'address', 'profile')->where('id', $user_id)->where('role', 3)->first();
        return view('admin.agency.view-profile')->with('details' , $details);
    }
}
