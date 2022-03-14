<?php

namespace App\Http\Controllers\AgencyApp;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;


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
}
