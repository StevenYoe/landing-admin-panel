<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCategoryController extends BaseController
{
    /**
     * Display a listing of the product categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'pc_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get product categories data with error logging
        try {
            $response = $this->crudApiGet('/productcategories', $params);
            
            if (!isset($response['success']) || !$response['success']) {
                return view('productcategories.index')->with('error', $response['message'] ?? 'Failed to fetch product categories');
            }
            
            $categories = $response['data']['data'] ?? [];
        
            // Transform image paths
            foreach ($categories as &$category) {
                if (!empty($category['pc_image'])) {
                    $category['pc_image'] = config('app.crud_storage_url') . '/' . $category['pc_image'];
                }
            }
            
            // Create a proper paginator instance
            $paginator = null;
            if (isset($response['data'])) {
                $paginationData = $response['data'];
                if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                    $paginator = new LengthAwarePaginator(
                        $categories,
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
            
            return view('productcategories.index', compact('categories', 'paginator', 'sortBy', 'sortOrder'));
        } catch (\Exception $e) {
            return view('productcategories.index')->with('error', 'An error occurred while fetching product categories');
        }
    }

    /**
     * Show the form for creating a new product category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('productcategories.create');
    }

    /**
     * Store a newly created product category in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pc_title_id' => 'required|string|max:255',
            'pc_title_en' => 'required|string|max:255',
            'pc_description_id' => 'nullable|string',
            'pc_description_en' => 'nullable|string',
            'pc_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('pc_image')) {
            $data['pc_image'] = $request->file('pc_image');
        }
        
        // Use CRUD API to store product category data
        $response = $this->crudApiPost('/productcategories', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create product category');
        }
        
        return redirect()->route('productcategories.index')
            ->with('success', $response['message'] ?? 'Product category created successfully');
    }

    /**
     * Display the specified product category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/productcategories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('productcategories.index')
                ->with('error', $response['message'] ?? 'Product category not found');
        }
        
        $category = $response['data'];
        
        // Transform image path
        if (!empty($category['pc_image'])) {
            $category['pc_image'] = config('app.crud_storage_url') . '/' . $category['pc_image'];
        }
        
        return view('productcategories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified product category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/productcategories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('productcategories.index')
                ->with('error', $response['message'] ?? 'Product category not found');
        }
        
        $category = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($category['pc_image'])) {
            $category['pc_image'] = config('app.crud_storage_url') . '/' . $category['pc_image'];
        }
        
        return view('productcategories.edit', compact('category'));
    }

    /**
     * Update the specified product category in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pc_title_id' => 'required|string|max:255',
            'pc_title_en' => 'required|string|max:255',
            'pc_description_id' => 'nullable|string',
            'pc_description_en' => 'nullable|string',
            'pc_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('pc_image')) {
            $data['pc_image'] = $request->file('pc_image');
        }
        
        // Use CRUD API to update product category data
        $response = $this->crudApiPut("/productcategories/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update product category');
        }
        
        return redirect()->route('productcategories.index')
            ->with('success', $response['message'] ?? 'Product category updated successfully');
    }

    /**
     * Remove the specified product category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/productcategories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('productcategories.index')
                ->with('error', $response['message'] ?? 'Failed to delete product category');
        }
        
        return redirect()->route('productcategories.index')
            ->with('success', $response['message'] ?? 'Product category deleted successfully');
    }
}