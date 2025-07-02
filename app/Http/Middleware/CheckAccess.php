<?php
// CheckAccess middleware restricts access to certain routes based on user division or role.
// Superadmins always have access. Other users must belong to one of the allowed divisions specified for the route.
// If access is denied, a SweetAlert error message is flashed and the user is redirected to the dashboard.

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckAccess
{
    /**
     * Handle an incoming request.
     * Checks if the user is a superadmin or belongs to an allowed division.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  mixed ...$divisions  Allowed divisions for the route
     * @return Response
     */
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