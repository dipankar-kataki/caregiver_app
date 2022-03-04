<?php

use App\Http\Controllers\AgencyApp\AuthController;
use App\Http\Controllers\AgencyApp\AuthorizedOfficerController;
use App\Http\Controllers\AgencyApp\BusinessInformationController;
use App\Http\Controllers\AgencyApp\CreateJobController;
use App\Http\Controllers\CaregiverApp\DocumentController;
use App\Http\Controllers\CaregiverApp\ForgotPasswordController;
use App\Http\Controllers\CaregiverApp\LoginController;
use App\Http\Controllers\CaregiverApp\ProfileController;
use App\Http\Controllers\CaregiverApp\RegistrationController;
use App\Http\Controllers\CaregiverApp\SignUpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**********************************  Caregiver Api's *********************************************/

    /******************************** Login & Signup *******************************/

    Route::post('signup',[SignUpController::class,'signup']);
    Route::post('login',[LoginController::class,'login']);
    Route::prefix('forgot-password')->group(function(){
        Route::post('send-reset-link', [ForgotPasswordController::class, 'sendResetLink']);
        Route::post('update-password', [ForgotPasswordController::class, 'updatePassword']);
    });



    /******************************** Internal Pages *******************************/

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/registration',[RegistrationController::class,'registration']);

        Route::get('get-document',[DocumentController::class,'index']);
        Route::post('document-upload',[DocumentController::class,'uploadDocument']);
        
        Route::prefix('profile')->group(function(){

            /************************************* General Profile Api's ********************************************* */
            Route::get('get-profile-header',[ProfileController::class,'index']);
            Route::post('edit-profile',[ProfileController::class,'editProfile']);
            Route::get('get-basic-details',[ProfileController::class,'getBasicDetails']);
            Route::post('upload-photo',[ProfileController::class,'uploadProfilePhoto']);
            Route::get('get-bio',[ProfileController::class,'getBio']);
            Route::get('get-profile-completion-status',[ProfileController::class,'profileCompletionStatus']);

            /************************************* Address Api's ********************************************* */
            Route::prefix('address')->group(function(){
                Route::get('get-address',[ProfileController::class,'getAddress']);
                Route::post('edit-address',[ProfileController::class,'editAddress']);
            });

            /************************************* Education Api's ********************************************* */
            Route::prefix('education')->group(function(){
                Route::get('get-education',[ProfileController::class,'getEducation']);
                Route::post('edit-education',[ProfileController::class,'editEducation']);
            }); 
        });

        /************************************* Password Change Api ********************************************* */

        Route::post('change-password',[LoginController::class,'changePassword']);

        /************************************* Logout Api's ********************************************* */
        Route::get('logout',function(){
            auth()->user()->tokens()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Logout successful.',
                'data' => null,
                'token' => 'null',
                'http_status_code' => 200
            ]);
        });
        
    });

    /******************************** Check If Token Expired *******************************/

    Route::get('/login-expire',function(){
        return response()->json([
            'status' => 'error',
            'message' => 'Login expired. Please re-login.',
            'data' => null,
            'token' => 'null',
            'http_status_code' => 401
        ]);
    })->name('login-expire');



    /*
    |--------------------------------------------------------------------------
    | Agency Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can find Agency API routes for your application.
    |
    */

    Route::prefix('agency')->group(function(){

        Route::prefix('auth')->group(function(){
            Route::post('signup',[ AuthController::class, 'signup']);
            Route::post('login', [AuthController::class, 'login']);
        });

       

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::prefix('business')->group(function(){
                Route::post('business_information', [BusinessInformationController::class, 'create']);
            });
            Route::prefix('authorize-info')->group(function(){
                Route::post('add-authorized-officer', [AuthorizedOfficerController::class, 'create']);
            });
            Route::prefix('job')->group(function(){
                Route::post('create-job', [CreateJobController::class, 'createJob']);
            });

            Route::get('logout',function(){
                auth()->user()->tokens()->delete();
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Logout successful.',
                    'data' => null,
                    'token' => 'null',
                    'http_status_code' => 200
                ]);
            });
        });
        
        
    });