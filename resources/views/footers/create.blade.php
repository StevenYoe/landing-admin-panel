@extends('layouts.app')

@section('title', 'Add Footer - Pazar Website Admin')

@section('page-title', 'Add Footer')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('footers.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('footers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="f_type" 
                        label="Footer Type" 
                        placeholder="Enter footer type" 
                        :value="old('f_type')"
                        required
                        helper="Example: link, social, contact, etc. Maximum 50 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <label for="f_icon" class="block text-sm font-medium mb-2">Icon</label>
                    <input type="file" name="f_icon" id="f_icon" accept="image/svg+xml,image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload SVG, JPG, PNG, atau GIF. <b>Preffered SVG</b> (max 2MB)</p>
                </div>
                
                <div>
                    <x-form.input 
                        name="f_label_id" 
                        label="Label (Indonesian)" 
                        placeholder="Enter label in Indonesian" 
                        :value="old('f_label_id')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="f_label_en" 
                        label="Label (English)" 
                        placeholder="Enter label in English" 
                        :value="old('f_label_en')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.input 
                        name="f_link" 
                        label="Link" 
                        placeholder="Enter link (URL)" 
                        :value="old('f_link')"
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.textarea 
                        name="f_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('f_description_id')"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.textarea 
                        name="f_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('f_description_en')"
                        rows="4"
                    />
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('footers.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection