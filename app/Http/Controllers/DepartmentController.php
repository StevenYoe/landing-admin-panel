<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentController extends BaseController
{
    /**
     * Display a listing of the departments.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'da_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];
        
        // Use CRUD API to get departments data
        $response = $this->crudApiGet('/departments', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('departments.index')->with('error', $response['message'] ?? 'Failed to fetch departments');
        }
        
        $departments = $response['data']['data'] ?? [];
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $departments,
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
        
        return view('departments.index', compact('departments', 'paginator', 'sortBy', 'sortOrder'));
    }
    
    /**
     * Show the form for creating a new department.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('departments.create');
    }
    
    /**
     * Store a newly created department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'da_title_id' => 'required|string|max:100',
            'da_title_en' => 'required|string|max:100',
        ]);
        
        // Use CRUD API to store department data
        $response = $this->crudApiPost('/departments', $request->all());
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create department');
        }
        
        return redirect()->route('departments.index')
            ->with('success', $response['message'] ?? 'Department created successfully');
    }
    
    /**
     * Display the specified department.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/departments/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('departments.index')
                ->with('error', $response['message'] ?? 'Department not found');
        }
        
        $department = $response['data'];
        
        return view('departments.show', compact('department'));
    }
    
    /**
     * Show the form for editing the specified department.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/departments/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('departments.index')
                ->with('error', $response['message'] ?? 'Department not found');
        }
        
        $department = $response['data'];
        
        return view('departments.edit', compact('department'));
    }
    
    /**
     * Update the specified department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'da_title_id' => 'required|string|max:100',
            'da_title_en' => 'required|string|max:100',
        ]);
        
        // Use CRUD API to update department data
        $response = $this->crudApiPut("/departments/{$id}", $request->all());
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update department');
        }
        
        return redirect()->route('departments.index')
            ->with('success', $response['message'] ?? 'Department updated successfully');
    }
    
    /**
     * Remove the specified department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/departments/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('departments.index')
                ->with('error', $response['message'] ?? 'Failed to delete department');
        }
        
        return redirect()->route('departments.index')
            ->with('success', $response['message'] ?? 'Department deleted successfully');
    }
}