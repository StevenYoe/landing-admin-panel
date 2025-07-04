<!--
    Experience Level Details Page
    This Blade view displays detailed information about a single experience level.
    It provides options to go back to the list, edit, or delete the experience level.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'Experience Level Details - Pazar Website Admin')

@section('page-title', 'Experience Level Details')

@section('content')
    <!-- Header section with Back, Edit, and Delete buttons -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Button to return to the experience level list -->
        <x-button href="{{ route('experiences.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Button to edit the experience level -->
            <x-button href="{{ route('experiences.edit', $experience['ex_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <!-- Form to delete the experience level with confirmation -->
            <form action="{{ route('experiences.destroy', $experience['ex_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this experience level?');">
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
    
    <div class="grid grid-cols-1 gap-6">
        <!-- Card displaying experience level's basic information -->
        <x-card title="Experience Level Information">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <h4 class="text-sm font-medium text-gray-400">ID</h4>
                    <p>{{ $experience['ex_id'] }}</p>
                </div>
            </div>
        </x-card>
        
        <!-- Card displaying experience level titles in different languages -->
        <x-card title="Experience Level Titles">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <h4 class="text-sm font-medium text-gray-400 mb-2">Title (Indonesian)</h4>
                    <p>{{ $experience['ex_title_id'] }}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-400 mb-2">Title (English)</h4>
                    <p>{{ $experience['ex_title_en'] }}</p>
                </div>
            </div>
        </x-card>
        
        <!-- Card displaying audit information (created/updated at/by) -->
        <x-card title="Audit Information">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="flex justify-between py-2 border-b border-gray-700">
                    <span class="text-gray-400">Created at</span>
                    <span>{{ isset($experience['ex_created_at']) ? date('d M Y H:i', strtotime($experience['ex_created_at'])) : '-' }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-700">
                    <span class="text-gray-400">Created by</span>
                    <span>{{ $experience['ex_created_by'] ?? '-' }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-700">
                    <span class="text-gray-400">Updated at</span>
                    <span>{{ isset($experience['ex_updated_at']) ? date('d M Y H:i', strtotime($experience['ex_updated_at'])) : '-' }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-700">
                    <span class="text-gray-400">Updated by</span>
                    <span>{{ $experience['ex_updated_by'] ?? '-' }}</span>
                </div>
            </div>
        </x-card>
    </div>
@endsection