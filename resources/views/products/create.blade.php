@extends('layouts.app')

@section('title', 'Add Product - Pazar Website Admin')

@section('page-title', 'Add Product')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('products.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="p_title_id" 
                        label="Product Name (Indonesia)" 
                        placeholder="Enter product name in Indonesian" 
                        :value="old('p_title_id')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="p_title_en" 
                        label="Product Name (English)" 
                        placeholder="Enter product name in English" 
                        :value="old('p_title_en')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <x-form.select 
                        name="p_id_product_category" 
                        label="Product Category" 
                        :options="collect($categories)->pluck('pc_title_id', 'pc_id')->toArray()" 
                        :selected="old('p_id_product_category')"
                        placeholder="Select Category"
                        required
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.textarea 
                        name="p_description_id" 
                        label="Description (Indonesia)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('p_description_id')"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.textarea 
                        name="p_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('p_description_en')"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <label for="p_image" class="block text-sm font-medium mb-2">Gambar Produk</label>
                    <input type="file" name="p_image" id="p_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                </div>
                
                <!-- Hidden field to always set p_is_active as true for new products -->
                <input type="hidden" name="p_is_active" value="1">
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('products.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
