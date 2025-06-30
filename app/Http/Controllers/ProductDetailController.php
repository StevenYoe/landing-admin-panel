<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductDetailController extends BaseController
{
    /**
     * Show the form for creating a new product detail.
     *
     * @param  int  $productId
     * @return \Illuminate\View\View
     */
    public function create($productId)
    {
        // Get product information
        $productResponse = $this->crudApiGet("/products/{$productId}");
        
        if (!isset($productResponse['success']) || !$productResponse['success']) {
            return redirect()->route('products.index')
                ->with('error', $productResponse['message'] ?? 'Product not found');
        }
        
        $product = $productResponse['data'];
        
        return view('productdetails.create', compact('product'));
    }

    /**
     * Store a newly created product detail in storage.
     *
     * @param  Request  $request
     * @param  int  $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'pd_net_weight' => 'nullable|string|max:255',
            'pd_longdesc_id' => 'nullable|string',
            'pd_longdesc_en' => 'nullable|string',
            'pd_link_shopee' => 'nullable|string|max:255',
            'pd_link_tokopedia' => 'nullable|string|max:255',
            'pd_link_blibli' => 'nullable|string|max:255',
            'pd_link_lazada' => 'nullable|string|max:255',
        ]);
        
        // Add product ID to data
        $data = $request->all();
        $data['pd_id_product'] = $productId;
        
        // Use CRUD API to store product detail data
        $response = $this->crudApiPost('/productdetails', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create product detail');
        }
        
        return redirect()->route('products.show', $productId)
            ->with('success', $response['message'] ?? 'Product detail created successfully');
    }

    /**
     * Show the form for editing the specified product detail.
     *
     * @param  int  $productId
     * @return \Illuminate\View\View
     */
    public function edit($productId)
    {
        // Get product information
        $productResponse = $this->crudApiGet("/products/{$productId}");
        
        if (!isset($productResponse['success']) || !$productResponse['success']) {
            return redirect()->route('products.index')
                ->with('error', $productResponse['message'] ?? 'Product not found');
        }
        
        $product = $productResponse['data'];
        
        // Get product detail information
        // Mengubah endpoint dari '/productdetails/by-product/{productId}' menjadi '/getByProductId/{productId}'
        $detailResponse = $this->crudApiGet("/productdetails/by-product/{$productId}");
        
        if (!isset($detailResponse['success']) || !$detailResponse['success']) {
            return redirect()->route('products.show', $productId)
                ->with('error', $detailResponse['message'] ?? 'Product detail not found');
        }
        
        $productDetail = $detailResponse['data'];
        
        return view('productdetails.edit', compact('product', 'productDetail'));
    }

    /**
     * Update the specified product detail in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pd_net_weight' => 'nullable|string|max:255',
            'pd_longdesc_id' => 'nullable|string',
            'pd_longdesc_en' => 'nullable|string',
            'pd_link_shopee' => 'nullable|string|max:255',
            'pd_link_tokopedia' => 'nullable|string|max:255',
            'pd_link_blibli' => 'nullable|string|max:255',
            'pd_link_lazada' => 'nullable|string|max:255',
        ]);
        
        $data = $request->all();
        
        // Use CRUD API to update product detail data
        $response = $this->crudApiPut("/productdetails/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update product detail');
        }
        
        // Get product ID from response data to redirect properly
        $productId = $response['data']['pd_id_product'] ?? $request->input('pd_id_product');
        
        return redirect()->route('products.show', $productId)
            ->with('success', $response['message'] ?? 'Product detail updated successfully');
    }
}