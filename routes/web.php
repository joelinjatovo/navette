<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', function () {return view('home/index');});
Route::get('/home', function () {return view('home/index');});
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login.provider');
Route::get('login/{provider}/callback','Auth\LoginController@handleProviderCallback');

Route::get('order', 'Shop\IndexController@create')->name('shop.order');
Route::post('order', 'Shop\IndexController@store')->name('shop.order');
Route::post('order/cars', 'Shop\IndexController@cars_ajax')->name('shop.order.cars');
Route::get('cart', 'Shop\CartController@index')->name('shop.cart');
Route::post('cart/clear', 'Shop\CartController@clear')->name('shop.cart.clear');

Route::middleware(['auth'])->group(function () {
    Route::get('checkout', 'Shop\CheckoutController@index')->name('shop.checkout');
    Route::post('gateway/cash/pay', 'Gateway\CashController@pay')->name('gateway.cash.pay');
    Route::post('gateway/stripe/pay', 'Gateway\StripeController@pay')->name('gateway.stripe.pay');
    
    Route::get('/logout', function () {
        \Auth::logout();
        return redirect('login');
    });

    Route::get('account/profile', 'Account\ProfileController@show')->name('account.profile');
    Route::post('account/profile', 'Account\ProfileController@update');

    Route::get('notifications', 'Account\NotificationController@index')->name('notifications');
    Route::get('notifications/unread', 'Account\NotificationController@unread')->name('notifications.unread');
    Route::post('notifications', 'Account\NotificationController@markAsRead');
    
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/', 'Customer\IndexController@index')->name('dashboard');
        
        Route::get('/orders', 'Customer\OrderController@index')->name('orders');
        Route::get('/order', 'Customer\OrderController@create')->name('order.create');
        Route::post('/order', 'Customer\OrderController@store');
        Route::get('/order/{order}', 'Customer\OrderController@show')->name('order.show');
        Route::get('/order/{order}/edit', 'Customer\OrderController@edit')->name('order.edit');
        Route::post('/order/{order}/edit', 'Customer\OrderController@update');
        Route::delete('order/{order}', 'Customer\OrderController@delete')->name('order.delete');
    
        Route::get('order/{order}/item/{item}', 'Customer\ItemController@show')->name('item.show');
    });
    
    Route::middleware(['role:driver'])->prefix('driver')->name('driver.')->group(function () {
        Route::get('/', 'Driver\IndexController@index')->name('dashboard');
		
        Route::get('rides', 'Driver\RideController@index')->name('rides');
        Route::get('ride', 'Driver\RideController@create')->name('ride.create');
        Route::post('ride', 'Driver\RideController@store');
        Route::get('ride/{ride}', 'Driver\RideController@show')->name('ride.show');
        Route::get('ride/{ride}/edit', 'Driver\RideController@edit')->name('ride.edit');
        Route::post('ride/{ride}/edit', 'Driver\RideController@update');
        Route::delete('rides', 'Driver\RideController@delete');
    });
    
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', 'Admin\IndexController@index')->name('dashboard');
        
        Route::get('users', 'Admin\UserController@index')->name('users');
        Route::get('user', 'Admin\UserController@create')->name('user.create');
        Route::post('user', 'Admin\UserController@store')->name('user.store');
        Route::get('user/{user}', 'Admin\UserController@show')->name('user.show');
        Route::get('user/{user}/edit', 'Admin\UserController@edit')->name('user.edit');
        Route::post('user/{user}/edit', 'Admin\UserController@update');
        Route::delete('users', 'Admin\UserController@delete');
        
        Route::get('clubs', 'Admin\ClubController@index')->name('clubs');
        Route::get('club', 'Admin\ClubController@create')->name('club.create');
        Route::post('club', 'Admin\ClubController@store');
        Route::get('club/{club}', 'Admin\ClubController@show')->name('club.show');
        Route::get('club/{club}/edit', 'Admin\ClubController@edit')->name('club.edit');
        Route::post('club/{club}/edit', 'Admin\ClubController@update');
        Route::delete('clubs', 'Admin\ClubController@delete');
        
        Route::get('cars', 'Admin\CarController@index')->name('cars');
        Route::get('car', 'Admin\CarController@create')->name('car.create');
        Route::post('car', 'Admin\CarController@store');
        Route::get('car/{car}', 'Admin\CarController@show')->name('car.show');
        Route::get('car/{car}/edit', 'Admin\CarController@edit')->name('car.edit');
        Route::post('car/{car}/edit', 'Admin\CarController@update');
        Route::delete('cars', 'Admin\CarController@delete');
        
        Route::get('orders', 'Admin\OrderController@index')->name('orders');
        Route::get('order', 'Admin\OrderController@create')->name('order.create');
        Route::post('order', 'Admin\OrderController@store');
        Route::get('order/{order}', 'Admin\OrderController@show')->name('order.show');
        Route::get('order/{order}/edit', 'Admin\OrderController@edit')->name('order.edit');
        Route::post('order/{order}/edit', 'Admin\OrderController@update');
        Route::delete('orders', 'Admin\OrderController@delete');
        Route::put('orders', 'Admin\OrderController@action');
        
        Route::get('rides', 'Admin\RideController@index')->name('rides');
        Route::get('ride', 'Admin\RideController@create')->name('ride.create');
        Route::post('ride', 'Admin\RideController@store');
        Route::get('ride/{ride}', 'Admin\RideController@show')->name('ride.show');
        Route::get('ride/{ride}/live', 'Admin\RideController@live')->name('ride.live');
        Route::get('ride/{ride}/vuejs', 'Admin\RideController@vuejs')->name('ride.vuejs');
        Route::get('ride/{ride}/edit', 'Admin\RideController@edit')->name('ride.edit');
        Route::post('ride/{ride}/edit', 'Admin\RideController@update');
        Route::delete('rides', 'Admin\RideController@delete');
        Route::put('rides', 'Admin\RideController@action');
        
        Route::get('items', 'Admin\ItemController@index')->name('items');
        Route::get('item', 'Admin\ItemController@create')->name('item.create');
        Route::post('item', 'Admin\ItemController@store');
        Route::get('item/{item}', 'Admin\ItemController@show')->name('item.show');
        Route::get('item/{item}/edit', 'Admin\ItemController@edit')->name('item.edit');
        Route::post('item/{item}/edit', 'Admin\ItemController@update');
        Route::delete('items', 'Admin\ItemController@delete');
        Route::put('items', 'Admin\ItemController@action');
        
        Route::get('apikeys', 'Admin\ApiKeyController@index')->name('apikeys');
        Route::get('apikey', 'Admin\ApiKeyController@create')->name('apikey.create');
        Route::post('apikey', 'Admin\ApiKeyController@store');
        Route::get('apikey/{apikey}', 'Admin\ApiKeyController@show')->name('apikey.show');
        Route::get('apikey/{apikey}/edit', 'Admin\ApiKeyController@edit')->name('apikey.edit');
        Route::post('apikey/{apikey}/edit', 'Admin\ApiKeyController@update');
        Route::post('apikey/{apikey}/delete', 'Admin\ApiKeyController@delete')->name('apikey.delete');
        
        Route::get('/settings', 'Admin\SettingController@index')->name('settings');
    });
    
});

/*ROUTES USER PANEL*/
Route::get('/user/tableau-de-bord', function () {
    return view('user/dashboard', ['active_dashboard' => true]);
});
Route::get('/user/mon-profil', function () {
    return view('user/profile', ['active_profile' => true]);
});
Route::get('/user/reservation', function () {
    return view('user/new_ride', ['active_new_ride' => true]);
});
Route::get('/user/historiques', function () {
    return view('user/my_rides', ['active_my_rides' => true]);
});
/*END ROUTES USER PANEL*/