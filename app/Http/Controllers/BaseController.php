<?php
// BaseController provides shared logic for authentication, API requests, and user session management.
// It is intended to be extended by other controllers in the application.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    /**
     * Authentication API base URL
     * Used for all authentication-related API requests.
     */
    protected $authApiUrl;

    /**
     * CRUD API base URL
     * Used for all CRUD-related API requests.
     */
    protected $crudApiUrl;

    /**
     * Constructor
     * Initializes API base URLs from config or environment variables.
     */
    public function __construct()
    {
        $this->authApiUrl = config('app.auth_api_base_url', env('AUTH_API_BASE_URL'));
        $this->crudApiUrl = config('app.crud_api_base_url', env('CRUD_API_BASE_URL'));
    }

    /**
     * Check if the current user belongs to a specific division
     * Returns true if the user's division matches the given name.
     *
     * @param string $divisionName
     * @return bool
     */
    public function hasDivision($divisionName)
    {
        $user = Session::get('user');
        if (!$user || !isset($user['division'])) {
            return false;
        }

        return isset($user['division']['div_name']) &&
            strtolower($user['division']['div_name']) === strtolower($divisionName);
    }

    /**
     * Check if the current user is a superadmin
     * Returns true if the user has the 'superadmin' role.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        $roles = Session::get('roles', []);

        // Check if 'superadmin' is in the roles array
        if (in_array('superadmin', $roles)) {
            return true;
        }

        // For array of objects with 'role_name' property
        foreach ($roles as $role) {
            if (is_array($role) && isset($role['role_name']) &&
                strtolower($role['role_name']) === 'superadmin') {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the current user has a specific role
     * Returns true if the user has the specified role.
     *
     * @param string $roleName
     * @return bool
     */
    protected function hasRole($roleName)
    {
        $roles = Session::get('roles', []);

        // Check if role exists in the array
        if (in_array(strtolower($roleName), array_map('strtolower', $roles))) {
            return true;
        }

        // For array of objects with 'role_name' property
        foreach ($roles as $role) {
            if (is_array($role) && isset($role['role_name']) &&
                strtolower($role['role_name']) === strtolower($roleName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Make a request to the Authentication API
     * Handles all HTTP methods for the Auth API.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    protected function authApiRequest($method, $endpoint, $data = [])
    {
        return $this->makeApiRequest($method, $this->authApiUrl . $endpoint, $data);
    }

    /**
     * Make a request to the CRUD API
     * Adds user and employee IDs to requests for tracking.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    protected function crudApiRequest($method, $endpoint, $data = [])
    {
        // Add user ID to all CRUD requests to ensure created_by and updated_by are set
        $userData = Session::get('user');
        if ($userData && isset($userData['u_id'])) {
            // For GET requests, add to query params
            if (strtolower($method) === 'get') {
                $data['user_id'] = $userData['u_id'];
            } 
            // For other methods, add to request body
            else {
                $data['user_id'] = $userData['u_id'];
            }
            
            // Add employee ID if available
            if (isset($userData['u_employee_id'])) {
                if (strtolower($method) === 'get') {
                    $data['employee_id'] = $userData['u_employee_id'];
                } else {
                    $data['employee_id'] = $userData['u_employee_id'];
                }
            }
        }

        // Ensure page parameter is passed correctly
        if ($method === 'get' && request()->has('page')) {
            $data['page'] = request()->input('page');
        }

        return $this->makeApiRequest($method, $this->crudApiUrl . $endpoint, $data);
    }

    /**
     * Make an HTTP request to an API
     * Handles authentication, file uploads, and error responses.
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @return mixed
     */
    private function makeApiRequest($method, $url, $data = [])
    {
        try {
            // Token for authentication
            $token = Session::get('auth_token') ?? '';
            
            // Check if there are uploaded files
            $hasFiles = false;
            foreach ($data as $value) {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $hasFiles = true;
                    break;
                }
            }
            
            // Handle file uploads differently
            if ($hasFiles) {
                // Create a GuzzleHttp client for more control
                $client = new \GuzzleHttp\Client();
                
                // Prepare the request
                $requestOptions = [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json'
                    ],
                    'multipart' => [],
                ];
                
                // Add form fields to multipart
                foreach ($data as $key => $value) {
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $requestOptions['multipart'][] = [
                            'name' => $key,
                            'contents' => fopen($value->getRealPath(), 'r'),
                            'filename' => $value->getClientOriginalName()
                        ];
                    } else if (is_array($value)) {
                        foreach ($value as $item) {
                            $requestOptions['multipart'][] = [
                                'name' => $key . '[]',
                                'contents' => $item
                            ];
                        }
                    } else {
                        $requestOptions['multipart'][] = [
                            'name' => $key,
                            'contents' => $value
                        ];
                    }
                }
                
                // For PUT requests, convert to POST with _method=PUT
                $actualMethod = strtolower($method);
                if ($actualMethod === 'put') {
                    $actualMethod = 'post';
                    $requestOptions['multipart'][] = [
                        'name' => '_method',
                        'contents' => 'PUT'
                    ];
                }
                
                // Send the request
                $guzzleResponse = $client->request(
                    strtoupper($actualMethod), 
                    $url, 
                    $requestOptions
                );
                
                // Convert to Laravel response
                $response = new \Illuminate\Http\Client\Response(
                    new \GuzzleHttp\Psr7\Response(
                        $guzzleResponse->getStatusCode(),
                        $guzzleResponse->getHeaders(),
                        (string) $guzzleResponse->getBody()
                    )
                );
            } else {
                // Regular request without files
                $response = Http::withToken($token)
                    ->acceptJson()
                    ->{$method}($url, $data);
            }
            
            // Check for 401 errors (except for login endpoint)
            if ($response->status() === 401 && !str_contains($url, '/login')) {
                Session::forget(['auth_token', 'user', 'roles']);
                redirect()->route('login')->send();
                return;
            }
            
            // Parse JSON response
            $responseData = $response->json();
            
            if ($responseData === null) {
                return [
                    'success' => false,
                    'message' => 'Invalid response format from server'
                ];
            }
            
            return $responseData;
        } catch (\Exception $e) {
            // Return error response
            return [
                'success' => false,
                'message' => 'Cannot connect to server: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Shorthand methods for Auth API
     * Simplifies GET, POST, PUT, DELETE requests to the Auth API.
     */
    protected function authApiGet($endpoint, $params = [])
    {
        return $this->authApiRequest('get', $endpoint, $params);
    }

    protected function authApiPost($endpoint, $data = [])
    {
        return $this->authApiRequest('post', $endpoint, $data);
    }

    protected function authApiPut($endpoint, $data = [])
    {
        return $this->authApiRequest('put', $endpoint, $data);
    }

    protected function authApiDelete($endpoint)
    {
        return $this->authApiRequest('delete', $endpoint);
    }

    /**
     * Shorthand methods for CRUD API
     * Simplifies GET, POST, PUT, DELETE requests to the CRUD API.
     */
    protected function crudApiGet($endpoint, $params = [])
    {
        return $this->crudApiRequest('get', $endpoint, $params);
    }

    protected function crudApiPost($endpoint, $data = [])
    {
        return $this->crudApiRequest('post', $endpoint, $data);
    }

    protected function crudApiPut($endpoint, $data = [])
    {
        return $this->crudApiRequest('put', $endpoint, $data);
    }

    protected function crudApiDelete($endpoint)
    {
        return $this->crudApiRequest('delete', $endpoint);
    }

    /**
     * Get the current authenticated user ID
     * Returns the user ID from the session, or null if not set.
     * 
     * @return int|null
     */
    protected function getCurrentUserId()
    {
        $userData = Session::get('user');
        return $userData['u_id'] ?? null;
    }
    
    /**
     * Get the current authenticated employee ID
     * Returns the employee ID from the session, or null if not set.
     * 
     * @return string|null
     */
    protected function getCurrentEmployeeId()
    {
        $userData = Session::get('user');
        return $userData['u_employee_id'] ?? null;
    }
}