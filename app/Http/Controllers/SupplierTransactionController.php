<?php

namespace App\Http\Controllers;

use App\Models\SupplierTransaction;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierTransactionController extends Controller
{
    public function index()
    {
        $transactions = SupplierTransaction::with('supplier', 'product')->get();
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('img_path')->store('supplier_transaction_images', 'public');

        $supplierTransaction = new SupplierTransaction;
        $supplierTransaction->supplier_id = $request->supplier_id;
        $supplierTransaction->product_id = $request->product_id;
        $supplierTransaction->quantity = $request->quantity;
        $supplierTransaction->img_path = $imagePath;
        $supplierTransaction->save();

        // Update product stocks
        $product = Product::find($request->product_id);
        $product->stocks += $request->quantity;
        $product->save();

        return response()->json([
            "success" => "Supplier transaction created successfully.",
            "SupplierTransaction" => $supplierTransaction,
            "status" => 200
        ]);
    }

    public function destroy(string $id)
    {
        if (SupplierTransaction::find($id)) {
            SupplierTransaction::destroy($id);
            $data = array('success' => 'deleted', 'code' => 200);
            return response()->json($data);
        }
        $data = array('error' => 'SupplierTransaction not deleted', 'code' => 400);
        return response()->json($data);
    }
}
