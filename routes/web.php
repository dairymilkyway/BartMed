<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/orders', function () {
    return view('orderdetails');
})->name('order');

Route::get('/brand', function () {
    return view('brand.index');
})->name('brand.index');


Route::get('/product', function () {
    return view('product.index');
})->name('product.index');

Route::get('/supplier', function () {
    return view('supplier.index');
})->name('supplier.index');

Route::get('/customer', function () {
    return view('customer.index');
})->name('customer.index');

Route::get('/order', function () {
    return view('order.index');
})->name('order.index');



//Route::post('/brand/import', [BrandController::class, 'import'])->name('brand.import');
