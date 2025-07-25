<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// AuthController handles authentication-related actions such as login, logout, and profile retrieval.
class AuthController extends BaseController
{
    /**
     * Show login form
     *
     * @return \Illuminate\View\View
     * Shows the login form and flashes a welcome message if not already set.
     */
    public function showLoginForm()
    {
        if (!session()->has('swal_msg')) {
            Session::flash('swal_type', 'info');
            Session::flash('swal_title', 'Welcome');
            Session::flash('swal_msg', 'Please login to access the website admin panel.');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * Validates user credentials, authenticates via AUTH API, checks user roles, and manages session data.
     */
    public function login(Request $request)
    {
        // Validate credentials from request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Call AUTH API to authenticate
        $response = $this->authApiPost('/login', $credentials);
        
        if (!isset($response['success']) || !$response['success']) {
            $errorTitle = 'Login Failed';
            $errorMsg = 'An error occurred while trying to log in. Please try again.';
            
            if (isset($response['message'])) {
                $message = $response['message'];
                
                if ($message === 'User does not exist or is not active') {
                    $errorTitle = 'Email Not Found';
                    $errorMsg = 'The email you entered is not registered in our system.';
                } 
                else if ($message === 'Invalid credentials') {
                    $errorTitle = 'Wrong Password';
                    $errorMsg = 'The password you entered is incorrect. Please try again.';
                }
                else {
                    $errorMsg = $message;
                }
            }
            
            Session::flash('swal_type', 'error');
            Session::flash('swal_title', $errorTitle);
            Session::flash('swal_msg', $errorMsg);
            
            return back()->withInput($request->only('email'));
        }

        // Check if user has permission to access the website admin panel
        // This could be based on a specific role needed for website admin access
        $hasAccess = false;
        $userRoles = $response['data']['roles'] ?? [];
        
        // Define which roles can access the website admin panel
        $allowedRoles = ['admin', 'manager', 'superadmin', 'user']; // Adjust as needed
        
        foreach ($userRoles as $role) {
            if (in_array($role, $allowedRoles)) {
                $hasAccess = true;
                break;
            }
        }
        
        if (!$hasAccess) {
            Session::flash('swal_type', 'error');
            Session::flash('swal_title', 'Access Denied');
            Session::flash('swal_msg', 'You do not have permission to access the website admin panel.');
            
            return back()->withInput($request->only('email'));
        }

        // Success path - store auth data
        Session::put('auth_token', $response['data']['token']);
        Session::put('user', $response['data']['user']);
        Session::put('roles', $response['data']['roles'] ?? []);

        // Ambil nama divisi dari data user yang dikirim API dan simpan ke session.
        if (isset($response['data']['user']['division']['div_name'])) {
            Session::put('division', $response['data']['user']['division']['div_name']);
        } else {
            Session::put('division', null); // Set null if division is not present
        }

        // Add SweetAlert message
        Session::flash('swal_type', 'success');
        Session::flash('swal_title', 'Login Successful');
        Session::flash('swal_msg', 'Welcome to the Website admin panel, ' . $response['data']['user']['u_name'] . '!');

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Handle logout request
     *
     * @return \Illuminate\Http\RedirectResponse
     * Logs out the user via AUTH API, clears session data, and flashes a logout message.
     */
    public function logout()
    {
        // Call AUTH API to logout
        $this->authApiPost('/logout');

        // Clear session data
        Session::forget(['auth_token', 'user', 'roles', 'division']);

        // Add SweetAlert message
        Session::flash('swal_type', 'success');
        Session::flash('swal_title', 'Logged Out');
        Session::flash('swal_msg', 'You have been successfully logged out.');

        return redirect()->route('login');
    }
    
    /**
     * Get authenticated user profile
     *
     * @return \Illuminate\View\View
     * Retrieves the authenticated user's profile from the AUTH API and displays it.
     */
    public function profile()
    {
        // Get user data from AUTH API
        $response = $this->authApiGet('/me');
        
        if (!isset($response['success']) || !$response['success']) {
            Session::flash('swal_type', 'error');
            Session::flash('swal_title', 'Error');
            Session::flash('swal_msg', 'Failed to retrieve user profile.');
            return redirect()->route('dashboard');
        }
        
        $user = $response['data'];
        
        return view('auth.profile', compact('user'));
    }
}