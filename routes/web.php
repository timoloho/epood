<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
Route::post('/add-to-cart', [ShopController::class, 'addToCart'])->name('shop.addToCart');
Route::post('/update-cart', [ShopController::class, 'updateCart'])->name('shop.updateCart');
Route::post('/remove-from-cart', [ShopController::class, 'removeFromCart'])->name('shop.removeFromCart');
Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
Route::post('/checkout/payment', [ShopController::class, 'makePayment'])->name('shop.makePayment');