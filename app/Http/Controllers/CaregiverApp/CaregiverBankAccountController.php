<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\CaregiverBankAccount;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaregiverBankAccountController extends Controller
{
    use ApiResponser;
    public function addBank(Request $request){
        $validator = Validator::make($request->all(),[
            'bank_name' =>  'required',
            'routing_number' => 'required',
            'account_number' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Something went wrong. Failed to add bank account.',  $validator->errors(), 'null', 400);
        }else{
            $user = User::with('address')->where('id', auth('sanctum')->user()->id)->first();
            $create = CaregiverBankAccount::create([
                'user_id' => auth('sanctum')->user()->id,
                'name' => $user->firstname.' '.$user->lastname,
                'address' => $user->address->street.' '.$user->address->city.' '.$user->address->state.' '.$user->address->zip_code,
                'bank_name' => $request->bank_name,
                'routing_number' => $request->routing_number,
                'account_number' => $request->account_number
            ]);

            if($create){
                $details = CaregiverBankAccount::where('user_id', auth('sanctum')->user()->id)->first();
                return $this->success('Bank account added successfully.',  $details, 'null', 201);
            }else{
                return $this->error('Whoops! Something went wrong. Failed to add bank account.',  null, 'null', 500);
            }
        }
    }   


    public function getBankDetails(){
        $bank_details = CaregiverBankAccount::where('user_id', auth('sanctum')->user()->id)->first();
        return $this->success('Bank account added successfully.',  $bank_details, 'null', 200);
    }
}
