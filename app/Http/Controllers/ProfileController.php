<?php
// ProfileController handles displaying the authenticated user's profile.
// It retrieves user data from the session and, if needed, fetches the latest profile data from the Auth API.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends BaseController // Change to extend BaseController
{
    /**
     * Display the user's profile.
     * Gets user data from session and updates it from the Auth API if available.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get user data from session
        $user = Session::get('user');
        
        // If we need more details, we can fetch from API
        $response = $this->authApiGet('/me');
        
        if (isset($response['success']) && $response['success']) {
            $user = $response['data'];
        }
        
        return view('profile.index', compact('user'));
    }
}