<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Order::with('customer')->get();
        return response()->json($data);
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
        $userId = Auth::id(); // Get the authenticated user's ID
        $customer = Customer::where('user_id', $userId)->first(); // Get the customer record

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $order = new Order();
        $order->customer_id = $customer->id;
        $order->order_status = 'Pending';
        $order->courier = $request->courier;
        $order->payment_method = $request->payment_method;
        $order->save();

        foreach ($request->products as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product['id'];
            $orderProduct->quantity = $product['quantity'];
            $orderProduct->save();

            // Delete the item from the cart
            Cart::where('customer_id', $customer->id)
                ->where('product_id', $product['id'])
                ->delete();
        }

        return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('products')->findOrFail($id);
        return response()->json($order);
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
        if (Order::find($id)) {
            Order::destroy($id);
            return response()->json(['success' => 'Order deleted'], 200);
        }
        return response()->json(['error' => 'Order not deleted'], 400);
    }

    public function changeStatus(Request $request, $id)
    {
    $order = Order::findOrFail($id);
    $order->order_status = $request->input('status');
    $order->save();

    return response()->json(['message' => 'Status updated successfully']);
    }
}
