<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

// General dashboard (optional fallback)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only resource routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

// Admin user management (FULL CRUD + role change)
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class)->names('admin.users');
    Route::post('users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
});

require __DIR__.'/auth.php';
