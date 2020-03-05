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

Route::middleware(['auth:api'])->prefix('v1')->group(function () {
    Route::get('user', function (Request $request) {
        return new UserResource($request->user());
    });
    
    Route::get('users', 'Api\UserController@index')->name('users');
    Route::get('user/{user}', 'Api\UserController@show')->name('user.show');
    Route::post('user', 'Api\UserController@store')->name('user.create');
    Route::put('user/{user}/edit', 'Api\UserController@update')->name('user.edit');
    Route::delete('user/{user}/delete', 'Api\UserController@delete')->name('user.delete');
});