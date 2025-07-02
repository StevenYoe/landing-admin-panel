<!--
    Edit Product Catalog Page
    This Blade view provides a form for updating existing product catalog files (Indonesian and English) in the admin panel.
    Includes file upload fields, current file previews, and uses custom Blade components for UI consistency.
-->
@extends('layouts.app')

@section('title', 'Edit Product Catalog - Pazar Website Admin')

@section('page-title', 'Edit Product Catalog')

@section('content')
    <!--
        Back to List button: Navigates back to the product catalog list page.
    -->
    <div class="mb-6">
        <x-button href="{{ route('productcatalogs.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    <!--
        Card container for the product catalog edit form.
    -->
    <x-card>
        <!--
            Form to update product catalog files.
            Submits to the productcatalogs.update route using PUT method.
            enctype="multipart/form-data" allows file uploads.
        -->
        <form action="{{ route('productcatalogs.update', $catalog['pct_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--
                Form fields are organized in a responsive grid.
            -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <!--
                        File input for Indonesian catalog file upload.
                        Accepts PDF, DOC, DOCX, or image files.
                        Shows validation error if present and current file preview if available.
                    -->
                    <label for="pct_catalog_id" class="block text-sm font-medium mb-2">Indonesian Catalog File</label>
                    <input type="file" name="pct_catalog_id" id="pct_catalog_id" 
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload PDF, DOC, DOCX, or image files (max 50MB)</p>
                    @error('pct_catalog_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    @if(!empty($catalog['pct_catalog_id']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Current Indonesian Catalog:</p>
                            <a href="{{ $catalog['pct_catalog_id'] }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-blue-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View Current File
                            </a>
                        </div>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <!--
                        File input for English catalog file upload.
                        Accepts PDF, DOC, DOCX, or image files.
                        Shows validation error if present and current file preview if available.
                    -->
                    <label for="pct_catalog_en" class="block text-sm font-medium mb-2">English Catalog File</label>
                    <input type="file" name="pct_catalog_en" id="pct_catalog_en" 
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload PDF, DOC, DOCX, or image files (max 50MB)</p>
                    @error('pct_catalog_en')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    @if(!empty($catalog['pct_catalog_en']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Current English Catalog:</p>
                            <a href="{{ $catalog['pct_catalog_en'] }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-blue-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View Current File
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <!--
                Action buttons: Cancel returns to the list, Update submits the form.
            -->
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('productcatalogs.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection