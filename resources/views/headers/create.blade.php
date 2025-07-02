<!--
    Add Header Page
    This Blade view provides a form to add a new header entry to the system.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'Add Header - Pazar Website Admin')

@section('page-title', 'Add Header')

@section('content')
    <!-- Header section with Back to List button -->
    <div class="mb-6">
        <x-button href="{{ route('headers.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card component containing the header creation form -->
    <x-card>
        <!-- Form to submit new header data, including file upload -->
        <form action="{{ route('headers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Input fields for header titles, descriptions, page name, and image -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Textarea for title in Indonesian -->
                    <x-form.textarea 
                        name="h_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('h_title_id')"
                        required
                        rows="4"
                    />
                </div>
                
                <div>
                    <!-- Textarea for title in English -->
                    <x-form.textarea 
                        name="h_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('h_title_en')"
                        required
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Input for description in Indonesian -->
                    <x-form.input 
                        name="h_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('h_description_id')"
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Input for description in English -->
                    <x-form.input 
                        name="h_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('h_description_en')"
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Input for page name -->
                    <x-form.input 
                        name="h_page_name" 
                        label="Page Name" 
                        placeholder="Enter Page Name" 
                        :value="old('h_page_name')"
                        required
                        helper="Maximum 50 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- File input for header image (Webp, JPG, PNG, GIF) -->
                    <label for="h_image" class="block text-sm font-medium mb-2">Header Image</label>
                    <input type="file" name="h_image" id="h_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                </div>
            </div>
            
            <!-- Action buttons: Cancel and Save -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button returns to header list -->
                <x-button type="button" href="{{ route('headers.index') }}" variant="outline">
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
