<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Hardcoded credentials for demo
        $validUsername = 'superadmin';
        $validPassword = 'admin123';

        if ($validated['username'] === $validUsername && $validated['password'] === $validPassword) {
            // Set session
            session([
                'is_authenticated' => true,
                'username' => $validated['username'],
                'role' => 'admin',
                'user_id' => 1,
            ]);

            // Log activity
            $this->logActivity('Login successful');

            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        // Login failed
        return back()->withErrors(['error' => 'Username atau password salah!'])->withInput();
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        // Log activity before logout
        $this->logActivity('Logout');

        // Clear session
        session()->flush();

        return redirect('/login')->with('success', 'Anda telah logout');
    }

    /**
     * Log user activity
     */
    private function logActivity($action)
    {
        // For now, just log to Laravel log
        \Log::info('User Activity: ' . $action . ' - Username: ' . session('username', 'unknown'));
    }
}
