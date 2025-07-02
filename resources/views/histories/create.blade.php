<!--
    Add History Page
    This Blade view provides a form to add a new history entry to the system.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'Add History - Pazar Website Admin')

@section('page-title', 'Add History')

@section('content')
    <!-- Header section with Back to List button -->
    <div class="mb-6">
        <x-button href="{{ route('histories.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card component containing the history creation form -->
    <x-card>
        <!-- Form to submit new history data, including file upload -->
        <form action="{{ route('histories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Input fields for year, descriptions, and image -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <!-- Input for year -->
                    <x-form.input 
                        name="hs_year" 
                        label="Year" 
                        placeholder="Enter Year" 
                        :value="old('hs_year')"
                        required
                        helper="Maximum 50 characters"
                    />
                </div>
                
                <div>
                    <!-- Textarea for description in Indonesian -->
                    <x-form.textarea 
                        name="hs_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('hs_description_id')"
                        required
                        rows="4"
                    />
                </div>
                
                <div>
                    <!-- Textarea for description in English -->
                    <x-form.textarea 
                        name="hs_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('hs_description_en')"
                        required
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- File input for history image (Webp, JPG, PNG, GIF) -->
                    <label for="hs_image" class="block text-sm font-medium mb-2">History Image</label>
                    <input type="file" name="hs_image" id="hs_image" accept="image/*"
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
                <!-- Cancel button returns to history list -->
                <x-button type="button" href="{{ route('histories.index') }}" variant="outline">
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