<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\BusinessInformation;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessInformationController extends Controller
{   
    use ApiResponser;

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'business_number' => 'required',
            'legal_structure' => 'required',
            'organization_type' => 'required | string',
            'tax_id' => 'required | numeric',
            'no_of_employee' => 'required | numeric',
            'years_in_business' => 'required | numeric | min:1',
            'country_of_business' => 'required',
            'annual_business_revenue' => 'required | numeric',
            'street' => 'required',
            'city' => 'required | string',
            'state' => 'required | string',
            'zip_code' => 'required | numeric'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Registration failed. '.$validator->errors()->first(), null, 'null', 400);
        }else{
            $createBusinessInfo = BusinessInformation::create([
                'business_number' => $request->business_number,
                'legal_structure' => $request->legal_structure,
                'organization_type' => $request->organization_type,
                'tax_id' => $request->tax_id,
                'no_of_employee' => $request->no_of_employee,
                'years_in_business' => $request->years_in_business,
                'country_of_business_formation' => $request->country_of_business,
                'annual_business_revenue' => $request->annual_business_revenue,
                'user_id' =>  auth('sanctum')->user()->id
            ]);

            $createAddress = Address::create([
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'user_id' =>  auth('sanctum')->user()->id
            ]);

            if($createBusinessInfo && $createAddress){
                User::where('id', auth('sanctum')->user()->id)->where('role', 3)->update([
                    'is_business_info_added' => 1
                ]);
                return $this->success('Business information added successfully.', null, 'null', 201);
            }else{
                return $this->error('Whoops! Something went wrong. Registration failed.', null,' null', 500);
            }
        }
    }
}
