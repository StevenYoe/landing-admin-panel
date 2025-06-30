<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class FooterController extends BaseController
{
    /**
     * Display a listing of the footers.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'f_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get footers data
        $response = $this->crudApiGet('/footers', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('footers.index')->with('error', $response['message'] ?? 'Failed to fetch footers');
        }
        
        $footers = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($footers as &$footer) {
            if (!empty($footer['f_icon'])) {
                $footer['f_icon'] = config('app.crud_storage_url') . '/' . $footer['f_icon'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $footers,
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
        
        return view('footers.index', compact('footers', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new footer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('footers.create');
    }

    /**
     * Store a newly created footer in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'f_type' => 'required|string|max:50',
            'f_label_id' => 'required|string|max:255',
            'f_label_en' => 'required|string|max:255',
            'f_description_id' => 'nullable|string',
            'f_description_en' => 'nullable|string',
            'f_icon' => 'nullable|file|mimes:svg,jpg,jpeg,png,gif|max:2048',
            'f_link' => 'nullable|string|max:255',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Handle file upload if needed
        if ($request->hasFile('f_icon') && $request->file('f_icon')->isValid()) {
            $data['f_icon'] = $request->file('f_icon');
        }
        
        // Use CRUD API to store footer data
        $response = $this->crudApiPost('/footers', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create footer');
        }
        
        return redirect()->route('footers.index')
            ->with('success', $response['message'] ?? 'Footer created successfully');
    }

    /**
     * Display the specified footer.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/footers/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('footers.index')
                ->with('error', $response['message'] ?? 'Footer not found');
        }
        
        $footer = $response['data'];
        
        // Transform image path
        if (!empty($footer['f_icon'])) {
            $footer['f_icon'] = config('app.crud_storage_url') . '/' . $footer['f_icon'];
        }
        
        return view('footers.show', compact('footer'));
    }

    /**
     * Show the form for editing the specified footer.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/footers/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('footers.index')
                ->with('error', $response['message'] ?? 'Footer not found');
        }
        
        $footer = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($footer['f_icon'])) {
            $footer['f_icon'] = config('app.crud_storage_url') . '/' . $footer['f_icon'];
        }
        
        return view('footers.edit', compact('footer'));
    }

    /**
     * Update the specified footer in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'f_type' => 'required|string|max:50',
            'f_label_id' => 'required|string|max:255',
            'f_label_en' => 'required|string|max:255',
            'f_description_id' => 'nullable|string',
            'f_description_en' => 'nullable|string',
            'f_icon' => 'nullable|file|mimes:svg,jpg,jpeg,png,gif|max:2048',
            'f_link' => 'nullable|string|max:255',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Get current footer to check if we need to retain the icon
        $currentFooter = $this->crudApiGet("/footers/{$id}");
        
        // Handle file upload if needed
        if ($request->hasFile('f_icon') && $request->file('f_icon')->isValid()) {
            $data['f_icon'] = $request->file('f_icon');
        } else if (isset($currentFooter['data']['f_icon']) && !empty($currentFooter['data']['f_icon'])) {
            // If no new icon is uploaded and there is an existing icon, 
            // we need to explicitly indicate to keep the current icon
            $data['keep_current_icon'] = true;
        }
        
        // Use CRUD API to update footer data
        $response = $this->crudApiPut("/footers/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update footer');
        }
        
        return redirect()->route('footers.index')
            ->with('success', $response['message'] ?? 'Footer updated successfully');
    }

    /**
     * Remove the specified footer from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/footers/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('footers.index')
                ->with('error', $response['message'] ?? 'Failed to delete footer');
        }
        
        return redirect()->route('footers.index')
            ->with('success', $response['message'] ?? 'Footer deleted successfully');
    }
}