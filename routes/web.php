<?php

use App\Http\Controllers\Admin\AdminForgotPasswordController;
use App\Http\Controllers\Admin\AgencyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CaregiverController;
use App\Http\Controllers\Site\SiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', [SiteController::class, 'index'])->name('site.index');
Route::get('blog/{id?}', [SiteController::class, 'blogs'])->name('site.blog');
Route::post('contact', [SiteController::class, 'contact'])->name('site.contact');
Route::get('terms-and-conditions', [SiteController::class, 'terms'])->name('site.terms');
Route::get('privacy-policy', [SiteController::class, 'privacy'])->name('site.privacy');

Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::prefix('forgot-password')->group(function(){
    Route::get('get', [AdminForgotPasswordController::class, 'forgotPassword'])->name('admin.forgot.password.get');
    Route::post('send-reset-link', [AdminForgotPasswordController::class, 'sendResetLink'])->name('admin.forgot.password.send.reset.link');
    Route::post('verify-otp', [AdminForgotPasswordController::class, 'verifyOTP'])->name('admin.forgot.password.verify.otp');
    Route::post('change-password', [AdminForgotPasswordController::class, 'changePassword'])->name('admin.forgot.password.change.password');
});

Route::group([
        'prefix' => 'web',
        'middleware' => 'auth'
    ], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::prefix('caregiver')->group(function(){
        Route::get('approved-caregivers', [CaregiverController::class, 'approvedCaregiverList'])->name('admin.caregiver.list.approved');
        Route::get('request-for-approval', [CaregiverController::class, 'newJoiner'])->name('admin.caregiver.request.for.approval');
        Route::post('update-status', [CaregiverController::class, 'updateStatus'])->name('admin.caregiver.update.status');
        Route::get('profile/{id}', [CaregiverController::class, 'viewProfile'])->name('admin.caregiver.view.profile');
        Route::post('suspend-user', [CaregiverController::class, 'suspendUser'])->name('admin.caregiver.profile.suspend.user');
    });

    Route::prefix('agency')->group(function(){
        Route::get('approved-agencies', [AgencyController::class, 'approvedAgencyList'])->name('admin.agency.list.approved');
        Route::get('request-for-approval', [AgencyController::class, 'newJoiner'])->name('admin.agency.request.for.approval');
        Route::post('update-status', [AgencyController::class, 'updateStatus'])->name('admin.agency.update.status');
        Route::get('profile/{id}', [AgencyController::class, 'viewProfile'])->name('admin.agency.view.profile');
        Route::post('suspend-user', [AgencyController::class, 'suspendUser'])->name('admin.agency.profile.suspend.user');

        Route::get('posted-jobs', [AgencyController::class, 'job'])->name('admin.agency.get.job');
    });

    Route::prefix('blog')->group(function(){
        Route::get('all-blog', [BlogController::class, 'index'])->name('admin.get.blog');
        Route::post('create-blog', [BlogController::class, 'createBlog'])->name('admin.create.blog');
    });

    Route::prefix('setting')->group(function(){
        Route::get('overview', [AuthController::class, 'getSetting'])->name('admin.setting.get.overview');
        Route::post('update-password', [AuthController::class, 'updatePassword'])->name('admin.setting.update.password');
        Route::post('update-basic-info', [AuthController::class, 'updateBasicInfo'])->name('admin.setting.update.basic.info');
    });

});