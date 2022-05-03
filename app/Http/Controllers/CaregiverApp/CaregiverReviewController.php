<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\BusinessInformation;
use App\Models\JobByAgency;
use App\Models\Registration;
use App\Models\Review;
use App\Models\User;
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
            return $this->error('Whoops! Something went wrong. Failed to add review.',  $validator->errors(), 'null', 400);
        }else{
            $user_details = JobByAgency::where('id', $request->job_id)->first();

            $create = Review::create([
                'review_by' => auth('sanctum')->user()->id,
                'role' => 'caregiver',
                'rating' => $request->rating,
                'content' => $request->content,
                'review_to' => $user_details->user_id,
                'job_id' => $request->job_id
            ]);

            if($create){
                $total_review = Review::where('review_to', $user_details->user_id)->count();
                $total_rating = Review::where('review_to', $user_details->user_id)->avg('rating');
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

    public function getReview(){
        $review = Review::with('agency')->where('review_to', auth('sanctum')->user()->id)->latest()->get();
        $new_details = [];
        foreach($review as $key => $item){
            $user = User::where('id', $item->review_by)->first();
            $details = [
                'rating' => $item->rating,
                'content' => $item->content,
                'posted_by' => $user->business_name,
                'photo' => null,
                'created_at' => $item->created_at->diffForHumans()
            ];
            
            array_push($new_details, $details);
        }
        return $this->success('Review fetched successfully.',  $new_details, 'null', 200);
    }
}
