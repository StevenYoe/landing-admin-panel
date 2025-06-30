<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckWriteAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Session::get('user');
        $roles = Session::get('roles', []);

        // Check if superadmin
        $isSuperAdmin = false;
        foreach ($roles as $role) {
            if ((is_array($role) && isset($role['role_name']) &&
                strtolower($role['role_name']) === 'superadmin') ||
                (is_string($role) && strtolower($role) === 'superadmin')) {
                $isSuperAdmin = true;
                break;
            }
        }

        // If superadmin, allow everything
        if ($isSuperAdmin) {
            return $next($request);
        }

        // Check division
        $userDivision = isset($user['division']['div_name']) ?
            strtolower($user['division']['div_name']) : '';

        // Define which divisions can perform write operations
        $allowedWriteDivisions = ['marketing', 'social media', 'human resources'];

        // Check if user's division is allowed to perform write operations
        if (!in_array($userDivision, $allowedWriteDivisions)) {
            Session::flash('swal_type', 'error');
            Session::flash('swal_title', 'Access Denied');
            Session::flash('swal_msg', 'You do not have permission to perform this action.');
            return redirect()->back();
        }

        // Additional check for HR-specific routes
        $currentRoute = $request->route()->getName();
        $hrRoutes = [
            'careerinfos', 'workatpazars', 'departments', 'employments', 
            'experiences', 'vacancies'
        ];

        // Check if current route is HR-related
        $isHRRoute = false;
        foreach ($hrRoutes as $hrRoute) {
            if (str_contains($currentRoute, $hrRoute)) {
                $isHRRoute = true;
                break;
            }
        }

        // If it's an HR route, only allow HR division and superadmin
        if ($isHRRoute && $userDivision !== 'human resources') {
            Session::flash('swal_type', 'error');
            Session::flash('swal_title', 'Access Denied');
            Session::flash('swal_msg', 'You do not have permission to access HR features.');
            return redirect()->back();
        }

        // If it's a content route, HR division should not have access
        if (!$isHRRoute && $userDivision === 'human resources') {
            Session::flash('swal_type', 'error');
            Session::flash('swal_title', 'Access Denied');
            Session::flash('swal_msg', 'You do not have permission to access content features.');
            return redirect()->back();
        }

        return $next($request);
    }
}