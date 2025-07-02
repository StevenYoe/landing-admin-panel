<?php
// ApiAuthentication middleware ensures that the user is authenticated before accessing protected routes.
// It checks for the presence of an auth token in the session and optionally verifies its validity with the Auth API.
// If the token is missing or invalid, the user is redirected to the login page with a warning message.

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     * Checks for auth token and verifies its validity with the Auth API.
     * Redirects to login if authentication fails.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if there's no token
        if (!Session::has('auth_token')) {
            Session::flash('swal_type', 'warning');
            Session::flash('swal_title', 'Authentication Required');
            Session::flash('swal_msg', 'Please login to access this page.');
            return redirect()->route('login');
        }

        // Optionally verify token validity with Auth API
        try {
            $authApiUrl = config('app.auth_api_base_url', env('AUTH_API_BASE_URL'));
            $token = Session::get('auth_token');
            
            $response = Http::withToken($token)
                ->acceptJson()
                ->get($authApiUrl . '/me');
            
            if ($response->status() === 401) {
                Session::forget(['auth_token', 'user', 'roles']);
                
                Session::flash('swal_type', 'warning');
                Session::flash('swal_title', 'Session Expired');
                Session::flash('swal_msg', 'Your session has expired. Please login again.');
                
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            // Log the error but continue - we'll assume the token is valid
            \Log::warning('Error verifying token: ' . $e->getMessage());
        }

        return $next($request);
    }
}