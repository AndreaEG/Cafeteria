<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth (Persona A)
Route::get('/', fn () => redirect()->route('login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'inactivity'])->group(function () {

    // Solo Admin (Persona A)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class)->except(['show']);
        Route::post('/products/{product}/stock', [ProductController::class, 'adjustStock'])->name('products.stock');
        Route::get('/reportes', [ReportController::class, 'index'])->name('reports.index');
        Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['show', 'edit']);
    });

    // Admin + Trabajador (Persona B)
    Route::middleware('worker')->group(function () {
        Route::get('/pos', [SaleController::class, 'index'])->name('pos.index');
        Route::get('/pos/search', [SaleController::class, 'search'])->name('pos.search');
        Route::post('/ventas', [SaleController::class, 'store'])->name('sales.store');
    });
});

