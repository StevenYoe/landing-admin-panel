<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // This code assumes you have already stored the user's roles in the Session
        // with the key 'roles' when they log in.
        // Example: Session::put('roles', ['superadmin']);
        $userRoles = Session::get('roles', []);

        // Ensure the format is an array and convert to lowercase for consistency
        $userRoles = array_map('strtolower', (array)$userRoles);

        // Check if the user's role is in the list of allowed roles
        foreach ($roles as $role) {
            if (in_array(strtolower($role), $userRoles)) {
                // If allowed, proceed to the requested page
                return $next($request);
            }
        }

        // If they do not have access, prepare an alert message
        Session::flash('swal_type', 'error');
        Session::flash('swal_title', 'Access Denied');
        Session::flash('swal_msg', 'You do not have permission to access this page.');

        // Redirect the user back to the previous page.
        return redirect()->back();
    }
}