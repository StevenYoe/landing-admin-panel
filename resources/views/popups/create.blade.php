<!--
    Add Popup Page
    This Blade view provides a form for creating a new popup in the admin panel.
    Includes fields for popup link and image upload, and uses custom Blade components for UI consistency.
-->
@extends('layouts.app')

@section('title', 'Add Popup - Pazar Website Admin')

@section('page-title', 'Add Popup')

@section('content')
    <!--
        Back to List button: Navigates back to the list of popups.
    -->
    <div class="mb-6">
        <x-button href="{{ route('popups.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!--
        Card container for the popup creation form.
    -->
    <x-card>
        <!--
            Form to create a new popup.
            Submits to the popups.store route using POST method.
            enctype="multipart/form-data" allows image upload.
        -->
        <form action="{{ route('popups.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!--
                Form fields are organized in a responsive grid.
            -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <!--
                        Input for popup link (URL).
                        Uses a custom Blade input component.
                    -->
                    <x-form.input 
                        name="pu_link" 
                        label="Link" 
                        placeholder="Enter link (URL)" 
                        :value="old('pu_link')"
                        helper="Maximum 255 characters"
                    />
                </div>
                <!--
                    Hidden field to always set pu_is_active as false for new popups.
                -->
                <input type="hidden" name="pu_is_active" value="0">
                <div class="md:col-span-2">
                    <!--
                        File input for popup image upload.
                        Accepts image files only.
                    -->
                    <label for="pu_image" class="block text-sm font-medium mb-2">Pop Up Image</label>
                    <input type="file" name="pu_image" id="pu_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                </div>
            </div>
            <!--
                Action buttons: Cancel returns to the list, Save submits the form.
            -->
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('popups.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
