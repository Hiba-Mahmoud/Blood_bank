<?php

use Doctrine\DBAL\Driver\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Client\ClientController;



/*
|--------------------------------------------------------------------------
| clients Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix'=>'clients'], function(){
    Route::get('/',[ClientController::class,'posts']);

    Route::get('contact');
    Route::get('setting');
    Route::get('posts',);
    Route::get('post-details\{id}',[ClientController::class,'posts'])->name('post-details');
    Route::get('donation-requests');
    Route::get('donation-request-details');
    Route::get('login',);
    Route::get('registeration',);
    Route::get('reset-password',);
    Route::get('reset-password',);
    Route::group(['Middleware'=>'auth:client'],function(){
        Route::get('profile',);
        Route::get('profile-setting',);
        Route::get('notification',);
        Route::get('notification-setting',);
        Route::get('donation-form',);

    });
} );


Route::resource('client', ClientController::class);
