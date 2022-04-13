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

    public function updateStatus(Request $request){
        $user_id = Crypt::decrypt($request->id);

        $update_status = User::where('id', $user_id)->update([
            'is_user_approved' => 1
        ]);
        if($update_status){
            return response()->json(['message' => 'User Approved', 'status' => 1]);
        }else{
            return response()->json(['message' => 'Whoops! Something went wrong. User not approved', 'status' => 2]);
        }
    }
    
    public function viewProfile($id){
        $user_id = Crypt::decrypt($id);
        $details = User::with('jobs', 'business_information', 'address')->where('id', $user_id)->where('role', 3)->first();
        return view('admin.agency.profile')->with('user_details' , $details);
    }

    
    public function suspendUser(Request $request){
        $id = Crypt::decrypt($request->id);
        $update = User::where('id', $id)->update([
            'is_user_approved' => 0
        ]);
        if($update){
            return response()->json(['message' => 'User suspended successfully', 'status' => 1]);
        }else{
            return response()->json(['message' => 'Whoops! Something went wrong. Not able to suspend user', 'status' => 2]);
        }
    }
}
