<!--
    Product List Page
    This Blade view displays a list of all products in the admin panel.
    Includes a filter form, table with product details, and actions to view, edit, or delete each product.
-->
@extends('layouts.app')

@section('title', 'Products - Pazar Website Admin')

@section('page-title', 'Products')

@section('content')
    <!--
        Header section: Shows the page title and a button to add a new product.
    -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Product List</h2>
        <x-button href="{{ route('products.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Product
        </x-button>
    </div>
    <!--
        Card container for the product table and filter form.
    -->
    <x-card>
        <!--
            Filter form: Allows filtering products by category.
        -->
        <div class="mb-4">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="w-full sm:w-1/3">
                    <x-form.select 
                        name="category_id" 
                        label="Filter by Category" 
                        :options="collect($categories)->pluck('pc_title_id', 'pc_id')->toArray()" 
                        :selected="$categoryId ?? ''"
                        placeholder="All Categories"
                        class="mb-0"
                    />
                </div>
                <div class="flex items-end space-x-2 pt-5">
                    <x-button type="submit" variant="secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </x-button>
                    @if($categoryId)
                        <x-button href="{{ route('products.index') }}" variant="outline">
                            Clear
                        </x-button>
                    @endif
                </div>
            </form>
        </div>
        @if(count($products) > 0)
            <!--
                Table of products: Displays ID, names, category, status, image, and actions for each product.
            -->
            <div class="overflow-x-auto">
                <x-table 
                    :headers="[
                        ['name' => 'ID', 'key' => 'p_id'],
                        ['name' => 'Name (ID)', 'key' => 'p_title_id'],
                        ['name' => 'Name (EN)', 'key' => 'p_title_en'],
                        ['name' => 'Category', 'key' => 'category_name'],
                        ['name' => 'Status', 'key' => 'p_is_active'],
                        ['name' => 'Image', 'key' => 'p_image']
                    ]"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                >
                    @foreach($products as $product)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                            <!-- Product ID -->
                            <td class="px-5 py-4 text-center">{{ $product['p_id'] }}</td>
                            <!-- Product Name (Indonesian) -->
                            <td class="px-5 py-4">{{ $product['p_title_id'] }}</td>
                            <!-- Product Name (English) -->
                            <td class="px-5 py-4">{{ $product['p_title_en'] }}</td>
                            <!-- Product Category Name -->
                            <td class="px-5 py-4 text-center">{{ $product['category_name'] ?? '-' }}</td>
                            <!-- Product Status (Active/Inactive) -->
                            <td class="px-5 py-4 text-center">
                                @if(isset($product['p_is_active']))
                                    <span class="px-2 py-1 text-xs rounded-full {{ $product['p_is_active'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                        {{ $product['p_is_active'] ? 'Active' : 'Inactive' }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <!-- Product Image (thumbnail if available) -->
                            <td class="px-5 py-4 text-center">
                                @if(!empty($product['p_image']))
                                    <img src="{{ $product['p_image'] }}" alt="{{ $product['p_title_id'] }}" class="h-12 w-auto mx-auto">
                                @else
                                    -
                                @endif
                            </td>
                            <!-- Action buttons: View, Edit, Delete -->
                            <td class="px-5 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <!-- View button -->
                                    <a href="{{ route('products.show', $product['p_id']) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <!-- Edit button -->
                                    <a href="{{ route('products.edit', $product['p_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <!-- Delete button (with confirmation) -->
                                    <form action="{{ route('products.destroy', $product['p_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
            <!--
                Pagination links if paginator is set.
            -->
            @if(isset($paginator))
                <div class="mt-4">
                    {{ $paginator->links() }}
                </div>
            @endif
        @else
            <!--
                Empty state: Shown if there are no products in the database.
            -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No products have been added yet</p>
                <x-button href="{{ route('products.create') }}" variant="primary" class="mt-4">
                    Add Product
                </x-button>
            </div>
        @endif
    </x-card>
@endsection
