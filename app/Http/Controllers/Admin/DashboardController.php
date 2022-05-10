<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgencyPayments;
use App\Models\JobByAgency;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index(Request $request){
        $total_caregivers = User::where('role', 2)->where('is_user_approved', 1)->count();
        $total_agencies = User::where('role', 3)->where('is_user_approved', 1)->count();
        $total_jobs_posted = AgencyPayments::where('payment_status', 1)->count();
        $total_agency_payments = AgencyPayments::where('payment_status', 1)->sum('peaceworc_charge');
        $recently_joined_caregiver = User::with('profile', 'address')->where('role', 2)->where('is_user_approved', 1)->latest()->take(5)->get();
        $recently_joined_agency = User::with('business_information', 'address')->where('role', 3)->where('is_user_approved', 1)->latest()->take(5)->get();
        return view('admin.dashboard')->with(['total_caregivers' => $total_caregivers,
            'total_agencies' => $total_agencies, 'total_jobs_posted' => $total_jobs_posted,
            'total_agency_payments' => $total_agency_payments, 'recently_joined_caregiver' => $recently_joined_caregiver, 
            'recently_joined_agency' => $recently_joined_agency
        ]);
    }
}
