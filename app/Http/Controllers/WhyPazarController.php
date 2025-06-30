<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class WhyPazarController extends BaseController
{
    /**
     * Display a listing of the why pazar items.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'w_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get why pazar items data
        $response = $this->crudApiGet('/whypazars', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('whypazars.index')->with('error', $response['message'] ?? 'Failed to fetch why pazar items');
        }
        
        $whyPazars = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($whyPazars as &$whyPazar) {
            if (!empty($whyPazar['w_image'])) {
                $whyPazar['w_image'] = config('app.crud_storage_url') . '/' . $whyPazar['w_image'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $whyPazars,
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
        
        return view('whypazars.index', compact('whyPazars', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new why pazar item.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('whypazars.create');
    }

    /**
     * Store a newly created why pazar item in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'w_title_id' => 'required|string|max:255',
            'w_title_en' => 'required|string|max:255',
            'w_description_id' => 'nullable|string',
            'w_description_en' => 'nullable|string',
            'w_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Handle file upload if needed
        if ($request->hasFile('w_image') && $request->file('w_image')->isValid()) {
            $data['w_image'] = $request->file('w_image');
        }
        
        // Use CRUD API to store why pazar item data
        $response = $this->crudApiPost('/whypazars', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create why pazar item');
        }
        
        return redirect()->route('whypazars.index')
            ->with('success', $response['message'] ?? 'Why pazar item created successfully');
    }

    /**
     * Display the specified why pazar item.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/whypazars/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('whypazars.index')
                ->with('error', $response['message'] ?? 'Why pazar item not found');
        }
        
        $whyPazar = $response['data'];
        
        // Transform image path
        if (!empty($whyPazar['w_image'])) {
            $whyPazar['w_image'] = config('app.crud_storage_url') . '/' . $whyPazar['w_image'];
        }
        
        return view('whypazars.show', compact('whyPazar'));
    }

    /**
     * Show the form for editing the specified why pazar item.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/whypazars/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('whypazars.index')
                ->with('error', $response['message'] ?? 'Why pazar item not found');
        }
        
        $whyPazar = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($whyPazar['w_image'])) {
            $whyPazar['w_image'] = config('app.crud_storage_url') . '/' . $whyPazar['w_image'];
        }
        
        return view('whypazars.edit', compact('whyPazar'));
    }

    /**
     * Update the specified why pazar item in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'w_title_id' => 'required|string|max:255',
            'w_title_en' => 'required|string|max:255',
            'w_description_id' => 'nullable|string',
            'w_description_en' => 'nullable|string',
            'w_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Get current why pazar item to check if we need to retain the image
        $currentWhyPazar = $this->crudApiGet("/whypazars/{$id}");
        
        // Handle file upload if needed
        if ($request->hasFile('w_image') && $request->file('w_image')->isValid()) {
            $data['w_image'] = $request->file('w_image');
        } else if (isset($currentWhyPazar['data']['w_image']) && !empty($currentWhyPazar['data']['w_image'])) {
            // If no new image is uploaded and there is an existing image, 
            // we need to explicitly indicate to keep the current image
            $data['keep_current_image'] = true;
        }
        
        // Use CRUD API to update why pazar item data
        $response = $this->crudApiPut("/whypazars/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update why pazar item');
        }
        
        return redirect()->route('whypazars.index')
            ->with('success', $response['message'] ?? 'Why pazar item updated successfully');
    }

    /**
     * Remove the specified why pazar item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/whypazars/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('whypazars.index')
                ->with('error', $response['message'] ?? 'Failed to delete why pazar item');
        }
        
        return redirect()->route('whypazars.index')
            ->with('success', $response['message'] ?? 'Why pazar item deleted successfully');
    }
}