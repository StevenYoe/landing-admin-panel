<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'p_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1),
            'category_id' => $request->input('category_id')
        ];

        // Get categories for filter dropdown - With improved error handling
        $categoriesResponse = $this->crudApiGet('/productcategories/all');
        $categories = [];

        if (isset($categoriesResponse['success']) && $categoriesResponse['success'] && isset($categoriesResponse['data'])) {
            $categories = $categoriesResponse['data'];
        }

        // Use CRUD API to get products data
        $response = $this->crudApiGet('/products', $params);
    
        if (!isset($response['success']) || !$response['success']) {
            return view('products.index', compact('categories'))->with('error', $response['message'] ?? 'Failed to fetch products');
        }
        
        $products = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($products as &$product) {
            if (!empty($product['p_image'])) {
                $product['p_image'] = config('app.crud_storage_url') . '/' . $product['p_image'];
            }
        }
        
        // Process product data to ensure category_name is accessible
        foreach ($products as &$product) {
            // Check if category data exists in the response and set category_name
            if (isset($product['category']) && is_array($product['category'])) {
                $product['category_name'] = $product['category']['pc_title_id'] ?? '-';
            } else {
                $product['category_name'] = '-';
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $products,
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
        $categoryId = $params['category_id'];
        
        return view('products.index', compact('products', 'categories', 'paginator', 'sortBy', 'sortOrder', 'categoryId'));
    }

    // Other methods remain unchanged...

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get categories for dropdown - with improved error handling
        $categoriesResponse = $this->crudApiGet('/productcategories/all');
        $categories = [];
        
        if (isset($categoriesResponse['success']) && $categoriesResponse['success'] && isset($categoriesResponse['data'])) {
            $categories = $categoriesResponse['data'];
        }
        
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'p_id_product_category' => 'required|integer',
            'p_title_id' => 'required|string|max:255',
            'p_title_en' => 'required|string|max:255',
            'p_description_id' => 'nullable|string',
            'p_description_en' => 'nullable|string',
            'p_is_active' => 'nullable|boolean',
            'p_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload
        if ($request->hasFile('p_image')) {
            $data['p_image'] = $request->file('p_image');
        }
        
        // Use CRUD API to store product data
        $response = $this->crudApiPost('/products', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create product');
        }
        
        return redirect()->route('products.index')
            ->with('success', $response['message'] ?? 'Product created successfully');
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/products/{$id}");
    
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('products.index')
                ->with('error', $response['message'] ?? 'Product not found');
        }
        
        $product = $response['data'];
        
        // Transform image path
        if (!empty($product['p_image'])) {
            $product['p_image'] = config('app.crud_storage_url') . '/' . $product['p_image'];
        }
        
        // Process category data
        if (isset($product['category']) && is_array($product['category'])) {
            $product['category_name'] = $product['category']['pc_title_id'] ?? '-';
        } else {
            $product['category_name'] = '-';
        }
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Get categories for dropdown
        $categoriesResponse = $this->crudApiGet('/productcategories/all');
        $categories = [];
        if (isset($categoriesResponse['success']) && $categoriesResponse['success']) {
            $categories = $categoriesResponse['data'];
        }
        
        $response = $this->crudApiGet("/products/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('products.index')
                ->with('error', $response['message'] ?? 'Product not found');
        }
        
        $product = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($product['p_image'])) {
            $product['p_image'] = config('app.crud_storage_url') . '/' . $product['p_image'];
        }
        
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'p_id_product_category' => 'required|integer',
            'p_title_id' => 'required|string|max:255',
            'p_title_en' => 'required|string|max:255',
            'p_description_id' => 'nullable|string',
            'p_description_en' => 'nullable|string',
            'p_is_active' => 'nullable|boolean',
            'p_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('p_image')) {
            $data['p_image'] = $request->file('p_image');
        }
        
        // Use CRUD API to update product data
        $response = $this->crudApiPut("/products/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update product');
        }
        
        return redirect()->route('products.index')
            ->with('success', $response['message'] ?? 'Product updated successfully');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/products/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('products.index')
                ->with('error', $response['message'] ?? 'Failed to delete product');
        }
        
        return redirect()->route('products.index')
            ->with('success', $response['message'] ?? 'Product deleted successfully');
    }
}