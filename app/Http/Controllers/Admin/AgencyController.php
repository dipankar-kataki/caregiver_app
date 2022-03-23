<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function viewProfile(){
        return view('admin.agency.view-profile');
    }
}
