<!--
    Certification Show Page (show.blade.php)
    ------------------------------------------------
    This Blade template displays the details of a single Certification entry in the Pazar Website Admin panel.
    - Extends the main app layout for consistent styling.
    - Provides a back button to return to the Certification list.
    - Includes buttons to edit or delete the current Certification entry.
    - Shows all details: ID, titles, descriptions (Indonesian and English), and image if available.
    - Uses custom Blade components for layout and styling.
-->

@extends('layouts.app')

@section('title', 'Certification Details - Pazar Website Admin')

@section('page-title', 'Certification Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <!-- Back button to return to the Certification list -->
        <x-button href="{{ route('certifications.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Edit button for the current Certification entry -->
            <x-button href="{{ route('certifications.edit', $certification['c_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <!-- Delete button for the current Certification entry -->
            <form action="{{ route('certifications.destroy', $certification['c_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certification?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </x-button>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <!-- Card displaying Certification ID -->
            <x-card title="Certification Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $certification['c_id'] }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Card displaying Certification titles and descriptions -->
            <x-card title="Certification Titles & Descriptions" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (Indonesian)</h4>
                        <p>{{ $certification['c_title_id'] }}</p>
                        
                        <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (Indonesian)</h4>
                        <p>{!! nl2br(e($certification['c_description_id'] ?? '-')) !!}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (English)</h4>
                        <p>{{ $certification['c_title_en'] }}</p>
                        
                        <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (English)</h4>
                        <p>{!! nl2br(e($certification['c_description_en'] ?? '-')) !!}</p>
                    </div>
                </div>
            </x-card>
        </div>
        
        <div class="lg:col-span-1">
            <!-- Card displaying Certification image if available -->
            <x-card title="Image">
            @if(!empty($certification['c_image']))
                <div class="mb-4">
                    <img src="{{ $certification['c_image'] }}" alt="{{ $certification['c_title_id'] }}" class="w-full rounded-md">
                </div>
            @else
                <p class="text-gray-400">No image available</p>
            @endif
            </x-card>
        </div>
    </div>
@endsection
