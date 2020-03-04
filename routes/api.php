<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\User;

Route::get('/user', function () {
    return new UserResource(User::find(1));
});

Route::get('/users', function () {
    return new UserCollection(User::all());
});