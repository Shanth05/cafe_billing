<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Cashier\POSController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

// Home / welcome
Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect based on role
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('manager')) {
        return redirect()->route('manager.dashboard');
    } elseif ($user->hasRole('cashier')) {
        return redirect()->route('cashier.dashboard');
    }
    return redirect()->route('login')->withErrors(['role' => 'No valid role assigned']);
})->name('dashboard');

// Role dashboards
Route::middleware(['auth', 'verified', 'role:admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::middleware(['auth', 'verified', 'role:manager'])->get('/manager/dashboard', function () {
    return view('manager.dashboard');
})->name('manager.dashboard');

Route::middleware(['auth', 'verified', 'role:cashier'])->get('/cashier/dashboard', function () {
    return view('cashier.dashboard');
})->name('cashier.dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only resource routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

// Admin user management with role change
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class)->names('admin.users');
    Route::post('users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');

    // Admin orders management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
});

// Cashier order routes (create, store, index)
Route::middleware(['auth', 'verified', 'role:cashier'])->group(function () {
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Receipt route under cashier prefix and route name
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('cashier.orders.receipt');
});

// Orders resource routes accessible to authenticated users except cashier-only create/store/index
Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'index']);
});

// Cashier POS routes with prefix 'cashier'
Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->group(function () {
    Route::get('/pos', [POSController::class, 'index'])->name('cashier.pos');
    Route::post('/pos/add-to-cart', [POSController::class, 'addToCart'])->name('cashier.pos.add');
    Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('cashier.pos.checkout');

    // List orders for cashier
    Route::get('/orders', [OrderController::class, 'index'])->name('cashier.orders');
});

Route::prefix('reports')->group(function () {
    Route::get('/daily', [ReportController::class, 'dailyReport'])->name('reports.daily');
    Route::get('/monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly');
});

require __DIR__.'/auth.php';
