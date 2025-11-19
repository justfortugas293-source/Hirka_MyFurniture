<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Middleware\IsAdmin;

Route::get('/', function () {
    return view('auth_choice');
});

Route::get('/home', [ProductController::class, 'index'])->name('home')->middleware('auth');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/katalog', function () {
    return view('katalog');
})->name('katalog');

Route::get('/account', [AccountController::class, 'show'])->name('account');

Route::get('/auth-choice', function () {
    return view('auth_choice');
})->name('auth.choice');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
// Use DELETE for removing items (form uses method spoofing @method('DELETE'))
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
// Buy now: add single product to cart and go straight to checkout
Route::get('/buy/{id}', [CartController::class, 'buyNow'])->name('buy');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process')->middleware('auth');
Route::get('/checkout/confirmation/{order}', [CartController::class, 'confirmation'])->name('checkout.confirmation')->middleware('auth');

// Invoice route for placed orders
Route::get('/order/{order}/invoice', [CartController::class, 'invoice'])->name('order.invoice')->middleware('auth');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Admin routes - protect with auth and IsAdmin middleware
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});

