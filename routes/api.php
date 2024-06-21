<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InteriorDesignerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;

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
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/products/variants', ProductVariantController::class);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{cart}', [CartController::class, 'update']);
    Route::delete('/cart/{cart}', [CartController::class, 'destroy']);
    Route::apiResource('/interiorDesigner', InteriorDesignerController::class);
});
