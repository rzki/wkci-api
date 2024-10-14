<?php

use App\Http\Controllers\YukkApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1.0/generate-token', [YukkApiController::class, 'generateAccessToken']);
Route::get('/v1.0/generate-qr', [YukkApiController::class, 'generateQR']);
Route::get('/v1.0/access-token/b2b', [YukkApiController::class, 'generateAccessTokenForYUKK']);
Route::post('/v1.0/qr/qr-mpm-notify', [YukkApiController::class, 'paymentNotification']);
