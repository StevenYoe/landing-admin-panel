<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCatalogController extends BaseController
{
    /**
     * Display a listing of the product catalogs.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'pct_id'),
            'sort_order' => $request->input('sort_order', 'desc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get product catalogs data
        $response = $this->crudApiGet('/productcatalogs', $params);
    
        if (!isset($response['success']) || !$response['success']) {
            return view('productcatalogs.index')->with('error', $response['message'] ?? 'Failed to fetch product catalogs');
        }
        
        $catalogs = $response['data']['data'] ?? [];
        
        // Transform file paths to full URL
        foreach ($catalogs as &$catalog) {
            if (!empty($catalog['pct_catalog_id'])) {
                $catalog['pct_catalog_id'] = config('app.crud_storage_url') . '/' . $catalog['pct_catalog_id'];
            }
            if (!empty($catalog['pct_catalog_en'])) {
                $catalog['pct_catalog_en'] = config('app.crud_storage_url') . '/' . $catalog['pct_catalog_en'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $catalogs,
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
        
        return view('productcatalogs.index', compact('catalogs', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new product catalog.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('productcatalogs.create');
    }

    /**
     * Store a newly created product catalog in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pct_catalog_id' => 'nullable|file|max:51200', // 50MB limit for Indonesian catalog
            'pct_catalog_en' => 'nullable|file|max:51200', // 50MB limit for English catalog
        ]);
        
        $data = $request->all();
        
        // Handle Indonesian catalog file upload
        if ($request->hasFile('pct_catalog_id')) {
            $data['pct_catalog_id'] = $request->file('pct_catalog_id');
        }
        
        // Handle English catalog file upload
        if ($request->hasFile('pct_catalog_en')) {
            $data['pct_catalog_en'] = $request->file('pct_catalog_en');
        }
        
        // Use CRUD API to store product catalog data
        $response = $this->crudApiPost('/productcatalogs', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create product catalog');
        }
        
        return redirect()->route('productcatalogs.index')
            ->with('success', $response['message'] ?? 'Product catalog created successfully');
    }

    /**
     * Display the specified product catalog.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/productcatalogs/{$id}");
    
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('productcatalogs.index')
                ->with('error', $response['message'] ?? 'Product catalog not found');
        }
        
        $catalog = $response['data'];
        
        // Transform file paths to full URL
        if (!empty($catalog['pct_catalog_id'])) {
            $catalog['pct_catalog_id'] = config('app.crud_storage_url') . '/' . $catalog['pct_catalog_id'];
        }
        if (!empty($catalog['pct_catalog_en'])) {
            $catalog['pct_catalog_en'] = config('app.crud_storage_url') . '/' . $catalog['pct_catalog_en'];
        }
        
        return view('productcatalogs.show', compact('catalog'));
    }

    /**
     * Show the form for editing the specified product catalog.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/productcatalogs/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('productcatalogs.index')
                ->with('error', $response['message'] ?? 'Product catalog not found');
        }
        
        $catalog = $response['data'];
    
        // Transform file paths to full URL if they exist
        if (!empty($catalog['pct_catalog_id'])) {
            $catalog['pct_catalog_id'] = config('app.crud_storage_url') . '/' . $catalog['pct_catalog_id'];
        }
        if (!empty($catalog['pct_catalog_en'])) {
            $catalog['pct_catalog_en'] = config('app.crud_storage_url') . '/' . $catalog['pct_catalog_en'];
        }
        
        return view('productcatalogs.edit', compact('catalog'));
    }

    /**
     * Update the specified product catalog in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pct_catalog_id' => 'nullable|file|max:51200', // 50MB limit for Indonesian catalog
            'pct_catalog_en' => 'nullable|file|max:51200', // 50MB limit for English catalog
        ]);
        
        $data = $request->all();
        
        // Handle Indonesian catalog file upload if needed
        if ($request->hasFile('pct_catalog_id')) {
            $data['pct_catalog_id'] = $request->file('pct_catalog_id');
        }
        
        // Handle English catalog file upload if needed
        if ($request->hasFile('pct_catalog_en')) {
            $data['pct_catalog_en'] = $request->file('pct_catalog_en');
        }
        
        // Use CRUD API to update product catalog data
        $response = $this->crudApiPut("/productcatalogs/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update product catalog');
        }
        
        return redirect()->route('productcatalogs.index')
            ->with('success', $response['message'] ?? 'Product catalog updated successfully');
    }

    /**
     * Remove the specified product catalog from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/productcatalogs/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('productcatalogs.index')
                ->with('error', $response['message'] ?? 'Failed to delete product catalog');
        }
        
        return redirect()->route('productcatalogs.index')
            ->with('success', $response['message'] ?? 'Product catalog deleted successfully');
    }
}