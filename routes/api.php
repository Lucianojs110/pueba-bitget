<?php

use App\Http\Controllers\AuthController;
use App\Services\BitgetService;
use Illuminate\Support\Facades\Route;

//  Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//  Rutas protegidas por token
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/bitget/balance', function (BitgetService $bitget) {
        return $bitget->getBalance();
    });
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
