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
})->name('login');;

Route::get('/register', function () {
    return view('register');
});
Route::middleware('web')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home')->middleware('auth');

});

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/profile', function () {
    return view('profile');
})->name('profile')->middleware('auth');

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

Route::get('/SupplierTransaction', function () {
    return view('suppliertransaction.index');
})->name('suppliertransaction.index');

Route::get('/product/chart', function () {
    return view('product.chart');
})->name('product.chart');

Route::get('/customer/chart', function () {
    return view('customer.chart');
})->name('customer.chart');

Route::get('/brand/chart', function () {
    return view('brand.chart');
})->name('brand.chart');
//Route::post('/brand/import', [BrandController::class, 'import'])->name('brand.import');
