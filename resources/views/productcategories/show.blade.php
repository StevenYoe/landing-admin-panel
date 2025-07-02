<!--
    Product Category Details Page
    This Blade view displays detailed information about a specific product category in the admin panel.
    Includes category info, titles, descriptions, image, and actions to edit or delete the category.
-->
@extends('layouts.app')

@section('title', 'Product Category Details - Pazar Website Admin')

@section('page-title', 'Product Category Details')

@section('content')
    <!--
        Header section: Back to List button and action buttons (Edit, Delete) for the product category.
    -->
    <div class="mb-6 flex justify-between items-center">
        <x-button href="{{ route('productcategories.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        <div class="flex justify-center space-x-2">
            <!-- Edit button: Navigates to the product category edit page -->
            <x-button href="{{ route('productcategories.edit', $category['pc_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            <!-- Delete button: Submits a form to delete the product category (with confirmation) -->
            <form action="{{ route('productcategories.destroy', $category['pc_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product category?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </x-button>
            </form>
        </div>
    </div>
    <!--
        Main content: Two-column layout with category information, titles, descriptions, and image.
    -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <!--
                Card with product category information: ID and other details.
            -->
            <x-card title="Product Category Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $category['pc_id'] }}</p>
                    </div>
                </div>
            </x-card>
            <!--
                Card with titles and descriptions in both Indonesian and English.
            -->
            <x-card title="Judul & Deskripsi" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <!-- Indonesian title and description -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (Indonesian)</h4>
                        <p>{{ $category['pc_title_id'] }}</p>
                        <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (Indonesian)</h4>
                        <p>{!! nl2br(e($category['pc_description_id'] ?? '-')) !!}</p>
                    </div>
                    <div>
                        <!-- English title and description -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (English)</h4>
                        <p>{{ $category['pc_title_en'] }}</p>
                        <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (English)</h4>
                        <p>{!! nl2br(e($category['pc_description_en'] ?? '-')) !!}</p>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="lg:col-span-1">
            <!--
                Card with product category image: Shows the image if available.
            -->
            <x-card title="Image">
                @if(!empty($category['pc_image']))
                    <div class="mb-4">
                        <img src="{{ $category['pc_image'] }}" alt="{{ $category['pc_title_id'] }}" class="w-full rounded-md">
                    </div>
                @endif
            </x-card>
        </div>
    </div>
@endsection
