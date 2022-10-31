<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\GovernorateController;
use App\Http\Controllers\GeneralController;
use GuzzleHttp\Middleware;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([],function(){
    Route::get('/governorates',[GeneralController::class,'show']);
    Route::get('/cities',[GeneralController::class,'showCities']);
    Route::get('/setting',[GeneralController::class,'setting']);
    Route::get('/categories',[GeneralController::class,'categories']);
    Route::get('/blood-types',[GeneralController::class,'bloodTypes']);
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/reset-password',[AuthController::class,'resetPassword']);
    Route::post('/update-passwod',[AuthController::class,'updatePasswod']);


    Route::middleware(['auth:api'])->group(function (){

    Route::post('/contact-us',[AuthController::class,'contactUs']);
    Route::get('/posts',[GeneralController::class,'posts']);
    Route::get('/favourites',[GeneralController::class,'favourites']);
    Route::post('/favourites',[GeneralController::class,'favourites']);
    Route::post('/donation-request',[GeneralController::class,'donationRequest']);
    Route::post('/toggle-favourite',[GeneralController::class,'toggleFavourite']);
    Route::get('/notification',[GeneralController::class,'notification']);
    Route::get('/profile',[AuthController::class,'profile']);
    Route::post('/update-profile',[AuthController::class,'updateProfile']);
    Route::post('/notification-settings',[AuthController::class,'notificationSettings']);
    Route::post('/register-token',[AuthController::class,'registerToken']);
    Route::post('/remove-token',[AuthController::class,'removeToken']);

});
Route::post('/creat-post',[GeneralController::class,'createPost']);

});

