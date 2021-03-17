<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    // Route::resource('profiles', ProfileController::class);

    Route::prefix('profiles')->group(function () {
        Route::name('profiles.show')->get('{id}', [ProfileController::class, 'show']);
        Route::name('profiles.update')->match(['put', 'patch'],'{id}', [ProfileController::class, 'update']);
    });
});
