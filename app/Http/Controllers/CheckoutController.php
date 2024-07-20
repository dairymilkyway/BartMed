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
        // Get the currently authenticated user
        $user = auth()->user();

        // Get the customer associated with the user
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        // Get the selected cart items for the customer
        $items = Cart::with('product') // Eager load the product relationship
                    ->where('customer_id', $customer->id)
                    ->where('status', 'selected') // Filter by selected status
                    ->get();

        // Calculate the total cost
        $total = $items->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json(['items' => $items, 'total' => $total]);
    }



    // Get Email for the authenticated user
    public function getUserEmail()
    {
        $user = Auth::user(); // Get the authenticated user

        return response()->json(['email' => $user->email]);
    }

    // Get Name for the authenticated user
    public function getUserName()
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        $customer = Customer::where('user_id', $userId)->first(); // Get the customer record

        if (!$customer) {
            return response()->json(['name' => ''], 404);
        }

        return response()->json(['name' => $customer->name]);
    }
    public function getAddress()
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        $customer = Customer::where('user_id', $userId)->first(); // Get the customer record

        if (!$customer) {
            return response()->json(['address' => ''], 404); // Return an empty address with a 404 status if no customer is found
        }

        return response()->json(['address' => $customer->address]); // Return the customer's address
    }


}
