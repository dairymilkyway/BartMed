<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SupplierTransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::resource('orders', OrderController::class);
Route::apiResource('brands', BrandController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('supplier-transactions', SupplierTransactionController::class);

Route::get('/home', [ProductController::class, 'fetchProducts']);

Route::post('/brands/excel',[BrandController::class, 'import'])->name('Bexcel');
Route::post('/suppliers/excel',[SupplierController::class, 'import'])->name('Sexcel');
Route::post('/products/excel',[ProductController::class, 'import'])->name('Pexcel');
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/users/{id}/status', [CustomerController::class, 'changeStatus']);
Route::put('/users/{id}/role', [CustomerController::class, 'changeRole']);
Route::put('/orders/{id}/status', [OrderController::class, 'changeStatus']);


Route::post('/brands/{id}/restore', [BrandController::class, 'restore']);
Route::post('/products/{id}/restore', [ProductController::class, 'restore']);
Route::post('/suppliers/{id}/restore', [SupplierController::class, 'restore']);
Route::middleware('auth:sanctum')->get('/user', [CustomerController::class, 'fetchUserData']);
/*
Route::get('/supplier-transactions', [SupplierTransactionController::class, 'index']);
Route::post('/supplier-transactions', [SupplierTransactionController::class, 'store']);
*/
Route::post('/register', [CustomerController::class, 'store']);
Route::post('/login', [CustomerController::class, 'login']);
Route::post('/logout', [CustomerController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
