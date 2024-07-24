<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
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
        $userId = Auth::id();
        $customer = Customer::where('user_id', $userId)->first();

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

            $productRecord = Product::find($product['id']);
            if ($productRecord) {
                $productRecord->stocks -= $product['quantity'];
                $productRecord->save();
            }

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
    public function fetchOrder()
    {
        $userId = Auth::id();
        $orders = Order::where('customer_id', $userId)
                        ->with(['products' => function($query) {
                            $query->select('products.id', 'products.product_name', 'products.price', 'products.img_path', 'order_product.quantity');
                        }])
                        ->get()
                        ->map(function($order) {
                            $order->total_price = $order->products->sum(function($product) {
                                return $product->price * $product->pivot->quantity;
                            });

                            return $order;
                        });

        return response()->json($orders);
    }

    public function cancelOrder(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        $order->order_status = 'cancelled';
        $order->save();

        return response()->json(['message' => 'Order cancelled successfully.']);
    }
    public function addReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        // Get the authenticated user's customer ID
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer record not found.'], 404);
        }

        // Create and save the review
        $review = new Review();
        $review->customer_id = $customer->id;
        $review->product_id = $request->input('product_id');
        $review->rating = $request->input('rating');
        $review->review = $request->input('review');
        $review->save();

        return response()->json(['message' => 'Review added successfully!']);
    }
    public function getReviews($productId)
    {
        $reviews = Review::where('product_id', $productId)->get();

        return response()->json(['reviews' => $reviews]);
    }
    public function fetchReviews($productId)
    {
        $reviews = Review::where('product_id', $productId)->get();

        return response()->json(['reviews' => $reviews]);
    }
}
