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

Route::get('mailable', function () {
    $user = App\Models\User::find(1);
    return new App\Mail\UserLogin($user);
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/', function () {return view('welcome');});
    
    Route::get('/home', function () {return view('welcome');});
    
    Route::get('/broadcast', function () {return view('broadcast');});

    Route::get('/logout', function () {
        \Auth::logout();
        return redirect('login');
    });

    Route::get('profile', 'Account\ProfileController@show')->name('profile');
    Route::post('profile', 'Account\ProfileController@update');
    
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', 'Admin\UserController@index')->name('users');
        Route::get('user', 'Admin\UserController@create')->name('user.create');
        Route::get('user', 'Admin\UserController@store');
        Route::get('user/{user}', 'Admin\UserController@show')->name('user.show');
        Route::get('user/{user}/edit', 'Admin\UserController@edit')->name('user.edit');
        Route::post('user/{user}/edit', 'Admin\UserController@update');
        Route::post('user/{user}/delete', 'Admin\UserController@delete');
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