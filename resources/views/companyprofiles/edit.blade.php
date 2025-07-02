<!--
    Company Profile Edit Page (edit.blade.php)
    ------------------------------------------------
    This Blade template renders the form for editing an existing Company Profile entry in the Pazar Website Admin panel.
    - Extends the main app layout for consistent styling.
    - Provides a back button to return to the Company Profile list.
    - Contains form fields for profile type and descriptions in Indonesian and English, pre-filled with existing data.
    - Uses custom Blade components for form inputs and buttons.
    - Submits the form data to the 'companyprofiles.update' route for processing.
-->

@extends('layouts.app')

@section('title', 'Edit Company Profile - Pazar Website Admin')

@section('page-title', 'Edit Company Profile')

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
        <!-- Form for editing an existing Company Profile entry -->
        <form action="{{ route('companyprofiles.update', $companyProfile['cp_id']) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <!-- Profile type input, pre-filled with existing data -->
                    <x-form.input 
                        name="cp_type" 
                        label="Profile Type" 
                        placeholder="Enter profile type" 
                        :value="old('cp_type', $companyProfile['cp_type'])"
                        required
                        helper="Maximum 50 characters"
                    />
                </div>
                
                <div>
                    <!-- Indonesian description textarea, pre-filled with existing data -->
                    <x-form.textarea 
                        name="cp_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('cp_description_id', $companyProfile['cp_description_id'])"
                        required
                        rows="6"
                    />
                </div>
                
                <div>
                    <!-- English description textarea, pre-filled with existing data -->
                    <x-form.textarea 
                        name="cp_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('cp_description_en', $companyProfile['cp_description_en'])"
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
                <!-- Update button submits the form -->
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection