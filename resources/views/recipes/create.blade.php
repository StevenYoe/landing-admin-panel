@extends('layouts.app')

@section('title', 'Add Recipe - Pazar Website Admin')

@section('page-title', 'Add Recipe')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('recipes.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="r_title_id" 
                        label="Recipe Name (Indonesia)" 
                        placeholder="Enter recipe name in Indonesian" 
                        :value="old('r_title_id')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="r_title_en" 
                        label="Recipe Name (English)" 
                        placeholder="Enter recipe name in English" 
                        :value="old('r_title_en')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Categories</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($categories as $category)
                            <label class="inline-flex items-center bg-gray-800 p-3 rounded-md">
                                <input type="checkbox" name="category_ids[]" value="{{ $category['rc_id'] }}" 
                                    {{ in_array($category['rc_id'], old('category_ids', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 text-accent border-gray-600 focus:ring-accent focus:ring-opacity-50">
                                <span class="ml-2">{{ $category['rc_title_id'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('category_ids')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Hidden field to set r_is_active as true for new recipes -->
                <input type="hidden" name="r_is_active" value="1">
                
                <div class="md:col-span-2">
                    <label for="r_image" class="block text-sm font-medium mb-2">Recipe Image</label>
                    <input type="file" name="r_image" id="r_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('recipes.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection