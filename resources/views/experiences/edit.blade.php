<!--
    Edit Experience Level Page
    This Blade view provides a form to edit an existing experience level in the system.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'Edit Experience Level - Pazar Website Admin')

@section('page-title', 'Edit Experience Level')

@section('content')
    <!-- Header section with Back to List button -->
    <div class="mb-6">
        <x-button href="{{ route('experiences.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card component containing the experience level edit form -->
    <x-card>
        <!-- Form to update existing experience level data -->
        <form action="{{ route('experiences.update', $experience['ex_id']) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Input fields for experience level titles in Indonesian and English -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Input for Indonesian title -->
                    <x-form.input 
                        name="ex_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('ex_title_id', $experience['ex_title_id'])"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
                
                <div>
                    <!-- Input for English title -->
                    <x-form.input 
                        name="ex_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('ex_title_en', $experience['ex_title_en'])"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
            </div>
            
            <!-- Action buttons: Cancel and Update -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button returns to experience level list -->
                <x-button type="button" href="{{ route('experiences.index') }}" variant="outline">
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