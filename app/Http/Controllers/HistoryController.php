<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryController extends BaseController
{
    /**
     * Display a listing of the histories.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'hs_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get histories data
        $response = $this->crudApiGet('/histories', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('histories.index')->with('error', $response['message'] ?? 'Failed to fetch histories');
        }
        
        $histories = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($histories as &$history) {
            if (!empty($history['hs_image'])) {
                $history['hs_image'] = config('app.crud_storage_url') . '/' . $history['hs_image'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $histories,
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
        
        return view('histories.index', compact('histories', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new history.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('histories.create');
    }

    /**
     * Store a newly created history in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hs_year' => 'required|string|max:50',
            'hs_description_id' => 'required|string',
            'hs_description_en' => 'required|string',
            'hs_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Handle file upload if needed
        if ($request->hasFile('hs_image') && $request->file('hs_image')->isValid()) {
            $data['hs_image'] = $request->file('hs_image');
        }
        
        // Use CRUD API to store history data
        $response = $this->crudApiPost('/histories', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create history');
        }
        
        return redirect()->route('histories.index')
            ->with('success', $response['message'] ?? 'History created successfully');
    }

    /**
     * Display the specified history.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/histories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('histories.index')
                ->with('error', $response['message'] ?? 'History not found');
        }
        
        $history = $response['data'];
        
        // Transform image path
        if (!empty($history['hs_image'])) {
            $history['hs_image'] = config('app.crud_storage_url') . '/' . $history['hs_image'];
        }
        
        return view('histories.show', compact('history'));
    }

    /**
     * Show the form for editing the specified history.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/histories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('histories.index')
                ->with('error', $response['message'] ?? 'History not found');
        }
        
        $history = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($history['hs_image'])) {
            $history['hs_image'] = config('app.crud_storage_url') . '/' . $history['hs_image'];
        }
        
        return view('histories.edit', compact('history'));
    }

    /**
     * Update the specified history in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'hs_year' => 'required|string|max:50',
            'hs_description_id' => 'required|string',
            'hs_description_en' => 'required|string',
            'hs_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Get current history to check if we need to retain the image
        $currentHistory = $this->crudApiGet("/histories/{$id}");
        
        // Handle file upload if needed
        if ($request->hasFile('hs_image') && $request->file('hs_image')->isValid()) {
            $data['hs_image'] = $request->file('hs_image');
        } else if (isset($currentHistory['data']['hs_image']) && !empty($currentHistory['data']['hs_image'])) {
            // If no new image is uploaded and there is an existing image, 
            // we need to explicitly indicate to keep the current image
            $data['keep_current_image'] = true;
        }
        
        // Use CRUD API to update history data
        $response = $this->crudApiPut("/histories/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update history');
        }
        
        return redirect()->route('histories.index')
            ->with('success', $response['message'] ?? 'History updated successfully');
    }

    /**
     * Remove the specified history from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/histories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('histories.index')
                ->with('error', $response['message'] ?? 'Failed to delete history');
        }
        
        return redirect()->route('histories.index')
            ->with('success', $response['message'] ?? 'History deleted successfully');
    }
}