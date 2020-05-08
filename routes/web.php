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

Route::get('database/', function () {
    // Test database connection
    try {
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
});

Route::get('migrate/refresh', function () {
    Artisan::queue('migrate:refresh', [
        '--seed' => ''
    ]);
});

Route::get('mailable', function () {
    $user = App\Models\User::find(1);
    return new App\Mail\UserLogin($user);
});

Route::get('runevent', function () {
    $ride = \App\Models\Ride::find(2);
    event(new \App\Events\RideStatusChanged($ride, 'started', 'ping', 'active'));
    return response()->json($ride);
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/', function () {return view('home/index');});
    
    Route::get('/home', function () {return view('home/index');});
    Route::get('/accueil', function () {return view('home/index');});
    
    Route::get('/event', function () {
        event(new \App\Events\MyEvent('hello world'));}
    );
    
    Route::get('/broadcast', function () {
        return view('event');
    });

    Route::get('/logout', function () {
        \Auth::logout();
        return redirect('login');
    });

    Route::get('profile', 'Account\ProfileController@show')->name('profile');
    Route::post('profile', 'Account\ProfileController@update');

    Route::get('notifications', 'Account\NotificationController@index')->name('notifications');
    Route::get('notifications/unread', 'Account\NotificationController@unread')->name('notifications.unread');
    Route::post('notifications', 'Account\NotificationController@markAsRead');
    
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', 'Admin\IndexController@index')->name('dashboard');
        
        Route::get('users', 'Admin\UserController@index')->name('users');
        Route::get('user', 'Admin\UserController@create')->name('user.create');
        Route::post('user', 'Admin\UserController@store')->name('user.store');
        Route::get('user/{user}', 'Admin\UserController@show')->name('user.show');
        Route::get('user/{user}/edit', 'Admin\UserController@edit')->name('user.edit');
        Route::post('user/{user}/edit', 'Admin\UserController@update');
        Route::post('user/{user}/delete', 'Admin\UserController@delete');
        Route::post('user/delete_ajax', 'Admin\UserController@delete_ajax')->name('user.ajax.delete');
        Route::post('user/edit_ajax', 'Admin\UserController@edit_ajax')->name('user.ajax.edit');
        Route::post('user/edit_modal', 'Admin\UserController@edit_modal')->name('user.modal.edit');
        
        Route::get('clubs', 'Admin\ClubController@index')->name('clubs');
        Route::get('club', 'Admin\ClubController@create')->name('club.create');
        Route::post('club', 'Admin\ClubController@store');
        Route::get('club/{club}', 'Admin\ClubController@show')->name('club.show');
        Route::get('club/{club}/edit', 'Admin\ClubController@edit')->name('club.edit');
        Route::post('club/{club}/edit', 'Admin\ClubController@update');
        Route::delete('club/{club}', 'Admin\ClubController@delete')->name('club.delete');
        
        Route::get('cars', 'Admin\CarController@index')->name('cars');
        Route::get('car', 'Admin\CarController@create')->name('car.create');
        Route::post('car', 'Admin\CarController@store');
        Route::get('car/{car}', 'Admin\CarController@show')->name('car.show');
        Route::get('car/{car}/edit', 'Admin\CarController@edit')->name('car.edit');
        Route::post('car/{car}/edit', 'Admin\CarController@update');
        Route::delete('car/{car}', 'Admin\CarController@delete')->name('car.delete');
        
        Route::get('orders', 'Admin\OrderController@index')->name('orders');
        Route::get('order', 'Admin\OrderController@create')->name('order.create');
        Route::post('order', 'Admin\OrderController@store');
        Route::get('order/{order}', 'Admin\OrderController@show')->name('order.show');
        Route::get('order/{order}/edit', 'Admin\OrderController@edit')->name('order.edit');
        Route::post('order/{order}/edit', 'Admin\OrderController@update');
        Route::delete('order/{order}', 'Admin\OrderController@delete')->name('order.delete');
        
        Route::get('rides', 'Admin\RideController@index')->name('rides');
        Route::get('ride', 'Admin\RideController@create')->name('ride.create');
        Route::post('ride', 'Admin\RideController@store');
        Route::get('ride/{ride}', 'Admin\RideController@show')->name('ride.show');
        Route::get('ride/{ride}/edit', 'Admin\RideController@edit')->name('ride.edit');
        Route::post('ride/{ride}/edit', 'Admin\RideController@update');
        Route::post('ride/{ride}/delete', 'Admin\RideController@delete')->name('ride.delete');
        
        Route::get('apikeys', 'Admin\ApiKeyController@index')->name('apikeys');
        Route::get('apikey', 'Admin\ApiKeyController@create')->name('apikey.create');
        Route::post('apikey', 'Admin\ApiKeyController@store');
        Route::get('apikey/{apikey}', 'Admin\ApiKeyController@show')->name('apikey.show');
        Route::get('apikey/{apikey}/edit', 'Admin\ApiKeyController@edit')->name('apikey.edit');
        Route::post('apikey/{apikey}/edit', 'Admin\ApiKeyController@update');
        Route::post('apikey/{apikey}/delete', 'Admin\ApiKeyController@delete')->name('apikey.delete');
        
        Route::get('/settings', 'Admin\SettingController@index')->name('settings');
    });
    
    Route::middleware(['role:driver'])->prefix('driver')->name('driver.')->group(function () {
        //
    });
    
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        //
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

/*ROUTES HOME*/
Route::get('/accueil', function () {
    return view('home/index');
});
/*END ROUTES HOME*/