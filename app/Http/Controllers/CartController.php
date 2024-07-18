<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $user = auth()->user();
         $customer = $user->customer;
         if (!$customer) {
             return response()->json(['error' => 'Customer not found'], 404);
         }
         $cartItems = Cart::where('customer_id', $customer->id)
                         ->with('product')
                         ->get();
         return response()->json(['data' => $cartItems], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($productId, $quantity, Request $request)
    {
        // $request->validate([
        //     'quantity' => 'required|integer|min:1',
        // ]);

        $product = Product::findOrFail($productId);
        $userId = auth()->id();
        $customer = Customer::where('user_id', $userId)->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $cart = new Cart();
        $cart->customer_id = $customer->id;
        $cart->product_id = $productId;
        $cart->quantity = $quantity;
        $cart->save();
        return response()->json(['message' => 'Product added to cart successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($cartId, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($cartId);
        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(['message' => 'Cart item quantity updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->delete();

        return response()->json(['message' => 'Cart item deleted successfully'], 200);
    }
}
