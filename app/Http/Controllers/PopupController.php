<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class PopupController extends BaseController
{
    /**
     * Display a listing of the popups.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'pu_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get popups data
        $response = $this->crudApiGet('/popups', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('popups.index')->with('error', $response['message'] ?? 'Failed to fetch popups');
        }
        
        $popups = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($popups as &$popup) {
            if (!empty($popup['pu_image'])) {
                $popup['pu_image'] = config('app.crud_storage_url') . '/' . $popup['pu_image'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $popups,
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
        
        return view('popups.index', compact('popups', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new popup.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('popups.create');
    }

    /**
     * Store a newly created popup in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pu_link' => 'nullable|string|max:255',
            'pu_is_active' => 'nullable|boolean',
            'pu_image' => 'required|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Properly handle the boolean value - default to false for new popups
        $data['pu_is_active'] = $request->input('pu_is_active') == '1' ? true : false;
        
        // Handle file upload
        if ($request->hasFile('pu_image')) {
            $data['pu_image'] = $request->file('pu_image');
        }
        
        // Use CRUD API to store popup data
        $response = $this->crudApiPost('/popups', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create popup');
        }
        
        return redirect()->route('popups.index')
            ->with('success', $response['message'] ?? 'Popup created successfully');
    }

    /**
     * Display the specified popup.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/popups/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('popups.index')
                ->with('error', $response['message'] ?? 'Popup not found');
        }
        
        $popup = $response['data'];
        
        // Transform image path
        if (!empty($popup['pu_image'])) {
            $popup['pu_image'] = config('app.crud_storage_url') . '/' . $popup['pu_image'];
        }
        
        return view('popups.show', compact('popup'));
    }

    /**
     * Show the form for editing the specified popup.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/popups/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('popups.index')
                ->with('error', $response['message'] ?? 'Popup not found');
        }
        
        $popup = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($popup['pu_image'])) {
            $popup['pu_image'] = config('app.crud_storage_url') . '/' . $popup['pu_image'];
        }
        
        return view('popups.edit', compact('popup'));
    }

    /**
     * Update the specified popup in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pu_link' => 'nullable|string|max:255',
            'pu_is_active' => 'nullable|boolean',
            'pu_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Properly handle the boolean value
        $data['pu_is_active'] = $request->input('pu_is_active') == '1' ? true : false;
        
        // Check if the popup is being set to active
        $deactivatedOthers = false;
        if ($data['pu_is_active']) {
            // Use CRUD API to deactivate all other popups
            $this->crudApiPost('/popups/deactivate-others', ['exclude_id' => $id]);
            $deactivatedOthers = true;
        }
        
        // Handle file upload if needed
        if ($request->hasFile('pu_image')) {
            $data['pu_image'] = $request->file('pu_image');
        }
        
        // Use CRUD API to update popup data
        $response = $this->crudApiPut("/popups/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update popup');
        }
        
        // Create a redirect response with the success message
        $redirect = redirect()->route('popups.index')
            ->with('success', $response['message'] ?? 'Popup updated successfully');
        
        // Add the info message if other popups were deactivated
        if ($deactivatedOthers) {
            $redirect->with('info', 'Other popups have been deactivated since only one popup can be active at a time.');
        }
        
        return $redirect;
    }

    /**
     * Remove the specified popup from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/popups/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('popups.index')
                ->with('error', $response['message'] ?? 'Failed to delete popup');
        }
        
        return redirect()->route('popups.index')
            ->with('success', $response['message'] ?? 'Popup deleted successfully');
    }
}