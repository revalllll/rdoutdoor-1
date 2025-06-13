<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Middleware\RoleMiddleware;

// Halaman utama (landing page custom)
Route::get('/', function () {
    return view('landing');
});

// Dashboard utama (user biasa)
Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route group untuk admin
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin'
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    // Tambahkan resource users jika ada UserController admin
    // Route::resource('users', UserController::class);
});

// Route group untuk user
Route::middleware([
    'auth',
    \App\Http\Middleware\RoleMiddleware::class . ':user'
])->prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    // Route fitur user lain menyusul
});

// Route untuk profile user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Google OAuth routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Route pencarian alat outdoor dari landing page
Route::get('/search', function (\Illuminate\Http\Request $request) {
    $q = $request->input('q');
    $products = \App\Models\Product::where('name', 'like', "%$q%")
        ->orWhere('description', 'like', "%$q%")
        ->get();
    return view('search', compact('q', 'products'));
})->name('search');

// Auth routes (default Laravel Breeze/Fortify/etc)
require __DIR__.'/auth.php';