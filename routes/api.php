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
    Route::get('scope', function (Request $request) {
        return response()->json(['data'=>encrypt('scopes')]);
    })->name('scopes');
});

Route::middleware('apikey')->prefix('v1')->name('api.')->namespace('Api\v1')->group(function () {
    
    Route::post('token', 'TokenController@create')->name('token');
    
    Route::post('token/refresh', 'TokenController@refresh')->name('token.refresh');
    
    Route::post('register', 'UserController@store')->name('user.create');
    
    Route::middleware('auth:api')->group(function () {
    
        Route::post('logout', 'TokenController@logout')->name('logout');
        
        Route::get('user', function (Request $request) {return new UserResource($request->user());})->name('user');
        
        Route::put('user/edit', 'UserController@update')->name('user.edit');
        
        Route::post('user/position', 'UserPointController@store')->name('user.position.create');
        
        Route::post('order', 'OrderController@store')->name('order.create');
    });
});