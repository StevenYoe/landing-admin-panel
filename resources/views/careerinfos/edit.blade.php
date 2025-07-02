<!--
    Career Info Edit Page (edit.blade.php)
    ------------------------------------------------
    This Blade template renders the form for editing an existing Career Info entry in the Pazar Website Admin panel.
    - Extends the main app layout for consistent styling.
    - Provides a back button to return to the Career Info list.
    - Contains form fields for Indonesian and English titles and descriptions, pre-filled with existing data.
    - Includes an image upload field and displays the current image if available.
    - Uses custom Blade components for form inputs and buttons.
    - Submits the form data to the 'careerinfos.update' route for processing.
-->

@extends('layouts.app')

@section('title', 'Edit Career Info - Pazar Website Admin')

@section('page-title', 'Edit Career Info')

@section('content')
    <div class="mb-6">
        <!-- Back button to return to the Career Info list -->
        <x-button href="{{ route('careerinfos.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <!-- Form for editing an existing Career Info entry -->
        <form action="{{ route('careerinfos.update', $careerInfo['ci_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Indonesian title input, pre-filled with existing data -->
                    <x-form.input 
                        name="ci_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('ci_title_id', $careerInfo['ci_title_id'])"
                        required
                    />
                </div>
                
                <div>
                    <!-- English title input, pre-filled with existing data -->
                    <x-form.input 
                        name="ci_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('ci_title_en', $careerInfo['ci_title_en'])"
                        required
                    />
                </div>
                
                <div>
                    <!-- Indonesian description textarea, pre-filled with existing data -->
                    <x-form.textarea 
                        name="ci_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('ci_description_id', $careerInfo['ci_description_id'])"
                        rows="4"
                        required
                    />
                </div>
                
                <div>
                    <!-- English description textarea, pre-filled with existing data -->
                    <x-form.textarea 
                        name="ci_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('ci_description_en', $careerInfo['ci_description_en'])"
                        rows="4"
                        required
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Image upload field for Career Info -->
                    <label for="ci_image" class="block text-sm font-medium mb-2">Career Info Image</label>
                    <input type="file" name="ci_image" id="ci_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <!-- File type and size instructions for the user -->
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                    
                    @if(!empty($careerInfo['ci_image']))
                        <!-- Display the current Career Info image if available -->
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Current Career Info Image:</p>
                            <img src="{{ $careerInfo['ci_image'] }}" alt="Career Info Image" class="h-32 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button returns to the Career Info list -->
                <x-button type="button" href="{{ route('careerinfos.index') }}" variant="outline">
                    Cancel
                </x-button>
                <!-- Update button submits the form -->
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection