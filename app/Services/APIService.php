<?php
// ApiService provides a wrapper for making HTTP requests to an external API with authentication.
// It supports GET, POST, PUT, DELETE requests, handles token management, and processes API responses.
// The service also manages user authentication and session storage for API tokens and user data.

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

/**
 * ApiService
 * 
 * This service class provides methods to interact with an external API using HTTP requests.
 * It handles authentication, token management, and standard HTTP methods (GET, POST, PUT, DELETE).
 * Responses are processed to handle errors and session management automatically.
 */
class ApiService
{
    /**
     * The base URL for the API.
     * @var string
     */
    protected $baseUrl;
    /**
     * The authorization token for API requests.
     * @var string|null
     */
    protected $token;

    /**
     * ApiService constructor.
     * Initializes the base URL and retrieves the token from session.
     */
    public function __construct()
    {
        $this->baseUrl = config('services.api.url');
        $this->token = session('api_token');
    }

    /**
     * Set the authorization token for subsequent requests.
     *
     * @param string $token
     * @return $this
     */
    public function withToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Make an HTTP GET request to the API.
     *
     * @param string $endpoint The API endpoint to call.
     * @param array $params Optional query parameters.
     * @return mixed The decoded JSON response or error structure.
     */
    public function get(string $endpoint, array $params = [])
    {
        $response = Http::withToken($this->token)
            ->get($this->baseUrl . $endpoint, $params);

        return $this->handleResponse($response);
    }

    /**
     * Make an HTTP POST request to the API.
     *
     * @param string $endpoint The API endpoint to call.
     * @param array $data The data to send in the request body.
     * @return mixed The decoded JSON response or error structure.
     */
    public function post(string $endpoint, array $data = [])
    {
        $response = Http::withToken($this->token)
            ->post($this->baseUrl . $endpoint, $data);

        return $this->handleResponse($response);
    }

    /**
     * Make an HTTP PUT request to the API.
     *
     * @param string $endpoint The API endpoint to call.
     * @param array $data The data to send in the request body.
     * @return mixed The decoded JSON response or error structure.
     */
    public function put(string $endpoint, array $data = [])
    {
        $response = Http::withToken($this->token)
            ->put($this->baseUrl . $endpoint, $data);

        return $this->handleResponse($response);
    }

    /**
     * Make an HTTP DELETE request to the API.
     *
     * @param string $endpoint The API endpoint to call.
     * @return mixed The decoded JSON response or error structure.
     */
    public function delete(string $endpoint)
    {
        $response = Http::withToken($this->token)
            ->delete($this->baseUrl . $endpoint);

        return $this->handleResponse($response);
    }

    /**
     * Handle the HTTP response from the API.
     * Processes authentication, validation, and server errors.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @return mixed The decoded JSON response or error structure.
     */
    protected function handleResponse($response)
    {
        $json = $response->json();

        // Handle authentication errors (e.g., expired token)
        if ($response->status() === 401) {
            Session::forget('api_token');
            return redirect()->route('login')->with('error', 'Your session has expired. Please login again.');
        }

        // Handle validation errors (e.g., invalid input)
        if ($response->status() === 422) {
            return $json;
        }

        // Handle server errors (e.g., 500, 404)
        if ($response->failed()) {
            return [
                'success' => false,
                'message' => $json['message'] ?? 'An error occurred with the API',
                'errors' => $json['errors'] ?? []
            ];
        }

        // Return successful response
        return $json;
    }

    /**
     * Authenticate user with the API and store the token in session.
     *
     * @param string $email User's email address.
     * @param string $password User's password.
     * @return array The decoded JSON response from the API.
     */
    public function login(string $email, string $password)
    {
        $response = Http::post($this->baseUrl . '/login', [
            'email' => $email,
            'password' => $password
        ]);

        $json = $response->json();

        // If login is successful, store token and user info in session
        if ($response->successful() && isset($json['data']['token'])) {
            Session::put('api_token', $json['data']['token']);
            Session::put('user', $json['data']['user']);
            Session::put('roles', $json['data']['roles']);
            
            $this->token = $json['data']['token'];
        }

        return $json;
    }

    /**
     * Logout user from the API and remove token and user info from session.
     *
     * @return array The decoded JSON response from the API.
     */
    public function logout()
    {
        $response = Http::withToken($this->token)
            ->post($this->baseUrl . '/logout');

        // Remove token and user info from session
        Session::forget('api_token');
        Session::forget('user');
        Session::forget('roles');

        return $response->json();
    }
}
