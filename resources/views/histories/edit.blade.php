@extends('layouts.app')

@section('title', 'Edit History - Pazar Website Admin')

@section('page-title', 'Edit History')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('histories.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('histories.update', $history['hs_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <x-form.input 
                        name="hs_year" 
                        label="Year" 
                        placeholder="Enter Year" 
                        :value="old('hs_year', $history['hs_year'])"
                        required
                        helper="Maximum 50 characters"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="hs_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('hs_description_id', $history['hs_description_id'])"
                        required
                        rows="4"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="hs_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('hs_description_en', $history['hs_description_en'])"
                        required
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <label for="hs_image" class="block text-sm font-medium mb-2">History Image</label>
                    <input type="file" name="hs_image" id="hs_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload Webp, JPG, PNG, or GIF. <b>Preferred Webp</b> (max 5MB)</p>
                    
                    @if(!empty($history['hs_image']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Current History Image:</p>
                            <img src="{{ $history['hs_image'] }}" alt="History Image" class="h-32 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('histories.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection