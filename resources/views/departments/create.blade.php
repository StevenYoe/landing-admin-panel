<!--
    Department Create Page (create.blade.php)
    ------------------------------------------------
    This Blade template renders the form for adding a new Department entry in the Pazar Website Admin panel.
    - Extends the main app layout for consistent styling.
    - Provides a back button to return to the Department list.
    - Contains form fields for department titles in Indonesian and English.
    - Uses custom Blade components for form inputs and buttons.
    - Submits the form data to the 'departments.store' route for processing.
-->

@extends('layouts.app')

@section('title', 'Add Department - Pazar Website Admin')

@section('page-title', 'Add Department')

@section('content')
    <div class="mb-6">
        <!-- Back button to return to the Department list -->
        <x-button href="{{ route('departments.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <!-- Form for creating a new Department entry -->
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Indonesian title input -->
                    <x-form.input 
                        name="da_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('da_title_id')"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
                
                <div>
                    <!-- English title input -->
                    <x-form.input 
                        name="da_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('da_title_en')"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button returns to the Department list -->
                <x-button type="button" href="{{ route('departments.index') }}" variant="outline">
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