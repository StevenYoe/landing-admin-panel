<!--
    History Details Page
    This Blade view displays detailed information about a single history entry.
    It provides options to go back to the list, edit, or delete the history.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'History Details - Pazar Website Admin')

@section('page-title', 'History Details')

@section('content')
    <!-- Header section with Back, Edit, and Delete buttons -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Button to return to the history list -->
        <x-button href="{{ route('histories.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Button to edit the history -->
            <x-button href="{{ route('histories.edit', $history['hs_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <!-- Form to delete the history with confirmation -->
            <form action="{{ route('histories.destroy', $history['hs_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this history?');">
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
            <!-- Card displaying history's basic information -->
            <x-card title="History Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $history['hs_id'] }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Year</h4>
                        <p>{{ $history['hs_year'] }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Card displaying history descriptions in different languages -->
            <x-card title="Descriptions" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Description (Indonesian)</h4>
                        <p>{{ $history['hs_description_id'] }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Description (English)</h4>
                        <p>{{ $history['hs_description_en'] }}</p>
                    </div>
                </div>
            </x-card>
        </div>
        
        <div class="lg:col-span-1">
            <!-- Card displaying the history image if available -->
            <x-card title="Image">
                @if(!empty($history['hs_image']))
                    <div class="mb-4">
                        <img src="{{ $history['hs_image'] }}" alt="History {{ $history['hs_year'] }}" class="w-full rounded-md">
                    </div>
                @else
                    <p class="text-gray-400">No image available</p>
                @endif
            </x-card>
        </div>
    </div>
@endsection