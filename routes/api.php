<?php

use App\Http\Controllers\CaregiverApp\LoginController;
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