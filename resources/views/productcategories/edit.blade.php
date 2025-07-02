<!--
    Edit Product Category Page
    This Blade view provides a form for editing an existing product category in the admin panel.
    Includes fields for titles, descriptions, and image upload, using custom Blade components for UI consistency.
-->
@extends('layouts.app')

@section('title', 'Edit Product Category - Pazar Website Admin')

@section('page-title', 'Edit Product Category')

@section('content')
    <!--
        Back to List button: Navigates back to the product category list page.
    -->
    <div class="mb-6">
        <x-button href="{{ route('productcategories.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    <!--
        Card container for the product category edit form.
    -->
    <x-card>
        <!--
            Form to update an existing product category.
            Submits to the productcategories.update route using PUT method.
            enctype="multipart/form-data" allows image upload.
        -->
        <form action="{{ route('productcategories.update', $category['pc_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--
                Form fields are organized in a responsive grid.
            -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Input for Indonesian title -->
                    <x-form.input 
                        name="pc_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian"  
                        :value="old('pc_title_id', $category['pc_title_id'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                <div>
                    <!-- Input for English title -->
                    <x-form.input 
                        name="pc_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('pc_title_en', $category['pc_title_en'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                <div class="md:col-span-2">
                    <!-- Textarea for Indonesian description -->
                    <x-form.textarea 
                        name="pc_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('pc_description_id', $category['pc_description_id'])"
                        rows="4"
                    />
                </div>
                <div class="md:col-span-2">
                    <!-- Textarea for English description -->
                    <x-form.textarea 
                        name="pc_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('pc_description_en', $category['pc_description_en'])"
                        rows="4"
                    />
                </div>
                <div class="md:col-span-2">
                    <!--
                        File input for product category image upload.
                        Accepts image files only. Shows current image if available.
                    -->
                    <label for="pc_image" class="block text-sm font-medium mb-2">Product Category Image</label>
                    <input type="file" name="pc_image" id="pc_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                    @if(!empty($category['pc_image']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Current Product Category Image:</p>
                            <img src="{{ $category['pc_image'] }}" alt="Category Image" class="h-32 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            <!--
                Action buttons: Cancel returns to the list, Update submits the form.
            -->
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('productcategories.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
