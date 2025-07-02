<!--
    Edit Recipe Page
    This Blade view provides a form for editing an existing recipe, including name, categories, status, and image.
    Each section, form, field, and button is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Edit Recipe - Pazar Website Admin')

@section('page-title', 'Edit Recipe')

@section('content')
    <!-- Top bar with Back to List button -->
    <div class="mb-6">
        <x-button href="{{ route('recipes.index') }}" variant="outline">
            <!-- Back icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card container for the edit form -->
    <x-card>
        <!-- Form to update an existing recipe -->
        <form action="{{ route('recipes.update', $recipe['r_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Input fields for recipe name, categories, status, and image -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Recipe name in Indonesian -->
                    <x-form.input 
                        name="r_title_id" 
                        label="Recipe Name (Indonesia)" 
                        placeholder="Enter recipe name in Indonesian" 
                        :value="old('r_title_id', $recipe['r_title_id'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <!-- Recipe name in English -->
                    <x-form.input 
                        name="r_title_en" 
                        label="Recipe Name (English)" 
                        placeholder="Enter recipe name in English" 
                        :value="old('r_title_en', $recipe['r_title_en'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Category selection checkboxes -->
                    <label class="block text-sm font-medium mb-2">Categories</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($categories as $category)
                            <!-- Checkbox for each category -->
                            <label class="inline-flex items-center bg-gray-800 p-3 rounded-md">
                                <input type="checkbox" name="category_ids[]" value="{{ $category['rc_id'] }}" 
                                    {{ in_array($category['rc_id'], old('category_ids', $selectedCategories)) ? 'checked' : '' }}
                                    class="w-4 h-4 text-accent border-gray-600 focus:ring-accent focus:ring-opacity-50">
                                <span class="ml-2">{{ $category['rc_title_id'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('category_ids')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <!-- Status radio buttons -->
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <div class="flex items-center space-x-4">
                        <!-- Active status -->
                        <label class="inline-flex items-center">
                            <input type="radio" name="r_is_active" value="1" {{ old('r_is_active', $recipe['r_is_active']) == '1' ? 'checked' : '' }}
                                class="w-4 h-4 text-accent border-gray-600 focus:ring-accent focus:ring-opacity-50">
                            <span class="ml-2">Active</span>
                        </label>
                        <!-- Inactive status -->
                        <label class="inline-flex items-center">
                            <input type="radio" name="r_is_active" value="0" {{ old('r_is_active', $recipe['r_is_active']) == '0' ? 'checked' : '' }}
                                class="w-4 h-4 text-accent border-gray-600 focus:ring-accent focus:ring-opacity-50">
                            <span class="ml-2">Inactive</span>
                        </label>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <!-- Recipe image upload field -->
                    <label for="r_image" class="block text-sm font-medium mb-2">Recipe Image</label>
                    <input type="file" name="r_image" id="r_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                    
                    @if(!empty($recipe['r_image']))
                        <!-- Display current recipe image if exists -->
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Current Recipe Image:</p>
                            <img src="{{ $recipe['r_image'] }}" alt="Recipe Image" class="h-40 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Action buttons: Cancel and Update -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button: returns to the list -->
                <x-button type="button" href="{{ route('recipes.index') }}" variant="outline">
                    Cancel
                </x-button>
                <!-- Update button: submits the form -->
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection