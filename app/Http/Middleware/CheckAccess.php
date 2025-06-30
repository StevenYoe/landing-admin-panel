<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckAccess
{
    public function handle(Request $request, Closure $next, ...$divisions): Response
    {
        $userRoles = array_map('strtolower', (array)Session::get('roles', []));
        
        // Use trim() to remove accidental whitespace from session data
        $userDivision = strtolower(trim(Session::get('division', '')));

        // 1. Superadmin always has access.
        if (in_array('superadmin', $userRoles)) {
            return $next($request);
        }

        // 2. Check against allowed divisions for the route.
        $allowedDivisions = array_map('strtolower', $divisions);
        if (in_array($userDivision, $allowedDivisions)) {
            return $next($request);
        }

        // 3. Deny access if none of the conditions are met.
        Session::flash('swal_type', 'error');
        Session::flash('swal_title', 'Access Denied');
        Session::flash('swal_msg', 'You do not have permission to access this page.');

        return redirect()->route('dashboard');
    }
}