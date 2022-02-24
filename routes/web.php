<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
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


Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::group([
        'prefix' => 'web',
        'middleware' => 'auth'
    ], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});