<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;


use App\Imports\SupplierImport;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Supplier::orderBy('id', 'DESC')->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Supplier = new Supplier;
        $Supplier->supplier_name = $request->supplier_name;
        $Supplier->img_path = ''; // Provide a default value

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $Supplier->img_path .= 'storage/images/' . $fileName . ','; // Append image path
            }
            $Supplier->img_path = rtrim($Supplier->img_path, ','); // Remove trailing comma
        }

        $Supplier->save();

        return response()->json(["success" => "Supplier created successfully.", "Supplier" => $Supplier, "status" => 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Supplier = Supplier::where('id', $id)->first();
        return response()->json($Supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Supplier = Supplier::find($id);

        if (!$Supplier) {
            return response()->json(["error" => "Supplier not found.", "status" => 404]);
        }

        $Supplier->supplier_name = $request->supplier_name;
        $Supplier->img_path = ''; // Provide a default value


        // Handle multiple image uploads
        if ($request->hasFile('uploads')) {
            $imagePaths = [];

            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $imagePaths[] = 'storage/images/' . $fileName;
            }

            $Supplier->img_path = implode(',', $imagePaths);
        }
        else
        {
            $Supplier->img_path = $Supplier->img_path;
        }

        $Supplier->save();

        return response()->json(["success" => "Supplier updated successfully.", "Supplier" => $Supplier, "status" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Supplier::find($id)) {
            Supplier::destroy($id);
            $data = array('success' => 'deleted', 'code' => 200);
            return response()->json($data);
        }
        $data = array('error' => 'Supplier not deleted', 'code' => 400);
        return response()->json($data);
    }

    public function import(Request $request)
    {
        $request ->validate([
            'importFile' => ['required', 'file', 'mimes:xlsx,xls']
        ]);

        Excel::import(new SupplierImport, $request->file('importFile'));

        return response()->json(['success' => 'Supplier imported successfully'], 200);
    }

}
