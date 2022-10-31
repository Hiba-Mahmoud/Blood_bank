<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BloodTypeController;
use App\Http\Controllers\ClientPostController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BloodTypeClientController;
use App\Http\Controllers\Donation_requestController;
use App\Http\Controllers\ClientGovernorateController;
use App\Http\Controllers\ClientNotificationController;

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

Route::get('/', function () {
    return view('welcome');
});




Route::resource('client', ClientController::class);
Route::resource('bloodtype', BloodTypeController::class);
Route::resource('city', CityController::class);
Route::resource('governorate', GovernorateController::class);
Route::resource('post', PostController::class);
Route::resource('category', CategoryController::class);
Route::resource('clientpost', ClientPostController::class);
Route::resource('donation_request', Donation_requestController::class);
Route::resource('notification', NotificationController::class);
Route::resource('clientnotification', ClientNotificationController::class);
Route::resource('setting', SettingController::class);
Route::resource('bloodtypeclient', BloodTypeClientController::class);
Route::resource('clientgovernorate', ClientGovernorateController::class);
Route::resource('contact', ContactController::class);
