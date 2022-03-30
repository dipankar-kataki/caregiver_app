<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\BusinessInformation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Address;
use Carbon\Carbon;
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
            'country_of_business_formation' => 'required',
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
                'country_of_business_formation' => $request->country_of_business_formation,
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
                return $this->success('Profile update successfully.', null, 'null', 200);
            }else{
                return $this->error('Whoops! Something went wrong.', null, 'null', 500);
            }
        }
    }

    public function getFormatedProfileDetails(Request $request){
        $profile_details = User::with('address', 'business_information')->where('id', auth('sanctum')->user()->id)->first();
        if($profile_details->business_information  != null){
            $year_started =  Carbon::now()->subYears($profile_details->business_information->years_in_business);

            $beneficiary = '';
            if($profile_details->business_information->beneficiary == null){
                $beneficiary = null;
            }else{
                $beneficiary = $profile_details->business_information->beneficiary;
            }

            $homecare_service = '';
            if($profile_details->business_information->homecare_service == null){
                $homecare_service = null;
            }else{
                $homecare_service = $profile_details->business_information->homecare_service;
            }

            $details = [
                'business_name' => $profile_details->business_name,
                'phone' => $profile_details->business_information->business_number,
                'year_started' => $year_started->format('Y').' ('.$profile_details->business_information->years_in_business.' '.'years)',
                'legal_structure_of_business' => $profile_details->business_information->legal_structure,
                'no_of_employees' => $profile_details->business_information->no_of_employee,
                'address' => $profile_details->address->street.', '. $profile_details->address->city.', '. $profile_details->address->zip_code.', '. $profile_details->address->state,
                'annual_business_revenue' => '$ '.$profile_details->business_information->annual_business_revenue,
                'bio' => $profile_details->business_information->bio,
                'our_beneficiaries' => $beneficiary,
                'homecare_services' => $homecare_service
            ];
            return $this->success('Profile details fetched successfully.',  $details, 'null', 200);
        }else{
            return $this->success('Profile details fetched successfully.', null, 'null', 200);
        }
        
    }
    public function getProfileDetails(Request $request){
        $profile_details = User::with('address', 'business_information')->where('id', auth('sanctum')->user()->id)->first();

        $beneficiary = '';
        if($profile_details->business_information->beneficiary == null){
            $beneficiary = null;
        }else{
            $beneficiary = $profile_details->business_information->beneficiary;
        }

        $homecare_service = '';
        if($profile_details->business_information->homecare_service == null){
            $homecare_service = null;
        }else{
            $homecare_service = $profile_details->business_information->homecare_service;
        }
        
        if($profile_details->business_information  != null){
            $details = [
                'bio' => $profile_details->business_information->bio,
                'business_name' => $profile_details->business_name,
                'business_number' => $profile_details->business_information->business_number,
                'legal_structure_of_business' => $profile_details->business_information->legal_structure,
                'organization_type' => $profile_details->business_information->organization_type,
                'tax_id' => $profile_details->business_information->tax_id,
                'no_of_employees' => $profile_details->business_information->no_of_employee,
                'years_in_business' => $profile_details->business_information->years_in_business,
                'country_of_business_formation' => $profile_details->business_information->country_of_business_formation,
                'annual_business_revenue' => $profile_details->business_information->annual_business_revenue,
                'our_beneficiaries' => $beneficiary,
                'homecare_services' => $homecare_service,
                'street' => $profile_details->address->street,
                'city' => $profile_details->address->city,
                'state' => $profile_details->address->state,
                'zip_code' => $profile_details->address->zip_code
            ];
            return $this->success('Profile details fetched successfully.',  $details, 'null', 200);
        }else{
            return $this->success('Profile details fetched successfully.', null, 'null', 200);
        }
        
    }
}
