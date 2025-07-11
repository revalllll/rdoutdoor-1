<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Product;
use App\Http\Controllers\CheckoutController;

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
    Route::get('orders/export-pdf', [ReportController::class, 'exportOrderPdf'])->name('orders.exportPdf');
    Route::get('orders/{id}/export-pdf', [ReportController::class, 'exportOrderResi'])->name('orders.exportResi');
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

// Route resource produk untuk user (hanya show/detail)
Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->only(['show']);

// Route resource order untuk user (hanya store)
Route::resource('orders', \App\Http\Controllers\User\OrderController::class)->only(['store']);

// Route untuk keranjang user
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/checkout', [\App\Http\Controllers\CartCheckoutController::class, 'show'])->name('cart.checkout');
    Route::post('/cart/checkout', [\App\Http\Controllers\CartCheckoutController::class, 'store'])->name('cart.checkout.submit');
});

// Route untuk pesanan user
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', function () {
        // Sementara, tampilkan view kosong atau pesan
        return view('orders.index');
    })->name('orders.index');
});

// Route untuk bantuan/kontak user
Route::middleware(['auth'])->group(function () {
    Route::get('/help', function () {
        return view('help');
    })->name('help');
});

// Route untuk menampilkan semua produk
Route::get('/products/all', function () {
    $products = Product::latest()->get();
    return view('products.all', compact('products'));
})->name('products.all');

// Route untuk checkout (review form, GET)
Route::match(['GET', 'POST'], '/checkout', [CheckoutController::class, 'checkoutForm'])->name('checkout.form');
// Route untuk proses order (POST)
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Route untuk metode pembayaran
Route::get('/payment/{order}', [CheckoutController::class, 'paymentMethod'])->name('payment.method');

// Route untuk pembayaran Midtrans Snap
Route::get('/pay/{order}', [CheckoutController::class, 'payWithMidtrans'])->name('midtrans.pay');

// Route untuk halaman finish pembayaran Midtrans
Route::get('/payment/finish', function () {
    return view('payment.finish');
})->name('payment.finish');

// Route untuk halaman error pembayaran Midtrans
Route::get('/payment/error', function () {
    return view('payment.error');
})->name('payment.error');

// Auth routes (default Laravel Breeze/Fortify/etc)
require __DIR__.'/auth.php';