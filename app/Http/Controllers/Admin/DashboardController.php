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
        $total_jobs_posted = JobByAgency::where('is_activate', 1)->count();
        $total_agency_payments = AgencyPayments::where('payment_status', 'success')->sum('amount');
        return view('admin.dashboard')->with(['total_caregivers' => $total_caregivers, 'total_agencies' => $total_agencies, 'total_jobs_posted' => $total_jobs_posted, 'total_agency_payments' => $total_agency_payments]);
    }
}
