<!--
    Edit Work At Pazar Page
    This Blade view provides a form for editing an existing 'Work At Pazar' entry in the admin panel.
    Comments are provided throughout to explain the structure and logic for future developers.
-->
@extends('layouts.app')

@section('title', 'Edit Work At Pazar - Pazar Website Admin')

@section('page-title', 'Edit Work At Pazar')

@section('content')
    <!-- Back to List Button: Navigates back to the Work At Pazar list page -->
    <div class="mb-6">
        <x-button href="{{ route('workatpazars.index') }}" variant="outline">
            <!-- Left Arrow Icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card Container for the Edit Work At Pazar Form -->
    <x-card>
        <!-- Edit Work At Pazar Form: Submits updated entry data -->
        <form action="{{ route('workatpazars.update', $workAtPazar['wap_id']) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Main Fields (Grid Layout) -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Title in Indonesian -->
                <div>
                    <x-form.input 
                        name="wap_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('wap_title_id', $workAtPazar['wap_title_id'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                <!-- Title in English -->
                <div>
                    <x-form.input 
                        name="wap_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English"
                        :value="old('wap_title_en', $workAtPazar['wap_title_en'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                <!-- Description in Indonesian (Optional) -->
                <div>
                    <x-form.textarea 
                        name="wap_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian (Optional)" 
                        :value="old('wap_description_id', $workAtPazar['wap_description_id'])"
                        rows="4"
                    />
                </div>
                <!-- Description in English (Optional) -->
                <div>
                    <x-form.textarea 
                        name="wap_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English (Optional)" 
                        :value="old('wap_description_en', $workAtPazar['wap_description_en'])"
                        rows="4"
                    />
                </div>
                <!-- Type Field -->
                <div class="md:col-span-2">
                    <x-form.input 
                        name="wap_type" 
                        label="Type" 
                        placeholder="Enter Work At Pazar Type" 
                        :value="old('wap_type', $workAtPazar['wap_type'])"
                        required
                    />
                </div>
            </div>
            
            <!-- Form Action Buttons -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel Button: Returns to Work At Pazar list without saving -->
                <x-button type="button" href="{{ route('workatpazars.index') }}" variant="outline">
                    Cancel
                </x-button>
                <!-- Update Button: Submits the form to update the Work At Pazar entry -->
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection