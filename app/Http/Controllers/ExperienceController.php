<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ExperienceController extends BaseController
{
    /**
     * Display a listing of the experience levels.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'ex_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];
        
        // Use CRUD API to get experience data
        $response = $this->crudApiGet('/experiences', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('experiences.index')->with('error', $response['message'] ?? 'Failed to fetch experience levels');
        }
        
        $experiences = $response['data']['data'] ?? [];
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $experiences,
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
        
        return view('experiences.index', compact('experiences', 'paginator', 'sortBy', 'sortOrder'));
    }
    
    /**
     * Show the form for creating a new experience level.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('experiences.create');
    }
    
    /**
     * Store a newly created experience level in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ex_title_id' => 'required|string|max:100',
            'ex_title_en' => 'required|string|max:100',
        ]);
        
        // Use CRUD API to store experience data
        $response = $this->crudApiPost('/experiences', $request->all());
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create experience level');
        }
        
        return redirect()->route('experiences.index')
            ->with('success', $response['message'] ?? 'Experience level created successfully');
    }
    
    /**
     * Display the specified experience level.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/experiences/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('experiences.index')
                ->with('error', $response['message'] ?? 'Experience level not found');
        }
        
        $experience = $response['data'];
        
        return view('experiences.show', compact('experience'));
    }
    
    /**
     * Show the form for editing the specified experience level.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/experiences/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('experiences.index')
                ->with('error', $response['message'] ?? 'Experience level not found');
        }
        
        $experience = $response['data'];
        
        return view('experiences.edit', compact('experience'));
    }
    
    /**
     * Update the specified experience level in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ex_title_id' => 'required|string|max:100',
            'ex_title_en' => 'required|string|max:100',
        ]);
        
        // Use CRUD API to update experience data
        $response = $this->crudApiPut("/experiences/{$id}", $request->all());
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update experience level');
        }
        
        return redirect()->route('experiences.index')
            ->with('success', $response['message'] ?? 'Experience level updated successfully');
    }
    
    /**
     * Remove the specified experience level from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/experiences/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('experiences.index')
                ->with('error', $response['message'] ?? 'Failed to delete experience level');
        }
        
        return redirect()->route('experiences.index')
            ->with('success', $response['message'] ?? 'Experience level deleted successfully');
    }
}