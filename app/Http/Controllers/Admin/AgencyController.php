<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgencyPayments;
use App\Models\JobByAgency;
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
        $request_for_approval = User::where('is_business_info_added', 1)->where('is_authorize_info_added', 1)->where('is_user_approved', 0)->where('role', 3)->latest()->get();   
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
        $details = User::with('business_information', 'address')->where('id', $user_id)->where('role', 3)->first();
        $job_count = AgencyPayments::where('payment_status', 1)->where('agency_id', $user_id )->count();
        return view('admin.agency.profile')->with(['user_details' => $details, 'job_count' => $job_count]);
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

    public function job(){
        $job_details = JobByAgency::with('user', 'payment_status')->orderBy('created_at', 'DESC')->withTrashed()->get();
        $new_details = [];
        foreach($job_details as $key => $item){
            foreach($item->payment_status as $key2 => $item2){
                $details = [
                    'agency' => $item->user->business_name,
                    'job_title' => $item->job_title,
                    'order_id' => $item->job_order_id,
                    'job_id' => $item2->job_id,
                    'user_id' => $item->user_id,
                    'amount_per_hour' => $item->amount_per_hour,
                    'amount_paid' => $item2->amount,
                    'posted_on' => $item->created_at,
                    'job_status' => $item->job_status,
                    'payment_status' =>  $item2->payment_status
                ];

                array_push($new_details, $details);
            }
            
        }
        return view('admin.agency.job.job')->with(['job_details' => $new_details]);
    }

    public function disableJob(Request $request){
        $job_id = $request->job_id;
        $status = $request->active;
        $update = JobByAgency::where('id', $job_id)->update([
            'is_activate' => $status
        ]);

        if($update){
            if($status == 1){
                return response()->json(['message' => 'Visibility changed from hide to show.', 'status' => 1]);
            }else{
                return response()->json(['message' => 'Visibility changed from show to hide.', 'status' => 1]);
            }
        }else{
            return response()->json(['message' => 'Whoops! Something went wrong. Failed to update visibility status', 'status' => 500]);
        }
    }   


    public function newlyPosted(){
       $newly_posted = JobByAgency::with('user')->where('job_status', 0)->where('is_activate', 0)->orderBy('created_at', 'DESC')->get();
       return view('admin.agency.job.newly-posted')->with(['newly_posted' => $newly_posted ]);
    }

    public function publish(Request $request){
        $post = JobByAgency::where('id', $request->job_id)->where('job_status', 0)->where('is_activate', 0)->update([
            'is_activate' => 1
        ]);

        if($post){
            return response()->json(['message' => 'Job published successfully', 'status' => 1]);
        }else{
            return response()->json(['message' => 'Whoops! Something went wrong. Failed to publish job.', 'status' => 2]);
        }
    }

    public function jobDetails($id){
        $job_id = Crypt::decrypt($id);
        $job_details = JobByAgency::with('user','payment_status')->where('id', $job_id)->first();
        return view('admin.agency.job.job-details')->with('job_details' , $job_details);
    }
}
