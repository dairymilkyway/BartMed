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
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/checout', function () {
    return view('checkout');
});

Route::get('/brand', function () {
    return view('brand.index');
});

Route::get('/product', function () {
    return view('product.index');
});

Route::get('/supplier', function () {
    return view('supplier.index');
});



Route::post('/brand/import', [BrandController::class, 'import'])->name('brand.import');
