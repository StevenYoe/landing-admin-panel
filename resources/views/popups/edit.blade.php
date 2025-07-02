<!--
    Edit Popup Page
    This Blade view provides a form for editing an existing popup in the admin panel.
    Includes fields for popup link, status, and image upload, and uses custom Blade components for UI consistency.
-->
@extends('layouts.app')

@section('title', 'Edit Popup - Pazar Website Admin')

@section('page-title', 'Edit Popup')

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
        Card container for the popup edit form.
    -->
    <x-card>
        <!--
            Form to update an existing popup.
            Submits to the popups.update route using PUT method.
            enctype="multipart/form-data" allows image upload.
        -->
        <form action="{{ route('popups.update', $popup['pu_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                        :value="old('pu_link', $popup['pu_link'])"
                        helper="Maximum 255 characters"
                    />
                </div>
                <div class="md:col-span-2">
                    <!--
                        Radio buttons for popup status (Active/Inactive).
                        Allows admin to set whether the popup is enabled.
                    -->
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pu_is_active" value="1" {{ old('pu_is_active', $popup['pu_is_active']) == '1' ? 'checked' : '' }}
                                class="w-4 h-4 text-accent border-gray-600 focus:ring-accent focus:ring-opacity-50">
                            <span class="ml-2">Active</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pu_is_active" value="0" {{ old('pu_is_active', $popup['pu_is_active']) == '0' ? 'checked' : '' }}
                                class="w-4 h-4 text-accent border-gray-600 focus:ring-accent focus:ring-opacity-50">
                            <span class="ml-2">Inactive</span>
                        </label>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <!--
                        File input for popup image upload.
                        Accepts image files only. Shows current image if available.
                    -->
                    <label for="pu_image" class="block text-sm font-medium mb-2">Pop Up Image</label>
                    <input type="file" name="pu_image" id="pu_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                    @if(!empty($popup['pu_image']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Current Pop Up Image:</p>
                            <img src="{{ $popup['pu_image'] }}" alt="Popup Image" class="h-32 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            <!--
                Action buttons: Cancel returns to the list, Update submits the form.
            -->
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('popups.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
