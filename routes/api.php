<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
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
Route::apiResource('brands', BrandController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('customers', CustomerController::class);

Route::post('/brands/excel',[BrandController::class, 'import'])->name('Bexcel');
Route::post('/suppliers/excel',[SupplierController::class, 'import'])->name('Sexcel');
Route::post('/products/excel',[ProductController::class, 'import'])->name('Pexcel');

Route::put('/users/{id}/status', [CustomerController::class, 'changeStatus']);
Route::put('/users/{id}/role', [CustomerController::class, 'changeRole']);

Route::post('/register', [CustomerController::class, 'store']);
Route::post('/login', [CustomerController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
