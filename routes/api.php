<?php

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
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
Route::middleware('apikey')->prefix('v1')->name('api.')->namespace('Api\v1')->group(function () {
    Route::post('token', 'TokenController@create')->name('token');
    Route::post('token/refresh', 'TokenController@refresh')->name('token.refresh');
    Route::post('register', 'UserController@store')->name('user.create');
    Route::get('clubs', 'ClubController@index')->name('clubs');
    Route::get('club/{club}/cars', 'ClubController@cars')->name('club.cars');
    Route::get('connect/facebook', 'FacebookController@connect')->name('facebook.connect');
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'TokenController@logout')->name('logout');
        Route::post('verify', 'VerificationController@verify')->name('verification.verify');
        Route::get('resend', 'VerificationController@resend')->name('verification.resend');
        Route::get('user', 'UserController@show')->name('user.show');
        Route::put('user/edit', 'UserController@update')->name('user.edit');
        Route::post('user/position', 'UserPointController@store')->name('user.position.create');
        Route::get('orders', 'OrderController@index')->name('orders');
        Route::middleware('verified')->group(function () {
            Route::post('club/{club}/order', 'OrderController@store')->name('order.create');
            Route::post('order/{order}/pay/{type}', 'PaymentController@confirm')->name('order.pay');
        });
        Route::get('notifications', 'NotificationController@index')->name('notifications');
        Route::post('notifications', 'NotificationController@markAsRead')->name('notifications.markAsRead');
        Route::get('notifications/unread', 'NotificationController@unread')->name('notifications.unread');
        Route::get('rides', 'RideController@index')->name('rides');
        Route::get('ride/{ride}/orders', 'RideController@orders')->name('ride.orders');
        Route::post('ride/{ride}/start', 'RideController@start')->name('ride.start');
    });
});