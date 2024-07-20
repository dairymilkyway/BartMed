<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
    public function update(Request $request)
    {

        $user = Auth::user();
        $name = $request->input('first_name') . ' ' . $request->input('last_name');

        // Prepare data for user update
        $userData = [
            'email' => $request->input('email'),
        ];

        // Check if password is provided and hash it
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->input('password'));
        }

        // Update user data
        $user->update($userData);

        // Update customer data
        $user->customer->update([
            'name' => $name,
            'address' => $request->input('address'),
            'number' => $request->input('number'),
        ]);

        return response()->json($user);
    }
    public function updatePicture(Request $request)
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->storeAs('public/profile_pictures', $imageName);
            $customer->img_path = 'storage/profile_pictures/'.$imageName;
            $customer->save();

            return response()->json(['img_url' => asset($customer->img_path)], 200);
        }

        return response()->json(['message' => 'Image upload failed.'], 400);
    }
    public function deactivateAccount()
    {
        $user = Auth::user();
        $user->status = 'inactive';
        $user->save();

        Auth::logout();

        return response()->json(['message' => 'Account deactivated successfully.'], 200);
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
    try {
        $validateUser = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password do not match our records.',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Account is deactivated. Please contact support.',
            ], 401);
        }
        $request->session()->regenerate();
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
        Log::info('Logout method called');
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully'], 200);
        } else {
            return response()->json(['message' => 'No access token found'], 400);
        }
    }
    public function fetchUserData()
    {
        $user = Auth::user();
        Log::debug('Authenticated User:', ['user' => $user]);
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $customer = Customer::where('user_id', $user->id)->first();

        return response()->json([
            'user' => $user,
            'customer' => $customer
        ]);
    }

    public function customerChart()
    {
        // Fetch customer registrations grouped by month
    $registrations = Customer::selectRaw('MONTH(created_at) as month')
    ->selectRaw('COUNT(*) as total_customers')
    ->groupBy('month')
    ->orderBy('month')
    ->get();

        // Prepare the months array and initialize the totals array with zeros
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $monthlyRegistrations = array_fill(0, 12, 0);

    // Fill the totals array with the registration data
    foreach ($registrations as $registration) {
    $monthIndex = $registration->month - 1; // Convert month number to array index (0-11)
    $monthlyRegistrations[$monthIndex] = $registration->total_customers;
    }

    // Return data as JSON
    return response()->json([
    'months' => $months,
    'totals' => $monthlyRegistrations
    ]);
    }

}
