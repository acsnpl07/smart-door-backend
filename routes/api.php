<?php

use App\Http\Controllers\UserController;
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


Route::group(['middleware' => 'auth:sanctum'], function () {
    //All secure URL's
    Route::group(['prefix' => 'user'], function () {
        Route::get("", [UserController::class,'index']);
        Route::get("me", [UserController::class,'showMe']);
        Route::post("store", [UserController::class,'store']);
    });
});

Route::post("login", [UserController::class,'login']);
