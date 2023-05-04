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

Route::resource('devices', 'App\Http\Controllers\DeviceController');
Route::resource('purchases', 'App\Http\Controllers\PurchaseController');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::domain("google.domain")->group(function () {
    Route::resource('subscriptions', 'App\Http\Controllers\GoogleSubscriptionController');
});

Route::domain(config('apple.domain'))->group(function () {
    Route::resource('subscriptions', 'App\Http\Controllers\AppleSubscriptionController');
});

