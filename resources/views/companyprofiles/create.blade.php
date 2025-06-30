@extends('layouts.app')

@section('title', 'Add Company Profile - Pazar Website Admin')

@section('page-title', 'Add Company Profile')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('companyprofiles.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('companyprofiles.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <x-form.input 
                        name="cp_type" 
                        label="Profile Type" 
                        placeholder="Enter profile type" 
                        :value="old('cp_type')"
                        required
                        helper="Maximum 50 characters"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="cp_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter description in Indonesian" 
                        :value="old('cp_description_id')"
                        required
                        rows="6"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="cp_description_en" 
                        label="Description (English)" 
                        placeholder="Enter description in English" 
                        :value="old('cp_description_en')"
                        required
                        rows="6"
                    />
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('companyprofiles.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection