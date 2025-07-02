<!--
    Edit Product Page
    This Blade view provides a form for editing an existing product in the admin panel.
    Includes fields for product names, category, status, descriptions, image upload, and uses custom Blade components for UI consistency.
-->
@extends('layouts.app')

@section('title', 'Edit Product - Pazar Website Admin')

@section('page-title', 'Edit Product')

@section('content')
    <!--
        Back to List button: Navigates back to the product list page.
    -->
    <div class="mb-6">
        <x-button href="{{ route('products.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    <!--
        Card container for the product edit form.
    -->
    <x-card>
        <!--
            Form to update an existing product.
            Submits to the products.update route using PUT method.
            enctype="multipart/form-data" allows image upload.
        -->
        <form action="{{ route('products.update', $product['p_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--
                Form fields are organized in a responsive grid.
            -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Input for product name in Indonesian -->
                    <x-form.input 
                        name="p_title_id" 
                        label="Product Name (Indonesia)" 
                        placeholder="Enter product name in Indonesian" 
                        :value="old('p_title_id', $product['p_title_id'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                <div>
                    <!-- Input for product name in English -->
                    <x-form.input 
                        name="p_title_en" 
                        label="Product Name (English)" 
                        placeholder="Enter product name in English" 
                        :value="old('p_title_en', $product['p_title_en'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                <div>
                    <!-- Select for product category -->
                    <x-form.select 
                        name="p_id_product_category" 
                        label="Product Category" 
                        :options="collect($categories)->pluck('pc_title_id', 'pc_id')->toArray()" 
                        :selected="old('p_id_product_category', $product['p_id_product_category'])"
                        placeholder="Select Category"
                        required
                    />
                </div>
                <div class="md:col-span-2">
                    <!-- Radio buttons for product status (Active/Inactive) -->
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="p_is_active" value="1" {{ old('p_is_active', $product['p_is_active']) == '1' ? 'checked' : '' }}
                                class="w-4 h-4 text-accent border-gray-600 focus:ring-accent focus:ring-opacity-50">
                            <span class="ml-2">Active</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="p_is_active" value="0" {{ old('p_is_active', $product['p_is_active']) == '0' ? 'checked' : '' }}
                                class="w-4 h-4 text-accent border-gray-600 focus:ring-accent focus:ring-opacity-50">
                            <span class="ml-2">Inactive</span>
                        </label>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <!-- Textarea for product description in Indonesian -->
                    <x-form.textarea 
                        name="p_description_id" 
                        label="Description (Indonesia)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('p_description_id', $product['p_description_id'])"
                        rows="4"
                    />
                </div>
                <div class="md:col-span-2">
                    <!-- Textarea for product description in English -->
                    <x-form.textarea 
                        name="p_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('p_description_en', $product['p_description_en'])"
                        rows="4"
                    />
                </div>
                <div class="md:col-span-2">
                    <!--
                        File input for product image upload.
                        Accepts image files only. Shows current image if available.
                    -->
                    <label for="p_image" class="block text-sm font-medium mb-2">Gambar Produk</label>
                    <input type="file" name="p_image" id="p_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                    @if(!empty($product['p_image']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Current Product Image:</p>
                            <img src="{{ $product['p_image'] }}" alt="Product Image" class="h-40 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            <!--
                Action buttons: Cancel returns to the list, Update submits the form.
            -->
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('products.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
