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
        $payment_history = AgencyPayments::with('job')->where('agency_id', auth('sanctum')->user()->id)->latest()->get();
        $new_details = [];
        foreach( $payment_history as $item){
            $details = [
                'amount' => $item->amount,
                'job' => $item->job->job_title,
                'paid_on' => $item->created_at->diffForHumans()
            ];
            array_push($new_details, $details);
        }
        return $this->success('Payment history fetched successfully.', $new_details, 'null', 200);
    }
}
