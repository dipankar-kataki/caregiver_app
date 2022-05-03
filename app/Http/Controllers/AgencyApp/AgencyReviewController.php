<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\BusinessInformation;
use App\Models\CaregiverReview;
use App\Models\JobByAgency;
use App\Models\Registration;
use App\Models\Review;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgencyReviewController extends Controller
{
    use ApiResponser;
    public function addReview(Request $request){
        $validator = Validator::make($request->all(),[
            'job_id' => 'required',
            'rating' => 'required',
            'content' => 'required',
            'accepted_by' => 'required'
        ]);
        if($validator->fails()){
            return $this->error('Whoops! Something went wrong. Failed to add review.',  $validator->fails(), 'null', 400);
        }else{
            
            $create = Review::create([
                'review_by' => auth('sanctum')->user()->id,
                'role' => 'agency',
                'rating' => $request->rating,
                'content' => $request->content,
                'review_to' => $request->accepted_by,
                'job_id' => $request->job_id
            ]);

            if($create){
                $total_review = Review::where('review_to', $request->accepted_by)->count();
                $total_rating = Review::where('review_to', $request->accepted_by)->avg('rating');
                Registration::where('user_id', $request->accepted_by)->update([
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
        $review = Review::where('review_to', auth('sanctum')->user()->id)->latest()->get();
        $new_details = [];
        foreach($review as $key => $item){
            $user = User::with('profile')->where('id', $item->review_by)->first();
            $details = [
                'rating' => $item->rating,
                'content' => $item->content,
                'posted_by' => $user->firstname.''.$user->lastname,
                'photo' => $user->profile->profile_image,
                'created_at' => $item->created_at->diffForHumans()
            ];
            
            array_push($new_details, $details);
        }
        return $this->success('Review fetched successfully.',  $new_details, 'null', 200);
    }
}
