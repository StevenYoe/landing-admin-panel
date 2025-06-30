@extends('layouts.app')

@section('title', 'Add Employment Type - Pazar Website Admin')

@section('page-title', 'Add Employment Type')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('employments.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('employments.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="e_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('e_title_id')"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="e_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('e_title_en')"
                        required
                        helper="Maximum 100 characters"
                    />
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('employments.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection