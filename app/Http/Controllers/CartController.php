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
    public function update(Request $request, $cartItemId)
    {
        $cartItem = Cart::find($cartItemId);
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json(['success' => true, 'quantity' => $cartItem->quantity]);
        } else {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($customerId, $productId)
    {
        $cart = Cart::where('customer_id', $customerId)
                ->where('product_id', $productId)
                ->firstOrFail();
        $cart->delete();

        return response()->json(['message' => 'Cart item deleted successfully'], 200);
    }




}
