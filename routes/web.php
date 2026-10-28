<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

// ---------- Rutas públicas (solo invitados) ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

// ---------- Rutas protegidas (requieren iniciar sesión) ----------
Route::middleware('auth')->group(function () {

    // La raíz lleva al dashboard
    Route::redirect('/', '/dashboard');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // CRUDs. Excluimos "show" porque no usaremos vista de detalle.
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('suppliers', SupplierController::class)->except('show');
    Route::resource('products', ProductController::class)->except('show');

    // Movimientos de stock
    Route::get('/stock-movements', [StockMovementController::class, 'index'])
        ->name('stock-movements.index');
    Route::post('/stock-movements', [StockMovementController::class, 'store'])
        ->name('stock-movements.store');

    // Cerrar sesión (POST por seguridad CSRF)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});