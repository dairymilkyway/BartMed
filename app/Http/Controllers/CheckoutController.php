<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getCartItems()
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $items = Cart::with('product')
                    ->where('customer_id', $customer->id)
                    ->where('status', 'selected')
                    ->get();
        $total = $items->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json(['items' => $items, 'total' => $total]);
    }




    public function getUserEmail()
    {
        $user = Auth::user();

        return response()->json(['email' => $user->email]);
    }

    // Get Name for the authenticated user
    public function getUserName()
    {
        $userId = Auth::id();
        $customer = Customer::where('user_id', $userId)->first();
        if (!$customer) {
            return response()->json(['name' => ''], 404);
        }

        return response()->json(['name' => $customer->name]);
    }
    public function getAddress()
    {
        $userId = Auth::id();
        $customer = Customer::where('user_id', $userId)->first();
        if (!$customer) {
            return response()->json(['address' => ''], 404);
        }

        return response()->json(['address' => $customer->address]); 
    }


}
