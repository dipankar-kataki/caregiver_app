<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        $id = Crypt::decrypt($id);
        $user_details = User::with('profile', 'address')->where('id', $id)->first();
        $education = Education::where('user_id', $id)->get();
        return view('admin.caregiver.profile')->with(['user_details' => $user_details, 'education' => $education]);
    }
}
