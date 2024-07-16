<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Model\Customer;
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
        //
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
