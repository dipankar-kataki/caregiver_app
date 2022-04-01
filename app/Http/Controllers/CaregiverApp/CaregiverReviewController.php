<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\BusinessInformation;
use App\Models\JobByAgency;
use App\Models\Registration;
use App\Models\Review;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaregiverReviewController extends Controller
{
    use ApiResponser;
    public function addReview(Request $request){
        $validator = Validator::make($request->all(),[
            'job_id' => 'required',
            'rating' => 'required',
            'content' => 'required'
        ]);
        if($validator->fails()){
            return $this->error('Whoops! Something went wrong. Failed to add review.',  $validator->fails(), 'null', 400);
        }else{
            $user_details = JobByAgency::where('id', $request->job_id)->where('is_activate', 0)->first();

            $create = Review::create([
                'rating' => $request->rating,
                'content' => $request->content,
                'caregiver_id' => auth('sanctum')->user()->id,
                'agency_id' => $user_details->user_id
            ]);

            if($create){
                $total_review = Review::where('agency_id', $user_details->user_id)->count();
                $total_rating = Review::where('agency_id', $user_details->user_id)->avg('rating');
                BusinessInformation::where('user_id', $user_details->user_id)->update([
                    'total_reviews' =>  $total_review,
                    'rating' => $total_rating
                ]);
                return $this->success('Review posted successfully.',  null, 'null', 201);
            }else{
                return $this->error('Whoops! Something went wrong. Failed to add review.',  null, 'null', 500);
            }
        }
    }
}
