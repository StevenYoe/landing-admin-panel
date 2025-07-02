<!--
    Add Why Pazar Page
    This Blade view provides a form for adding a new 'Why Pazar' entry in the admin panel.
    Comments are provided throughout to explain the structure and logic for future developers.
-->
@extends('layouts.app')

@section('title', 'Add Why Pazar - Pazar Website Admin')

@section('page-title', 'Add Why Pazar')

@section('content')
    <!-- Back to List Button: Navigates back to the Why Pazar list page -->
    <div class="mb-6">
        <x-button href="{{ route('whypazars.index') }}" variant="outline">
            <!-- Left Arrow Icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card Container for the Add Why Pazar Form -->
    <x-card>
        <!-- Add Why Pazar Form: Submits new entry data -->
        <form action="{{ route('whypazars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Main Fields (Grid Layout) -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Title in Indonesian -->
                <div>
                    <x-form.input 
                        name="w_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('w_title_id')"
                        required
                    />
                </div>
                <!-- Title in English -->
                <div>
                    <x-form.input 
                        name="w_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('w_title_en')"
                        required
                    />
                </div>
                <!-- Description in Indonesian -->
                <div>
                    <x-form.textarea 
                        name="w_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('w_description_id')"
                        rows="4"
                    />
                </div>
                <!-- Description in English -->
                <div>
                    <x-form.textarea 
                        name="w_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('w_description_en')"
                        rows="4"
                    />
                </div>
                <!-- Image Upload Field -->
                <div class="md:col-span-2">
                    <label for="w_image" class="block text-sm font-medium mb-2">Why Pazar Image</label>
                    <input type="file" name="w_image" id="w_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                </div>
            </div>
            
            <!-- Form Action Buttons -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel Button: Returns to Why Pazar list without saving -->
                <x-button type="button" href="{{ route('whypazars.index') }}" variant="outline">
                    Cancel
                </x-button>
                <!-- Save Button: Submits the form to create a new Why Pazar entry -->
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection