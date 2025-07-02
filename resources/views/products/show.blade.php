<!--
    Product Details Page
    This Blade view displays detailed information about a single product, including its basic info, details, images, and metadata.
    Each section, field, and action button is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Product Details - Pazar Website Admin')

@section('page-title', 'Product Details')

@section('content')
    <!-- Top bar with Back, Edit, and Delete buttons -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Button: Back to product list -->
        <x-button href="{{ route('products.index') }}" variant="outline">
            <!-- Back icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Button: Edit product -->
            <x-button href="{{ route('products.edit', $product['p_id']) }}" variant="primary">
                <!-- Edit icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <!-- Button: Delete product (with confirmation) -->
            <form action="{{ route('products.destroy', $product['p_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    <!-- Delete icon -->
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </x-button>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main content: Product information and details -->
        <div class="lg:col-span-2">
            <!-- Card: General product information -->
            <x-card title="Product Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <!-- Product ID -->
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $product['p_id'] }}</p>
                    </div>
                    
                    <div>
                        <!-- Product category name -->
                        <h4 class="text-sm font-medium text-gray-400">Category</h4>
                        <p>{{ $product['category_name'] ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <!-- Product status (active/inactive) -->
                        <h4 class="text-sm font-medium text-gray-400">Status</h4>
                        <p>
                            <span class="px-2 py-1 text-xs rounded-full {{ $product['p_is_active'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                {{ $product['p_is_active'] ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Basic product information in both languages -->
            <x-card title="Basic Information" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <!-- Product name in Indonesian -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Name (Indonesia)</h4>
                        <p>{{ $product['p_title_id'] }}</p>
                        
                        <!-- Product description in Indonesian -->
                        <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (Indonesia)</h4>
                        <p>{{ $product['p_description_id'] }}</p>
                    </div>
                    
                    <div>
                        <!-- Product name in English -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Name (English)</h4>
                        <p>{{ $product['p_title_en'] }}</p>
                        
                        <!-- Product description in English -->
                        <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (English)</h4>
                        <p>{{ $product['p_description_en'] }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Product details (if available) -->
            <x-card title="Product Details" class="mt-6">
                @if(isset($product['detail']) && $product['detail'])
                    <!-- Button: Edit product details -->
                    <div class="mb-4 flex justify-end">
                        <x-button href="{{ route('productdetails.edit', $product['p_id']) }}" variant="secondary" size="sm">
                            <!-- Edit icon -->
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Details
                        </x-button>
                    </div>
                    <!-- Product detail fields -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <!-- Product Detail ID -->
                            <h4 class="text-sm font-medium text-gray-400">ID</h4>
                            <p>{{ $product['detail']['pd_id'] }}</p>

                            <!-- Net Weight of the product -->
                            <h4 class="text-sm font-medium text-gray-400 mt-2">Net Weight</h4>
                            {!! nl2br(e($product['detail']['pd_net_weight'])) !!}

                            <!-- Long description in English -->
                            <h4 class="text-sm font-medium text-gray-400 mb-2">Long Description (English)</h4>
                            {!! nl2br(e($product['detail']['pd_longdesc_en'])) !!}
                        </div>
                        
                        <div>
                            <!-- Product Detail: ID Product -->
                            <h4 class="text-sm font-medium text-gray-400">ID Product</h4>
                            <p>{{ $product['detail']['pd_id_product'] }}</p>

                            <!-- Long description in Indonesian -->
                            <h4 class="text-sm font-medium text-gray-400 mt-2">Long Description (Indonesia)</h4>
                            {!! nl2br(e($product['detail']['pd_longdesc_id'])) !!}
                        </div>
                    </div>
                    
                    <!-- Section: Marketplace links for this product -->
                    <h4 class="text-sm font-medium text-gray-400 mt-6 mb-2">Marketplace Links</h4>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <!-- Shopee link (if available) -->
                        @if(!empty($product['detail']['pd_link_shopee']))
                            <a href="{{ $product['detail']['pd_link_shopee'] }}" target="_blank" class="p-3 bg-amber-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-center flex flex-col items-center">
                                <span class="text-amber-400 font-medium">Shopee</span>
                                <span class="text-xs text-gray-400 mt-1">View Product</span>
                            </a>
                        @endif
                        
                        <!-- Tokopedia link (if available) -->
                        @if(!empty($product['detail']['pd_link_tokopedia']))
                            <a href="{{ $product['detail']['pd_link_tokopedia'] }}" target="_blank" class="p-3 bg-green-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-center flex flex-col items-center">
                                <span class="text-green-400 font-medium">Tokopedia</span>
                                <span class="text-xs text-gray-400 mt-1">View Product</span>
                            </a>
                        @endif
                        
                        <!-- Blibli link (if available) -->
                        @if(!empty($product['detail']['pd_link_blibli']))
                            <a href="{{ $product['detail']['pd_link_blibli'] }}" target="_blank" class="p-3 bg-blue-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-center flex flex-col items-center">
                                <span class="text-blue-400 font-medium">Blibli</span>
                                <span class="text-xs text-gray-400 mt-1">View Product</span>
                            </a>
                        @endif
                        
                        <!-- Lazada link (if available) -->
                        @if(!empty($product['detail']['pd_link_lazada']))
                            <a href="{{ $product['detail']['pd_link_lazada'] }}" target="_blank" class="p-3 bg-purple-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-center flex flex-col items-center">
                                <span class="text-purple-400 font-medium">Lazada</span>
                                <span class="text-xs text-gray-400 mt-1">View Product</span>
                            </a>
                        @endif
                    </div>
                @else
                    <!-- If no product details exist, show message and add button -->
                    <div class="text-center py-6">
                        <p class="text-gray-400 mb-4">No detailed information available for this product.</p>
                        <!-- Button: Add product details -->
                        <x-button href="{{ route('productdetails.create', $product['p_id']) }}" variant="primary">
                            <!-- Add icon -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Product Details
                        </x-button>
                    </div>
                @endif
            </x-card>
        </div>
        
        <!-- Sidebar: Product image and metadata -->
        <div class="lg:col-span-1">
            <!-- Card: Product image -->
            <x-card title="Image">
                @if(!empty($product['p_image']))
                    <div class="mb-4">
                        <!-- Product image -->
                        <img src="{{ $product['p_image'] }}" alt="{{ $product['p_title_id'] }}" class="w-full rounded-md">
                    </div>
                @else
                    <!-- Placeholder if no image -->
                    <div class="flex items-center justify-center h-48 bg-gray-800 rounded-md">
                        <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-center text-sm text-gray-400 mt-2">No image available</p>
                @endif
            </x-card>
            
            <!-- Card: Product metadata (created/updated info) -->
            <x-card title="Metadata Product" class="mt-6">
                <div class="text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created at</span>
                        <span>{{ isset($product['p_created_at']) ? date('d M Y H:i', strtotime($product['p_created_at'])) : '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created by</span>
                        <span>
                            @if(isset($product['created_by']) && isset($product['created_by']['name']))
                                {{ $product['created_by']['name'] }}
                            @else
                                {{ $product['p_created_by'] ?? '-' }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated at</span>
                        <span>{{ isset($product['p_updated_at']) ? date('d M Y H:i', strtotime($product['p_updated_at'])) : '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated by</span>
                        <span>
                            @if(isset($product['updated_by']) && isset($product['updated_by']['name']))
                                {{ $product['updated_by']['name'] }}
                            @else
                                {{ $product['p_updated_by'] ?? '-' }}
                            @endif
                        </span>
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Product detail metadata (created/updated info for details) -->
            <x-card title="Metadata Product Detail" class="mt-6">
                <div class="text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created at</span>
                        <span>{{ isset($product['detail']['pd_created_at']) ? date('d M Y H:i', strtotime($product['detail']['pd_created_at'])) : '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created by</span>
                        <span>
                            @if(isset($product['detail']['created_by']) && isset($product['detail']['created_by']['name']))
                                {{ $product['detail']['created_by']['name'] }}
                            @else
                                {{ $product['detail']['pd_created_by'] ?? '-' }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated at</span>
                        <span>{{ isset($product['detail']['pd_updated_at']) ? date('d M Y H:i', strtotime($product['detail']['pd_updated_at'])) : '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated by</span>
                        <span>
                            @if(isset($product['detail']['updated_by']) && isset($product['detail']['updated_by']['name']))
                                {{ $product['detail']['updated_by']['name'] }}
                            @else
                                {{ $product['detail']['pd_updated_by'] ?? '-' }}
                            @endif
                        </span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection