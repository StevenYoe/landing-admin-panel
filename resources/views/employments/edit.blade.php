<!--
    Edit Employment Type Page
    This Blade view provides a form to edit an existing employment type in the system.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'Edit Employment Type - Pazar Website Admin')

@section('page-title', 'Edit Employment Type')

@section('content')
    <!-- Header section with Back to List button -->
    <div class="mb-6">
        <x-button href="{{ route('employments.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card component containing the employment type edit form -->
    <x-card>
        <!-- Form to update existing employment type data -->
        <form action="{{ route('employments.update', $employment['e_id']) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Input fields for employment type titles in Indonesian and English -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Input for Indonesian title -->
                    <x-form.input 
                        name="e_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('e_title_id', $employment['e_title_id'])"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
                
                <div>
                    <!-- Input for English title -->
                    <x-form.input 
                        name="e_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('e_title_en', $employment['e_title_en'])"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
            </div>
            
            <!-- Action buttons: Cancel and Update -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button returns to employment type list -->
                <x-button type="button" href="{{ route('employments.index') }}" variant="outline">
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