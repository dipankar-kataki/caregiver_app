<?php

use App\Http\Controllers\CaregiverApp\DocumentController;
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
/******************************** Login & Signup *******************************/

Route::post('signup',[SignUpController::class,'signup']);
Route::post('login',[LoginController::class,'login']);


/******************************** Internal Pages *******************************/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/registration',[RegistrationController::class,'registration']);

    Route::get('get-document',[DocumentController::class,'index']);
    Route::post('document-upload',[DocumentController::class,'uploadDocument']);
    
    Route::prefix('profile')->group(function(){
        Route::get('show-profile',[ProfileController::class,'index']);
        Route::post('edit-profile',[ProfileController::class,'editProfile']);
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