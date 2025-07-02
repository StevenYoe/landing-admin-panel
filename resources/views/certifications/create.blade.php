<!--
    Certification Create Page (create.blade.php)
    ------------------------------------------------
    This Blade template renders the form for adding a new Certification entry in the Pazar Website Admin panel.
    - Extends the main app layout for consistent styling.
    - Provides a back button to return to the Certification list.
    - Contains form fields for Indonesian and English labels, titles, and descriptions.
    - Includes an image upload field with file type and size instructions.
    - Uses custom Blade components for form inputs and buttons.
    - Submits the form data to the 'certifications.store' route for processing.
-->

@extends('layouts.app')

@section('title', 'Add Certification - Pazar Website Admin')

@section('page-title', 'Add Certification')

@section('content')
    <div class="mb-6">
        <!-- Back button to return to the Certification list -->
        <x-button href="{{ route('certifications.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <!-- Form for creating a new Certification entry -->
        <form action="{{ route('certifications.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Indonesian label input -->
                    <x-form.input 
                        name="c_label_id" 
                        label="Label (Indonesian)" 
                        placeholder="Enter label in Indonesian" 
                        :value="old('c_label_id')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <!-- English label input -->
                    <x-form.input 
                        name="c_label_en" 
                        label="Title (English)" 
                        placeholder="Enter label in English" 
                        :value="old('c_label_en')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <!-- Indonesian title input -->
                    <x-form.input 
                        name="c_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('c_title_id')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <!-- English title input -->
                    <x-form.input 
                        name="c_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('c_title_en')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Indonesian description textarea -->
                    <x-form.textarea 
                        name="c_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('c_description_id')"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- English description textarea -->
                    <x-form.textarea 
                        name="c_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('c_description_en')"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Image upload field for Certification -->
                    <label for="c_image" class="block text-sm font-medium mb-2">Certification Image</label>
                    <input type="file" name="c_image" id="c_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <!-- File type and size instructions for the user -->
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button returns to the Certification list -->
                <x-button type="button" href="{{ route('certifications.index') }}" variant="outline">
                    Cancel
                </x-button>
                <!-- Save button submits the form -->
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection