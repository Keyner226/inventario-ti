<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

// La página de inicio redirige al listado de productos
Route::redirect('/', '/products');

// Rutas CRUD de cada módulo. Excluimos "show" porque no usaremos vista de detalle.
Route::resource('categories', CategoryController::class)->except('show');
Route::resource('suppliers', SupplierController::class)->except('show');
Route::resource('products', ProductController::class)->except('show');
Route::get('/stock-movements', [StockMovementController::class, 'index'])
    ->name('stock-movements.index');
Route::post('/stock-movements', [StockMovementController::class, 'store'])
    ->name('stock-movements.store');