<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        try {
            // Retrieve input data without validation
            $firstName = $request->input('first_name');
            $lastName = $request->input('last_name');
            $email = $request->input('email');
            $password = $request->input('password');
            $address = $request->input('address');
            $number = $request->input('number');
            $imgPath = $request->file('img_path');

            // Merge first name and last name
            $name = $firstName . ' ' . $lastName;

            // Create user
            $user = new User();
            $user->email = $email;
            $user->password = Hash::make($password); // Hash the password
            $user->role = 'customer'; // Assuming default role for customers
            $user->status = 'active'; // Assuming default status for new customers
            $user->save();

            // Get the user ID
            $userId = $user->id;

            // Create customer record
            $customer = new Customer();
            $customer->user_id = $userId;
            $customer->name = $name;
            $customer->address = $address;
            $customer->number = $number;

            // Handle file upload
            if ($imgPath) {
                $fileName = $imgPath->store('public/images');
                $customer->img_path = 'storage/' . substr($fileName, 7);
            }

            $customer->save();

            // Generate Sanctum token
            $token = $user->createToken('API TOKEN')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Customer created successfully. Please login.',
                'token' => $token
            ], 200);

        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the user. Please try again later.'
            ], 500);
        }


    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Manually add customer data to the response
        $customer = $user->customer;

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'customer' => $customer
        ]);
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
        // $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials)) {
        //     $user = Auth::user();
        //     return response()->json([
        //         'user' => $user,
        //         'message' => 'Login successful'
        //     ]);
        // }

        // return response()->json([
        //     'message' => 'Invalid credentials'
        // ], 401);
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $redirectUrl = $user->role === 'customer' ? '/home' : '/brand';
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'redirect_url' => $redirectUrl,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }

}
