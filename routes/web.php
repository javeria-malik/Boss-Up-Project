<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;

// Home-side Routes
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/shop', [HomeController::class, 'shop'])->name('home.shop');
Route::get('/shop-detail/{id}', [HomeController::class, 'show'])->name('home.shopdetail');
Route::get('/shop-cart', [HomeController::class, 'shoppingcart'])->name('home.shopcart');
Route::get('/about', [HomeController::class, 'about'])->name('home.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::post('/contact-us-submit', [ContactController::class, 'store'])->name('contact.store');

// Cart Functionality
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('cart.total');

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/home');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Authenticated User Routes (Requires Email Verification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/place-order', [CartController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/user/dashboard', [AdminController::class, 'userDashboard'])->name('user.dashboard');

    // Logout Route
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('index')->with('success', 'You have been logged out.');
    })->name('logout');
});

// Google Authentication
Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/call-back', [GoogleController::class, 'callbackGoogle']);

// Admin Side Routes (Protected)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/home', [AdminController::class, 'index'])->name('home');
    Route::get('/admin/orders', [AdminController::class, 'totalOrders'])->name('admin.orders');
    Route::get('/admin/customers', [AdminController::class, 'totalCustomers'])->name('admin.customer');

    // Admin Product Routes
    Route::resource('products', ProductsController::class)->except('show');
    Route::post('/products/{id}/toggle-status', [ProductsController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::get('products/with-trash', [ProductsController::class, 'withTrash'])->name('products.with-trash');
    Route::post('products/restore/{id}', [ProductsController::class, 'restore'])->name('products.restore');
    Route::delete('products/delete-permanently/{id}', [ProductsController::class, 'forceDelete'])->name('products.forceDelete');

    // Admin Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('order');
    Route::get('/order-detail/{order}', [OrderController::class, 'order_detail'])->name('order.detail');
    Route::patch('/orders/{id}/update', [OrderController::class, 'update'])->name('order.update');
    Route::get('/order/{id}/send-invoice', [OrderController::class, 'sendInvoiceEmail'])->name('order.sendInvoice');


    // Contact Routes
    Route::get('/admin/contact', [ContactController::class, 'index'])->name('admin.contact');
    Route::get('/admin/contact/{id}', [ContactController::class, 'show'])->name('admin.contact.show');
    Route::delete('/admin/contact/{id}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');

    Route::resource('categories', CategoryController::class);
});
