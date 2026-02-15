<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.show');

use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login routes (no auth required)
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/products', [AdminController::class, 'products'])->name('products');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');

        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
        Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');
        Route::get('/orders/{id}/invoice', [AdminController::class, 'generateInvoice'])->name('orders.invoice');
    });
});

use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

use App\Http\Controllers\BasicAuthController;

Route::get('/login', [BasicAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [BasicAuthController::class, 'login'])->name('login.post');
Route::get('/register', [BasicAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [BasicAuthController::class, 'register'])->name('register.post');
Route::post('/logout', [BasicAuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\CheckoutController;

Route::middleware('auth')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');

    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

});



use App\Http\Controllers\Customer\AccountController as CustomerAccountController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\AddressController;

Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [CustomerAccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [CustomerAccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [CustomerAccountController::class, 'orderShow'])->name('order.show');
    Route::post('/orders/{id}/cancel', [CustomerAccountController::class, 'cancelOrder'])->name('order.cancel');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Address Routes
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{id}/set-default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
});