<?php
// HeaderController manages CRUD operations for header items.
// It handles listing, creating, updating, showing, and deleting header records via the CRUD API.
// Also manages file uploads for header images and image path transformation.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class HeaderController extends BaseController
{
    /**
     * Display a listing of the headers.
     * Handles sorting, pagination, and image path transformation.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'h_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get headers data
        $response = $this->crudApiGet('/headers', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('headers.index')->with('error', $response['message'] ?? 'Failed to fetch headers');
        }
        
        $headers = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($headers as &$header) {
            if (!empty($header['h_image'])) {
                $header['h_image'] = config('app.crud_storage_url') . '/' . $header['h_image'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $headers,
                    $paginationData['total'],
                    $paginationData['per_page'],
                    $paginationData['current_page'],
                    [
                        'path' => request()->url(),
                        'query' => $request->query()
                    ]
                );
            }
        }

        $sortBy = $params['sort_by'];
        $sortOrder = $params['sort_order'];
        
        return view('headers.index', compact('headers', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new header.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('headers.create');
    }

    /**
     * Store a newly created header in storage.
     * Validates input, handles file upload, and sends data to the CRUD API.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'h_title_id' => 'required|string|max:255',
            'h_title_en' => 'required|string|max:255',
            'h_page_name' => 'required|string|max:50',
            'h_description_id' => 'nullable|string',
            'h_description_en' => 'nullable|string',
            'h_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('h_image')) {
            $data['h_image'] = $request->file('h_image');
        }
        
        // Use CRUD API to store header data
        $response = $this->crudApiPost('/headers', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create header');
        }
        
        return redirect()->route('headers.index')
            ->with('success', $response['message'] ?? 'Header created successfully');
    }

    /**
     * Display the specified header.
     * Fetches a single header record and transforms its image path.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/headers/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('headers.index')
                ->with('error', $response['message'] ?? 'Header not found');
        }
        
        $header = $response['data'];
        
        // Transform image path
        if (!empty($header['h_image'])) {
            $header['h_image'] = config('app.crud_storage_url') . '/' . $header['h_image'];
        }
        
        return view('headers.show', compact('header'));
    }

    /**
     * Show the form for editing the specified header.
     * Fetches the record and transforms its image path for editing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/headers/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('headers.index')
                ->with('error', $response['message'] ?? 'Header not found');
        }
        
        $header = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($header['h_image'])) {
            $header['h_image'] = config('app.crud_storage_url') . '/' . $header['h_image'];
        }
        
        return view('headers.edit', compact('header'));
    }

    /**
     * Update the specified header in storage.
     * Validates input, handles file upload, and updates the record via the CRUD API.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'h_title_id' => 'required|string|max:255',
            'h_title_en' => 'required|string|max:255',
            'h_page_name' => 'required|string|max:50',
            'h_description_id' => 'nullable|string',
            'h_description_en' => 'nullable|string',
            'h_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('h_image')) {
            $data['h_image'] = $request->file('h_image');
        }
        
        // Use CRUD API to update header data
        $response = $this->crudApiPut("/headers/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update header');
        }
        
        return redirect()->route('headers.index')
            ->with('success', $response['message'] ?? 'Header updated successfully');
    }

    /**
     * Remove the specified header from storage.
     * Deletes the record via the CRUD API and handles the response.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/headers/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('headers.index')
                ->with('error', $response['message'] ?? 'Failed to delete header');
        }
        
        return redirect()->route('headers.index')
            ->with('success', $response['message'] ?? 'Header deleted successfully');
    }
}