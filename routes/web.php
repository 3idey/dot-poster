<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SavedPaymentMethodController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
});
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/', function () {
    return view('home');
})->name('home');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Newsletter routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login.create');
Route::post('/login', [LoginController::class, 'store'])->middleware(['guest', 'throttle:5,1'])->name('login');
Route::delete('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register');

Route::get('/products/recently-viewed', [ProductController::class, 'recentlyViewed'])->name('products.recently-viewed');

Route::resource('products', ProductController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Public routes for all users

// Protected routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Saved Payment Methods
    Route::get('/profile/saved-payment-methods', [SavedPaymentMethodController::class, 'index'])->name('profile.saved-payment-methods.index');
    Route::put('/profile/saved-payment-methods/{savedPaymentMethod}', [SavedPaymentMethodController::class, 'update'])->name('profile.saved-payment-methods.update');
    Route::delete('/profile/saved-payment-methods/{savedPaymentMethod}', [SavedPaymentMethodController::class, 'destroy'])->name('profile.saved-payment-methods.destroy');
    Route::post('/profile/saved-payment-methods/{savedPaymentMethod}/set-default', [SavedPaymentMethodController::class, 'setDefault'])->name('profile.saved-payment-methods.set-default');
});
