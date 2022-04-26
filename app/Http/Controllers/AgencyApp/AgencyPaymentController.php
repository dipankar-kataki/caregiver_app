<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\AgencyPayments;
use App\Models\JobByAgency;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgencyPaymentController extends Controller
{
    use ApiResponser;
    public function savePaymentDetails(Request $request){
        $validator = Validator::make($request->all(),[
            'job_id' => 'required',
            'customer_id' => 'required',
            'amount' => 'required',
            'payment_status' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Failed to save payment details.', $validator->errors(), 'null', 400);
        }else{
            $create = AgencyPayments::create([
                'agency_id' => auth('sanctum')->user()->id,
                'job_id' => $request->job_id,
                'customer_id' => $request->customer_id,
                'amount' => $request->amount,
                'payment_status' => $request->payment_status
            ]);

            if($create){
                if($request->payment_status == 'Success' || $request->payment_status == 'success' || $request->payment_status == 'SUCCESS'){
                    JobByAgency::where('id', $request->job_id)->update([
                        'is_activate' => 1
                    ]);
                    return $this->success('Payment details saved successfully.', null, 'null', 201);
                }else{
                    return $this->error('Failed to save payment details.', null, 'null', 400);
                }
                
            }else{
                return $this->error('Failed to save payment details.', null, 'null', 500);
            }
        }
    }
}
