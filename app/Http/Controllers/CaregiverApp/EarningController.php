<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\CaregiverPayment;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    use ApiResponser;
    public function getEarningDetails(){
        $earning_details = CaregiverPayment::with('job')->where('user_id', auth('sanctum')->user()->id)->get();
        $new_details = [];
        if(! $earning_details->isEmpty()){

            foreach($earning_details as $key => $item){
                $user_details = User::where('id', $item->job->user_id)->get();
                foreach($user_details as $key2 => $item2){
                    $details = [
                        'amount' => $item->amount,
                        'agency' => $item2->business_name,
                        'received_on' => $item->created_at->diffForHumans()
                    ];
                    array_push($new_details, $details);
                }
            }
    
            return $this->success('Earnings fetched successfully.', $new_details, 'null', 200);
        }else{
            return $this->success('Earnings fetched successfully.', $new_details, 'null', 200);
        }
        

    }
}
