<!--
    Add Testimonial Page
    This Blade view provides a form for creating a new testimonial, including name, type, descriptions, gender, product info, link, and image.
    Each section, form, field, and button is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Add Testimonial - Pazar Website Admin')

@section('page-title', 'Add Testimonial')

@section('content')
    <!-- Top bar with Back to List button -->
    <div class="mb-6">
        <x-button href="{{ route('testimonials.index') }}" variant="outline">
            <!-- Back icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card container for the create form -->
    <x-card>
        <!-- Form to add a new testimonial -->
        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Input fields for testimonial details -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Name field -->
                    <x-form.input 
                        name="t_name" 
                        label="Name" 
                        placeholder="Enter name" 
                        :value="old('t_name')"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
                
                <div>
                    <!-- Type field -->
                    <x-form.input 
                        name="t_type" 
                        label="Type" 
                        placeholder="Enter testimonial type" 
                        :value="old('t_type')"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
                
                <div>
                    <!-- Description in Indonesian -->
                    <x-form.textarea 
                        name="t_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('t_description_id')"
                        required
                        rows="4"
                    />
                </div>
                
                <div>
                    <!-- Description in English -->
                    <x-form.textarea 
                        name="t_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('t_description_en')"
                        required
                        rows="4"
                    />
                </div>
                
                <div>
                    <!-- Product name in Indonesian -->
                    <x-form.input 
                        name="t_product_id" 
                        label="Product Name (Indonesian)" 
                        placeholder="Enter product name in Indonesian" 
                        :value="old('t_product_id')"
                        helper="Maximum 255 characters (optional)"
                    />
                </div>
                
                <div>
                    <!-- Product name in English -->
                    <x-form.input 
                        name="t_product_en" 
                        label="Product Name (English)" 
                        placeholder="Enter product name in English" 
                        :value="old('t_product_en')"
                        helper="Maximum 255 characters (optional)"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Link field -->
                    <x-form.input 
                        name="t_link" 
                        label="Link" 
                        placeholder="Enter testimonial link" 
                        :value="old('t_link')"
                        helper="Maximum 255 characters (optional)"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <!-- Gender radio buttons -->
                    <label class="block text-sm font-medium mb-2">Gender</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <!-- Male option -->
                            <input id="t_gender_male" name="t_gender" type="radio" value="Male" class="h-4 w-4 text-accent focus:ring-accent-light border-gray-600" {{ old('t_gender') == 'Male' ? 'checked' : '' }} required>
                            <label for="t_gender_male" class="ml-2 block text-sm font-medium">
                                Male
                            </label>
                        </div>
                        <div class="flex items-center">
                            <!-- Female option -->
                            <input id="t_gender_female" name="t_gender" type="radio" value="Female" class="h-4 w-4 text-accent focus:ring-accent-light border-gray-600" {{ old('t_gender') == 'Female' ? 'checked' : '' }}>
                            <label for="t_gender_female" class="ml-2 block text-sm font-medium">
                                Female
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <!-- Testimonial image upload field -->
                    <label for="t_image" class="block text-sm font-medium mb-2">Testimonial Image</label>
                    <input type="file" name="t_image" id="t_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                </div>
            </div>
            
            <!-- Action buttons: Cancel and Save -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button: returns to the list -->
                <x-button type="button" href="{{ route('testimonials.index') }}" variant="outline">
                    Cancel
                </x-button>
                <!-- Save button: submits the form -->
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection