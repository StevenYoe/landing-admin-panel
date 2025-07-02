<!--
    Company Profile Create Page (create.blade.php)
    ------------------------------------------------
    This Blade template renders the form for adding a new Company Profile entry in the Pazar Website Admin panel.
    - Extends the main app layout for consistent styling.
    - Provides a back button to return to the Company Profile list.
    - Contains form fields for profile type and descriptions in Indonesian and English.
    - Uses custom Blade components for form inputs and buttons.
    - Submits the form data to the 'companyprofiles.store' route for processing.
-->

@extends('layouts.app')

@section('title', 'Add Company Profile - Pazar Website Admin')

@section('page-title', 'Add Company Profile')

@section('content')
    <div class="mb-6">
        <!-- Back button to return to the Company Profile list -->
        <x-button href="{{ route('companyprofiles.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <!-- Form for creating a new Company Profile entry -->
        <form action="{{ route('companyprofiles.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <!-- Profile type input -->
                    <x-form.input 
                        name="cp_type" 
                        label="Profile Type" 
                        placeholder="Enter profile type" 
                        :value="old('cp_type')"
                        required
                        helper="Maximum 50 characters"
                    />
                </div>
                
                <div>
                    <!-- Indonesian description textarea -->
                    <x-form.textarea 
                        name="cp_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('cp_description_id')"
                        required
                        rows="6"
                    />
                </div>
                
                <div>
                    <!-- English description textarea -->
                    <x-form.textarea 
                        name="cp_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('cp_description_en')"
                        required
                        rows="6"
                    />
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button returns to the Company Profile list -->
                <x-button type="button" href="{{ route('companyprofiles.index') }}" variant="outline">
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