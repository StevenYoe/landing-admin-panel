@extends('layouts.app')

@section('title', 'Add Product Catalog - Pazar Website Admin')

@section('page-title', 'Add Product Catalog')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('productcatalogs.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('productcatalogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
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
                </div>
                
                <div class="md:col-span-2">
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
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('productcatalogs.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection