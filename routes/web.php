<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Cashier\POSController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

// Home Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Redirect Based on Role
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('manager')) {
        return redirect()->route('manager.dashboard');
    } elseif ($user->hasRole('cashier')) {
        return redirect()->route('cashier.dashboard');
    }

    // Prevent infinite redirect loop
    return abort(403, 'Unauthorized. No valid role assigned.');
})->name('dashboard');

// Dashboard Views by Role
Route::middleware(['auth', 'verified', 'role:admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::middleware(['auth', 'verified', 'role:manager'])->get('/manager/dashboard', function () {
    return view('manager.dashboard');
})->name('manager.dashboard');

Route::middleware(['auth', 'verified', 'role:cashier'])->get('/cashier/dashboard', function () {
    return view('cashier.dashboard');
})->name('cashier.dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->names('users');
        Route::post('users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');

        // Admin Orders
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::post('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
        Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    });
});

// Cashier Routes
Route::middleware(['auth', 'verified', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
    // POS
    Route::get('/pos', [POSController::class, 'index'])->name('pos');
    Route::post('/pos/add-to-cart', [POSController::class, 'addToCart'])->name('pos.add');
    Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');

    // Orders
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
});

// Shared Orders Routes (excluding create/store/index for cashier)
Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'index']);
});

// Reports
Route::prefix('reports')->middleware(['auth'])->group(function () {
    Route::get('/daily', [ReportController::class, 'dailyReport'])->name('reports.daily');
    Route::get('/monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly');
});

// Logout (for clearing redirect loop during dev)
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
