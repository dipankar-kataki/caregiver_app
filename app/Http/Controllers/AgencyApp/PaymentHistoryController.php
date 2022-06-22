<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\AgencyPayments;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{   
    use ApiResponser;
    public function getPaymentHistory(){
        try{
            $payment_history = AgencyPayments::with('job')->where('agency_id', auth('sanctum')->user()->id)->latest()->get();
            $new_details = [];
            foreach( $payment_history as $item){
                $details = [
                    'amount' => $item->amount,
                    'job_title' => $item->job->job_title,
                    'paid_on' => $item->created_at->diffForHumans()
                ];
                array_push($new_details, $details);
            }
            return $this->success('Payment history fetched successfully. Working try', $new_details, 'null', 200);
        }catch(\Exception $e){
            return $this->error('Whoops! Something went wrong. Failed to fetch payment history. Please try after sometime', null, 'null', 500);
        }
        
    }
}
