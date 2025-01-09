<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function processLogin(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }
    public function logout()
    {
        Auth::logout(); // Log out the user
        return redirect()->route('login')->with('status', 'You have been logged out successfully.'); // Redirect to login page
    }
}
