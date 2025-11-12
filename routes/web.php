<?php

use App\Livewire\Assets\CreateForm as AssetsCreateForm;
// -----------------------------
//  CUSTOMERS
// -----------------------------
use App\Livewire\Assets\EditForm as AssetsEditForm;
use App\Livewire\Assets\Index as AssetsIndex;
use App\Livewire\Customers\CreateForm as CustomersCreateForm;
use App\Livewire\Customers\EditForm as CustomersEditForm;
// -----------------------------
//  ASSETS
// -----------------------------
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Customers\Show as CustomersShow;
use App\Livewire\WorkOrders\CreateForm as WorkOrdersCreate;
// -----------------------------
//  WORK ORDERS
// -----------------------------
use App\Livewire\WorkOrders\Index as WorkOrdersIndex;


use Illuminate\Support\Facades\Route;
use App\Livewire\DashboardMain;
use App\Livewire\BitgetBalance;
use App\Livewire\BitgetChart;

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


    Route::get('/bitget/chart', BitgetChart::class)
        ->name('bitget.chart');
});

// -----------------------------
// RUTAS DE AUTENTICACIÓN (BREEZE)
// -----------------------------
require __DIR__ . '/auth.php';
