<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CaregiverController extends Controller
{
    public function approvedCaregiverList(){
        $approved_list = User::with('profile')->where('is_user_approved', 1)->where('role', 2)->orderBy('created_at', 'DESC')->get();   
        return view('admin.caregiver.approved-caregiver')->with(['approved_list' => $approved_list]);
    }

    public function newJoiner(Request $request){
        $request_for_approval = User::with('profile')->where('is_registration_completed', 1)->where('is_questions_answered', 1)->where('is_documents_uploaded', 1)->where('is_user_approved', 0)->where('role', 2)->orderBy('created_at', 'DESC')->get();   
        return view('admin.caregiver.request-for-approval')->with(['request_for_approval'=> $request_for_approval]);
    }
    public function updateStatus(Request $request){
        $user_id = $request->user_id;
        $status = $request->status;

        $update_status = User::where('id', $user_id)->update([
            'is_user_approved' => $status
        ]);
        if($update_status){
            return response()->json(['message' => 'User Approved', 'status' => 1]);
        }else{
            return response()->json(['message' => 'Whoops! Something went wrong. User not approved', 'status' => 2]);
        }
    }

    public function viewProfile(){
        return view('admin.caregiver.view-profile');
    }
}
