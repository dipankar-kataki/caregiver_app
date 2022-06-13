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
        $total_approved_caregivers = User::where('role', 2)->where('is_user_approved', 1)->count();
        $total_approved_agencies = User::where('role', 3)->where('is_user_approved', 1)->count();

        $total_pending_caregivers = User::where('role', 2)->where('is_registration_completed', 1)->where('is_questions_answered', 1)->where('is_documents_uploaded', 1)->where('is_user_approved', 0)->count();
        $total_pending_agencies = User::where('role', 3)->where('is_business_info_added', 1)->where('is_authorize_info_added', 1)->where('is_user_approved', 0)->count();

        $total_jobs_posted = AgencyPayments::where('payment_status', 1)->count();
        $total_agency_payments = AgencyPayments::where('payment_status', 1)->sum('peaceworc_charge');

        

        $recently_joined_caregiver = User::with('profile', 'address')->where('role', 2)->where('is_user_approved', 1)->latest()->take(5)->get();
        $recently_joined_agency = User::with('business_information', 'address')->where('role', 3)->where('is_user_approved', 1)->latest()->take(5)->get();

        $caregiver_pending_for_approval = User::with('profile')->where('is_registration_completed', 1)->where('is_questions_answered', 1)->where('is_documents_uploaded', 1)->where('is_user_approved', 0)->where('role', 2)->orderBy('created_at', 'DESC')->get();   
        $agency_pending_for_approval =  User::where('is_business_info_added', 1)->where('is_authorize_info_added', 1)->where('is_user_approved', 0)->where('role', 3)->orderBy('created_at', 'DESC')->get();   

        return view('admin.dashboard')->with([
            'total_approved_caregivers' => $total_approved_caregivers,
            'total_approved_agencies' => $total_approved_agencies, 
            'total_pending_caregivers' => $total_pending_caregivers,
            'total_pending_agencies' => $total_pending_agencies, 
            'total_jobs_posted' => $total_jobs_posted,
            'total_agency_payments' => $total_agency_payments, 
            'recently_joined_caregiver' => $recently_joined_caregiver, 
            'recently_joined_agency' => $recently_joined_agency,
            'caregiver_pending_for_approval' => $caregiver_pending_for_approval,
            'agency_pending_for_approval' => $agency_pending_for_approval
        ]);
    }
}
