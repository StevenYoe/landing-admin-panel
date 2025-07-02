<?php
// CertificationController manages CRUD operations for certifications.
// It handles listing, creating, updating, showing, and deleting certification records via the CRUD API.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class CertificationController extends BaseController
{
    /**
     * Display a listing of the certifications.
     * Handles sorting, pagination, and image path transformation.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'c_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get certifications data
        $response = $this->crudApiGet('/certifications', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('certifications.index')->with('error', $response['message'] ?? 'Failed to fetch certifications');
        }
        
        $certifications = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($certifications as &$certification) {
            if (!empty($certification['c_image'])) {
                $certification['c_image'] = config('app.crud_storage_url') . '/' . $certification['c_image'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $certifications,
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
        
        return view('certifications.index', compact('certifications', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new certification.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('certifications.create');
    }

    /**
     * Store a newly created certification in storage.
     * Validates input, handles file upload, and sends data to the CRUD API.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'c_label_id' => 'required|string|max:255',
            'c_label_en' => 'required|string|max:255',
            'c_title_id' => 'required|string|max:255',
            'c_title_en' => 'required|string|max:255',
            'c_description_id' => 'nullable|string',
            'c_description_en' => 'nullable|string',
            'c_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('c_image')) {
            $data['c_image'] = $request->file('c_image');
        }
        
        // Use CRUD API to store certification data
        $response = $this->crudApiPost('/certifications', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create certification');
        }
        
        return redirect()->route('certifications.index')
            ->with('success', $response['message'] ?? 'Certification created successfully');
    }

    /**
     * Display the specified certification.
     * Fetches a single certification record and transforms its image path.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/certifications/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('certifications.index')
                ->with('error', $response['message'] ?? 'Certification not found');
        }
        
        $certification = $response['data'];
        
        // Transform image path
        if (!empty($certification['c_image'])) {
            $certification['c_image'] = config('app.crud_storage_url') . '/' . $certification['c_image'];
        }
        
        return view('certifications.show', compact('certification'));
    }

    /**
     * Show the form for editing the specified certification.
     * Fetches the record and transforms its image path for editing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/certifications/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('certifications.index')
                ->with('error', $response['message'] ?? 'Certification not found');
        }
        
        $certification = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($certification['c_image'])) {
            $certification['c_image'] = config('app.crud_storage_url') . '/' . $certification['c_image'];
        }
        
        return view('certifications.edit', compact('certification'));
    }

    /**
     * Update the specified certification in storage.
     * Validates input, handles file upload, and updates the record via the CRUD API.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'c_label_id' => 'required|string|max:255',
            'c_label_en' => 'required|string|max:255',
            'c_title_id' => 'required|string|max:255',
            'c_title_en' => 'required|string|max:255',
            'c_description_id' => 'nullable|string',
            'c_description_en' => 'nullable|string',
            'c_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('c_image')) {
            $data['c_image'] = $request->file('c_image');
        }
        
        // Use CRUD API to update certification data
        $response = $this->crudApiPut("/certifications/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update certification');
        }
        
        return redirect()->route('certifications.index')
            ->with('success', $response['message'] ?? 'Certification updated successfully');
    }

    /**
     * Remove the specified certification from storage.
     * Deletes the record via the CRUD API and handles the response.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/certifications/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('certifications.index')
                ->with('error', $response['message'] ?? 'Failed to delete certification');
        }
        
        return redirect()->route('certifications.index')
            ->with('success', $response['message'] ?? 'Certification deleted successfully');
    }
}