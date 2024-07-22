<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SupplierTransactionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Models\Product;

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
Route::apiResource('carts', CartController::class);
Route::apiResource('supplier-transactions', SupplierTransactionController::class);

Route::get('/home', [ProductController::class, 'fetchProducts']);
Route::get('/search', [ProductController::class, 'search']);

Route::post('/brands/excel',[BrandController::class, 'import'])->name('Bexcel');
Route::post('/suppliers/excel',[SupplierController::class, 'import'])->name('Sexcel');
Route::post('/products/excel',[ProductController::class, 'import'])->name('Pexcel');
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/users/{id}/status', [CustomerController::class, 'changeStatus']);
Route::put('/users/{id}/role', [CustomerController::class, 'changeRole']);
Route::put('/orders/{id}/status', [OrderController::class, 'changeStatus']);
Route::put('/update-profile', [CustomerController::class, 'update'])->name('profile.update');
Route::put('/deactivate-account', [CustomerController::class, 'deactivateAccount']);
Route::post('/update-picture', [CustomerController::class, 'updatePicture']);

Route::post('/brands/{id}/restore', [BrandController::class, 'restore']);
Route::post('/products/{id}/restore', [ProductController::class, 'restore']);
Route::post('/suppliers/{id}/restore', [SupplierController::class, 'restore']);
Route::middleware('auth')->get('/fetchuser', [CustomerController::class, 'fetchUserData']);
/*
Route::get('/supplier-transactions', [SupplierTransactionController::class, 'index']);
Route::post('/supplier-transactions', [SupplierTransactionController::class, 'store']);
*/
Route::post('/register', [CustomerController::class, 'store']);
Route::post('/login', [CustomerController::class, 'login']);
Route::post('/logout', [CustomerController::class, 'logout']);


Route::post('/add/{productId}/{quantity}', [CartController::class, 'store'])->middleware('auth');
Route::get('/fetchcart', [CartController::class, 'index']); // Example route to fetch cart items
// Route::prefix('cart')->group(function () {
//     Route::delete('/{cart}', [CartController::class, 'destroy'])->name('cart.destroy'); // Route to delete a cart item
//     Route::patch('/{cart}', [CartController::class, 'update'])->name('cart.update'); // Route to update a cart item
// });
Route::delete('/cart/{customerId}/{productId}', [CartController::class, 'destroy']);
Route::post('/cart/update/{cartItemId}', [CartController::class, 'update']);
Route::post('/cart/update-status', [CartController::class, 'updateStatus']);


Route::get('/product/chartdata', [ProductController::class, 'PdataChart']);
Route::get('/customer/chartdata', [CustomerController::class, 'customerChart']);
Route::get('/brand/chartdata', [BrandController::class, 'brandchart']);

Route::get('/cart-items', [CheckoutController::class, 'getCartItems']);
Route::get('/user-email', [CheckoutController::class, 'getUserEmail']);
Route::get('/user-name', [CheckoutController::class, 'getUserName']);
Route::get('/get-address', [CheckoutController::class, 'getAddress']);
Route::post('/order-store', [OrderController::class, 'store']);
Route::get('/fetch-order', [OrderController::class, 'fetchOrder'])->middleware('auth');
Route::post('/cancel-order', [OrderController::class, 'cancelOrder']);
Route::post('/add-review', [OrderController::class, 'addReview']);
Route::get('/reviews/{product}', [OrderController::class, 'getReviews']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
