<!--
    Why Pazar Details Page
    This Blade view displays detailed information about a specific 'Why Pazar' entry in the admin panel.
    Comments are provided throughout to explain the structure and logic for future developers.
-->
@extends('layouts.app')

@section('title', 'Why Pazar Details - Pazar Website Admin')

@section('page-title', 'Why Pazar Details')

@section('content')
    <!-- Header section: Back to List button and action buttons (Edit, Delete) -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Back to List Button: Navigates back to the Why Pazar list -->
        <x-button href="{{ route('whypazars.index') }}" variant="outline">
            <!-- Left Arrow Icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Edit Why Pazar Button: Navigates to the edit form for this entry -->
            <x-button href="{{ route('whypazars.edit', $whyPazar['w_id']) }}" variant="primary">
                <!-- Edit Icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            <!-- Delete Why Pazar Button: Submits a form to delete this entry (with confirmation) -->
            <form action="{{ route('whypazars.destroy', $whyPazar['w_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this why pazar?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    <!-- Trash Icon -->
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </x-button>
            </form>
        </div>
    </div>
    
    <!-- Main Content: Why Pazar details and image -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Left/Main Column: Why Pazar information, titles, descriptions -->
        <div class="lg:col-span-2">
            <!-- Why Pazar Information Card: Shows main attributes of the entry -->
            <x-card title="Why Pazar Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Why Pazar ID -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $whyPazar['w_id'] }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Titles & Descriptions Card: Shows titles and descriptions in Indonesian and English -->
            <x-card title="Titles & Descriptions" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (Indonesian)</h4>
                        <p>{{ $whyPazar['w_title_id'] }}</p>
                        <!-- Description in Indonesian -->
                        <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (Indonesian)</h4>
                        <p>{{ $whyPazar['w_description_id'] ?? '-' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (English)</h4>
                        <p>{{ $whyPazar['w_title_en'] }}</p>
                        <!-- Description in English -->
                        <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (English)</h4>
                        <p>{{ $whyPazar['w_description_en'] ?? '-' }}</p>
                    </div>
                </div>
            </x-card>
        </div>
        
        <!-- Right/Sidebar Column: Image preview -->
        <div class="lg:col-span-1">
            <!-- Image Card: Shows the Why Pazar image if available -->
            <x-card title="Gambar">
                @if(!empty($whyPazar['w_image']))
                    <div class="mb-4">
                        <img src="{{ $whyPazar['w_image'] }}" alt="{{ $whyPazar['w_title_id'] }}" class="w-full rounded-md">
                    </div>
                @else
                    <p class="text-gray-400">No Image Available</p>
                @endif
            </x-card>
        </div>
    </div>
@endsection