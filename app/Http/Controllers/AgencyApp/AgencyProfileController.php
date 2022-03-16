<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\BusinessInformation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AgencyProfileController extends Controller
{
    use ApiResponser;
    public function completionStatus(Request $request){
        $user = User::where('id', auth('sanctum')->user()->id)->firstOrFail();
        $details = [
            'is_business_info_added' => $user->is_business_info_added,
            'is_authorize_info_added' => $user->is_authorize_info_added,
            'is_user_approved' => $user->is_user_approved
        ];

        return $this->success( 'Profile Completion Status', $details , 'null', 200);
    }

    public function editProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'bio' => 'required',
            'business_number' => 'required',
            'legal_structure' => 'required',
            'organization_type' => 'required',
            'tax_id' => 'required',
            'no_of_employee' => 'required',
            'years_in_business' => 'required',
            'country_of_business' => 'required',
            'annual_business_revenue' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Failed to update profile.', $validator->errors(), 'null', 400);
        }else{
            $update_business_info = BusinessInformation::where('user_id', auth('sanctum')->user()->id)->update([
                'bio' => $request->bio,
                'business_number' => $request->business_number,
                'legal_structure' => $request->legal_structure,
                'organization_type' => $request->organization_type,
                'tax_id' => $request->tax_id,
                'no_of_employee' => $request->no_of_employee,
                'years_in_business' => $request->years_in_business,
                'country_of_business' => $request->country_of_business,
                'annual_business_revenue' => $request->annual_business_revenue,
                'beneficiary' => serialize($request->beneficiary),
                'homecare_service' => serialize($request->homecare_service),
            ]);

            $update_address = Address::where('user_id', auth('sanctum')->user()->id)->update([
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
            ]);

            if($update_business_info && $update_address ){
                return $this->success('Profile update successfully.', null, 'null', 201);
            }else{
                return $this->error('Whoops! Something went wrong.', null, 'null', 500);
            }
        }
    }
}
