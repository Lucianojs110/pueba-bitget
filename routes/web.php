<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DashboardMain;
use App\Livewire\BitgetBalance;

// -----------------------------
//  PANEL ADMINISTRATIVO
// -----------------------------
Route::middleware(['auth'])->group(function () {

    // Redirección raíz → dashboard
    Route::redirect('/', '/dashboard');

    // Dashboard principal
    Route::get('/dashboard', DashboardMain::class)
        ->middleware(['verified'])
        ->name('dashboard');


    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    // Balance de Bitget
    Route::get('/bitget', BitgetBalance::class)
        ->name('bitget.balance');
});

// -----------------------------
// RUTAS DE AUTENTICACIÓN (BREEZE)
// -----------------------------
require __DIR__ . '/auth.php';
