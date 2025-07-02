<?php
// EmploymentController manages CRUD operations for employment types.
// It handles listing, creating, updating, showing, and deleting employment type records via the CRUD API.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EmploymentController extends BaseController
{
    /**
     * Display a listing of the employment types.
     * Handles sorting and pagination.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'e_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];
        
        // Use CRUD API to get employment data
        $response = $this->crudApiGet('/employments', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('employments.index')->with('error', $response['message'] ?? 'Failed to fetch employment types');
        }
        
        $employments = $response['data']['data'] ?? [];
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $employments,
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
        
        return view('employments.index', compact('employments', 'paginator', 'sortBy', 'sortOrder'));
    }
    
    /**
     * Show the form for creating a new employment type.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('employments.create');
    }
    
    /**
     * Store a newly created employment type in storage.
     * Validates input and sends data to the CRUD API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'e_title_id' => 'required|string|max:100',
            'e_title_en' => 'required|string|max:100',
        ]);
        
        // Use CRUD API to store employment data
        $response = $this->crudApiPost('/employments', $request->all());
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create employment type');
        }
        
        return redirect()->route('employments.index')
            ->with('success', $response['message'] ?? 'Employment type created successfully');
    }
    
    /**
     * Display the specified employment type.
     * Fetches a single employment type record.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/employments/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('employments.index')
                ->with('error', $response['message'] ?? 'Employment type not found');
        }
        
        $employment = $response['data'];
        
        return view('employments.show', compact('employment'));
    }
    
    /**
     * Show the form for editing the specified employment type.
     * Fetches the record for editing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/employments/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('employments.index')
                ->with('error', $response['message'] ?? 'Employment type not found');
        }
        
        $employment = $response['data'];
        
        return view('employments.edit', compact('employment'));
    }
    
    /**
     * Update the specified employment type in storage.
     * Validates input and updates the record via the CRUD API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'e_title_id' => 'required|string|max:100',
            'e_title_en' => 'required|string|max:100',
        ]);
        
        // Use CRUD API to update employment data
        $response = $this->crudApiPut("/employments/{$id}", $request->all());
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update employment type');
        }
        
        return redirect()->route('employments.index')
            ->with('success', $response['message'] ?? 'Employment type updated successfully');
    }
    
    /**
     * Remove the specified employment type from storage.
     * Deletes the record via the CRUD API and handles the response.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/employments/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('employments.index')
                ->with('error', $response['message'] ?? 'Failed to delete employment type');
        }
        
        return redirect()->route('employments.index')
            ->with('success', $response['message'] ?? 'Employment type deleted successfully');
    }
}