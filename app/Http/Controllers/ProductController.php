<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;

//import Excel
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with('brand')->get();
        $brand = Brand::all();
        return response()->json($data);
    }
    
    public function fetchProducts(Request $request)
    {
        $products = Product::paginate(10);
        return response()->json($products);
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
            $Product = new Product;
            $Product->product_name = $request->product_name;
            $Product->description = $request->description;
            $Product->price = $request->price;
            $Product->stocks = $request->stocks;
            $Product->category = $request->category;
            $Product->brand_id = $request->brand_id;
            $Product->img_path = '';


            if ($request->hasFile('uploads')) {
                foreach ($request->file('uploads') as $file) {
                    $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/images', $fileName);
                    $Product->img_path .= 'storage/images/' . $fileName . ','; // Append image path
                }
                $Product->img_path = rtrim($Product->img_path, ','); // Remove trailing comma
            }

            $Product->save();

            return response()->json(["success" => "Brand created successfully.", "brand" => $Product, "status" => 200]);
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Product = Product::where('id', $id)->first();
        return response()->json($Product);
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
        $Product = Product::find($id);

    if (!$Product) {
        return response()->json(["error" => "Product not found.", "status" => 404], 404);
    }

    $Product->product_name = $request->product_name;
    $Product->description = $request->description;
    $Product->price = $request->price;
    $Product->stocks = $request->stocks;
    $Product->category = $request->category;
    $Product->brand_id = $request->brand_id;

    if ($request->hasFile('uploads')) {
        $imagePaths = [];

        foreach ($request->file('uploads') as $file) {
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            $imagePaths[] = 'storage/images/' . $fileName;
        }

        $Product->img_path = implode(',', $imagePaths);
    }

    $Product->save();

    return response()->json(["success" => "Product updated successfully.", "status" => 200]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Product::find($id)) {
            Product::destroy($id);
            $data = array('success' => 'deleted', 'code' => 200);
            return response()->json($data);
        }
        $data = array('error' => 'Brand not deleted', 'code' => 400);
        return response()->json($data);
    }

    public function import(Request $request)
    {
        $request ->validate([
            'importFile' => ['required', 'file', 'mimes:xlsx,xls']
        ]);

        Excel::import(new ProductsImport, $request->file('importFile'));

        return response()->json(['success' => 'Brands imported successfully'], 200);
    }

}
