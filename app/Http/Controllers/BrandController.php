<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;

//import Excel

use App\Imports\BrandsImport;
use Maatwebsite\Excel\Facades\Excel;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Brand::orderBy('id', 'DESC')->get();
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
        $brand = new Brand;
        $brand->brand_name = $request->brand_name;
        $brand->img_path = ''; // Provide a default value

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $brand->img_path .= 'storage/images/' . $fileName . ','; // Append image path
            }
            $brand->img_path = rtrim($brand->img_path, ','); // Remove trailing comma
        }

        $brand->save();

        return response()->json(["success" => "Brand created successfully.", "brand" => $brand, "status" => 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::where('id', $id)->first();
        return response()->json($brand);
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
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(["error" => "Brand not found.", "status" => 404]);
        }

        $brand->brand_name = $request->brand_name;
        $brand->img_path = ''; // Provide a default value


        // Handle multiple image uploads
        if ($request->hasFile('uploads')) {
            $imagePaths = [];

            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $imagePaths[] = 'storage/images/' . $fileName;
            }

            $brand->img_path = implode(',', $imagePaths);
        }
        else
        {
            $brand->img_path = $brand->img_path;
        }

        $brand->save();

        return response()->json(["success" => "Brand updated successfully.", "brand" => $brand, "status" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Brand::find($id)) {
            Brand::destroy($id);
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

        Excel::import(new BrandsImport, $request->file('importFile'));

        return response()->json(['success' => 'Brands imported successfully'], 200);
    }
}
