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
Route::prefix('v1')->name('api.')->group(function () {
    Route::get('scope', function (Request $request) {return response()->json(['data'=>encrypt('scopes')]);})->name('scopes');
});

Route::prefix('v1')->name('api.')->namespace('Api\v1\Gateway')->group(function () {
    Route::post('stripe/webhook', 'StripeController@webhook')->name('gateway.stripe.webhook');
    Route::post('paypal/webhook', 'PayPalController@webhook')->name('gateway.paypal.webhook');
});
Route::middleware('apikey')->prefix('v1')->name('api.')->namespace('Api\v1')->group(function () {
    Route::get('settings', 'SettingsController@index')->name('settings');
	
    Route::post('token', 'TokenController@create')->name('token');
    Route::post('token/refresh', 'TokenController@refresh')->name('token.refresh');
    Route::post('register', 'UserController@store')->name('user.create');
    Route::post('facebook/connect', 'FacebookController@connect')->name('facebook.connect');
    Route::post('upload/license/{type}', 'UploadController@license')->name('upload.license')->where('type', 'verso|recto');
    Route::post('upload/vtc/{type}', 'UploadController@vtc')->name('upload.vtc')->where('type', 'verso|recto');
	
	Route::get('clubs', 'ClubController@index')->name('clubs');
	Route::post('cart', 'OrderController@cart')->name('order.cart');
    Route::middleware('auth:api')->group(function () {
        Route::post('contact', 'ContactController@contact')->name('contact');
        Route::post('logout', 'TokenController@logout')->name('logout');
        Route::post('verify', 'VerificationController@verify')->name('verification.verify');
        Route::get('resend', 'VerificationController@resend')->name('verification.resend');
        Route::get('user', 'UserController@show')->name('user.show');
        Route::put('user', 'UserController@update')->name('user.edit');
        Route::post('user/avatar', 'UserController@avatar')->name('user.avatar');
        Route::post('user/license/{type}', 'UserController@license')->name('user.license')->where('type', 'verso|recto');
        Route::post('user/vtc/{type}', 'UserController@vtc')->name('user.vtc')->where('type', 'verso|recto');
        Route::post('user/rate', 'UserController@rate')->name('user.rate');
        Route::post('user/position', 'UserPointController@store')->name('user.position.create');
        
        Route::get('orders', 'OrderController@index')->name('orders');
        Route::get('order/{order}', 'OrderController@show')->name('order.show');
        Route::post('order/cancel', 'OrderController@cancel')->name('order.cancel');
        Route::middleware('verified')->group(function () {
            Route::post('order', 'OrderController@store')->name('order.create');
            Route::post('order/{order}', 'OrderController@update')->name('order.update');
            Route::post('order/cancel', 'OrderController@cancel')->name('order.cancel');
            Route::namespace('Gateway')->name('gateway.')->group(function () {
                Route::post('cash/pay', 'CashController@pay')->name('cash.pay');
                Route::post('stripe/pay', 'StripeController@pay')->name('stripe.pay');
				Route::get('stripe/setup-intent', 'StripeController@setupIntent')->name('stripe.setup.intent');
				Route::get('stripe/cards', 'StripeController@paymentMethods')->name('stripe.cards');
                Route::post('paypal/pay', 'PayPalController@pay')->name('paypal.pay');
            });
        });
        
        Route::post('car', 'CarController@toggle')->name('car.toggle');
        
        Route::get('notifications', 'NotificationController@index')->name('notifications');
        Route::post('notifications', 'NotificationController@markAsRead')->name('notifications.markAsRead');
        Route::get('notifications/unread', 'NotificationController@unread')->name('notifications.unread');
        
        Route::get('rides', 'RideController@index')->name('rides');
        Route::get('ride', 'RideController@current')->name('ride.current');
        Route::get('ride/{ride}', 'RideController@show')->name('ride.show');
        Route::get('ride/{ride}/items', 'RideController@items')->name('ride.items');
        Route::get('ride/{ride}/points', 'RideController@points')->name('ride.points');
        Route::post('ride/{ride}/attach-item', 'RideController@attachItem')->name('ride.attach.item');
        Route::post('ride/start', 'RideController@start')->name('ride.start');
        Route::post('ride/cancel', 'RideController@cancel')->name('ride.cancel');
        Route::post('ride/complete', 'RideController@complete')->name('ride.complete');
        Route::post('ride/direction', 'RideController@direction')->name('ride.direction');
		
        Route::post('rideitem/arrive', 'RideItemController@arrive')->name('rideitem.arrive'); // Driver
        Route::post('rideitem/cancel', 'RideItemController@cancel')->name('rideitem.cancel'); // Driver
        Route::post('rideitem/pick-or-drop', 'RideItemController@pickOrDrop')->name('rideitem.pickOrDrop'); // Driver
		
        Route::get('items', 'ItemController@index')->name('items'); // Customer
        Route::get('item/{item}', 'ItemController@show')->name('item.show'); // Customer
        Route::post('item/cancel', 'ItemController@cancel')->name('item.cancel'); // Customer
    });
});