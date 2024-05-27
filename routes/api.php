<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware(JwtMiddleware::class)->group(function () {
    Route::post('/user', function () {
        return auth()->user();
    });
    Route::post('/send-forget-password-email', [AuthController::class, 'sendForgetPasswordEmail']);
});
