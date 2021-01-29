<?php

use App\Http\Controllers\DoorController;
use App\Http\Controllers\DoorLogController;
use App\Http\Controllers\DoorNotificationController;
use App\Http\Controllers\UserController;
use App\Models\Door;
use App\Models\DoorLog;
use App\Models\DoorNotification;
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

// login is done using sanctum
Route::group(['middleware' => 'auth:sanctum'], function () {
    //All secure URL's
    //Asis
    Route::group(['prefix' => 'user'], function () {
        Route::get("", [UserController::class, 'index']);
        Route::get("me", [UserController::class, 'showMe']);
        Route::put("me", [UserController::class, 'updateMe']);
        Route::post("store", [UserController::class, 'store']);
        Route::delete("{user}", [UserController::class, 'destroy']);
        Route::get("{user}", [UserController::class, 'show']);
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get("", [DoorNotificationController::class, 'index']);
        Route::get("count", [DoorNotificationController::class, 'count']);
        Route::get("{doorNotification}", [DoorNotificationController::class, 'show']);
        Route::delete("{doorNotification}", [DoorNotificationController::class, 'destroy']);
    });

// binu
    Route::group(['prefix' => 'door'], function () {
        Route::get("", [DoorController::class, 'index']);
        Route::get("open", [DoorController::class, 'open']);
        Route::get("close", [DoorController::class, 'close']);
    });
    // Asis + Ram
    Route::get("log", [DoorLogController::class, 'index']);
    Route::get("log/{doorLog}", [DoorLogController::class, 'show']);
});

// Asis
Route::post("login", [UserController::class, 'login']);

//binu
//raspberry pie routes
Route::group(['middleware' => 'apikey'], function () {
    Route::group(['prefix' => 'pi'], function () {
        // ram + binu
        Route::post("log", [DoorLogController::class, 'storeFromPi']);
        // binu
        Route::get("ping", [DoorController::class, 'ping']);
        Route::get("door/close", [DoorController::class, 'close']);
    });
});
