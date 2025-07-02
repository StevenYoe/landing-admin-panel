<!--
    Edit Recipe Category Page
    This Blade view provides a form for editing an existing recipe category.
    Each section, form, field, and button is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Edit Recipe Category - Pazar Website Admin')

@section('page-title', 'Edit Recipe Category')

@section('content')
    <!-- Top bar with Back to List button -->
    <div class="mb-6">
        <x-button href="{{ route('recipecategories.index') }}" variant="outline">
            <!-- Back icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card container for the edit form -->
    <x-card>
        <!-- Form to update an existing recipe category -->
        <form action="{{ route('recipecategories.update', $category['rc_id']) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Input fields for recipe category titles in two languages -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Title in Indonesian -->
                    <x-form.input 
                        name="rc_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('rc_title_id', $category['rc_title_id'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <!-- Title in English -->
                    <x-form.input 
                        name="rc_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('rc_title_en', $category['rc_title_en'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
            </div>
            
            <!-- Action buttons: Cancel and Update -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button: returns to the list -->
                <x-button type="button" href="{{ route('recipecategories.index') }}" variant="outline">
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