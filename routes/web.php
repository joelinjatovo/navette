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

Route::get('/', function () {
    return view('welcome');
});

Route::get('mailable', function () {
    $user = App\Models\User::find(1);
    return new App\Mail\UserLogin($user);
});

Route::middleware(['auth'])->group(function () {

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