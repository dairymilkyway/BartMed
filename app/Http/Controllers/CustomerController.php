<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Customer::with('user')->get();
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
        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Hash the password
        $user->role = 'customer'; // Assuming default role for customers
        $user->status = 'active'; // Assuming default status for new customers
        $user->save();

        // Get the last inserted user id
        $userId = $user->id;

        // Create the customer
        $name = $request->first_name . ' ' . $request->last_name;
        $customer = new Customer();
        $customer->user_id = $userId;
        $customer->name = $name;
        $customer->address = $request->address;
        $customer->number = $request->number;

        if ($request->hasFile('img_path')) {
            $fileName = $request->file('img_path')->store('public/images');
            $customer->img_path = 'storage/' . substr($fileName, 7);
        }

        $customer->save();

            return redirect('/register')->with('success', 'Customer created successfully. Please login.');

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
        if (Customer::find($id)) {
            Customer::destroy($id);
            $data = array('success' => 'deleted', 'code' => 200);
            return response()->json($data);
        }
        $data = array('error' => 'Brand not deleted', 'code' => 400);
        return response()->json($data);
    }

    public function changeStatus(Request $request, $id)
    {
    $user = User::findOrFail($id);
    $user->status = $request->input('status');
    $user->save();

    return response()->json(['message' => 'Status updated successfully']);
    }

    public function changeRole(Request $request, $id)
    {
    $user = User::findOrFail($id);
    $user->role = $request->input('role');
    $user->save();

    return response()->json(['message' => 'Role updated successfully']);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'message' => 'Login successful'
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
