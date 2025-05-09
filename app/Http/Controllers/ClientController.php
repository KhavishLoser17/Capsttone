<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    //
    public function landing_page() {
        return view('other.home-page');
    }

    public function login() {
        return view('other.login-page');
    }

    public function register() {
        return view('other.registration-page');
    }
    public function store(Request $request)
{
    // Validate with more lenient password requirements for testing
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'required|min:3|confirmed', // Reduced from min:6 for testing
    ]);

    // Check if email already exists
    if (User::where('email', $validatedData['email'])->exists()) {
        return redirect()->back()->withInput()
            ->withErrors(['email' => 'This email is already registered.']);
    }

    // Create User
    $user = new User();
    $user->first_name = $validatedData['first_name'];
    $user->last_name = $validatedData['last_name'];
    $user->email = $validatedData['email'];
    $user->password = Hash::make($validatedData['password']);
    // Let emp_acc_role use its default value
    $user->save();

    // Redirect with success message
    return redirect()->route('login')->with('success', 'Registration successful!');
}

public function loginPost(Request $request)
{
    if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

        session(['api_token' => 'local_auth_' . md5(time())]);
        return redirect('/two-factor');                          
    }
    $client = new Client();
    try {
        $response = $client->post('https://administrative.easetravelandtours.com/v/public/api/v3/emp/login', [
            'json' => [
                'data' => [
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                ],
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $data = json_decode($response->getBody()->getContents());
        if ($data->code == 200) {
            session(['api_token' => $data->api_token]);
            return redirect()->route('two-factor.index')->with('toast', 'Login successful.');
        } else {
            return back()->with('toast_error', 'Invalid credentials.');
        }
    } catch (\Exception $e) {
        return back()->with('toast_error', 'Authentication failed: ' . $e->getMessage());
    }

}


    public function logoutWithToken(Request $request)
    {
        $client = new Client();

        $response = $client->post('https://administrative.easetravelandtours.com/v/public/api/v3/emp/logout', [
            'headers' => [
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
            ],
        ]);

        session()->forget('api_token');
        return redirect()->route('login')->with('toast', 'Logout successful!');
    }

}
