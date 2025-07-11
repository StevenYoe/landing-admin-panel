<!--
    Product Category List Page
    This Blade view displays a list of all product categories in the admin panel.
    Includes a table with category details and actions to view, edit, or delete each category.
-->
@extends('layouts.app')

@section('title', 'Product Category - Pazar Website Admin')

@section('page-title', 'Product Category')

@section('content')
    <!--
        Header section: Shows the page title and a button to add a new product category.
    -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Product Category List</h2>
        <x-button href="{{ route('productcategories.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Product Category
        </x-button>
    </div>
    <!--
        Card container for the product category table or empty state.
    -->
    <x-card>
        @if(count($categories) > 0)
            <!--
                Table of product categories: Displays ID, titles, image, and actions for each category.
            -->
            <div class="overflow-x-auto">
            <x-table 
                :headers="[
                    ['name' => 'ID', 'key' => 'pc_id'],
                    ['name' => 'Title (ID)', 'key' => 'pc_title_id'],
                    ['name' => 'Title (EN)', 'key' => 'pc_title_en'],
                    ['name' => 'Image', 'key' => 'pc_image']
                ]"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
            >
                @foreach($categories as $category)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                        <!-- Category ID -->
                        <td class="px-5 py-4 text-center">{{ $category['pc_id'] }}</td>
                        <!-- Indonesian Title -->
                        <td class="px-5 py-4 text-center">{{ $category['pc_title_id'] }}</td>
                        <!-- English Title -->
                        <td class="px-5 py-4 text-center">{{ $category['pc_title_en'] }}</td>
                        <!-- Category Image (thumbnail if available) -->
                        <td class="px-5 py-4 text-center">
                            @if(!empty($category['pc_image']))
                                <img src="{{ $category['pc_image'] }}" alt="Category Image" class="h-10 w-auto mx-auto">
                            @else
                                -
                            @endif
                        </td>
                        <!-- Action buttons: View, Edit, Delete -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- View button -->
                                <a href="{{ route('productcategories.show', $category['pc_id']) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <!-- Edit button -->
                                <a href="{{ route('productcategories.edit', $category['pc_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete button (with confirmation) -->
                                <form action="{{ route('productcategories.destroy', $category['pc_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product category?');">
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
                Empty state: Shown if there are no product categories in the database.
            -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No product categories have been added yet</p>
                <x-button href="{{ route('productcategories.create') }}" variant="primary" class="mt-4">
                    Add Product Category
                </x-button>
            </div>
        @endif
    </x-card>
@endsection