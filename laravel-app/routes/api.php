<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', '\App\Http\Controllers\Api\AuthController@login')->name('login.api');

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', '\App\Http\Controllers\Api\AuthController@logout')->name('logout.api');

    Route::apiResource('tasks', \App\Http\Controllers\Api\TaskController::class);
    Route::post('/tasks/{task}/complete', '\App\Http\Controllers\Api\TaskController@complete')->name('tasks.complete');

});
