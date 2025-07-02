<!--
    Vacancy Details Page
    This Blade view displays detailed information about a specific job vacancy in the admin panel.
    Comments are provided throughout to explain the structure and logic for future developers.
-->
@extends('layouts.app')

@section('title', 'Vacancy Details - Pazar Website Admin')

@section('page-title', 'Vacancy Details')

@section('content')
    <!-- Header section: Back to List button and action buttons (Edit, Delete) -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Back to List Button: Navigates back to the vacancies list -->
        <x-button href="{{ route('vacancies.index') }}" variant="outline">
            <!-- Left Arrow Icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Edit Vacancy Button: Navigates to the edit form for this vacancy -->
            <x-button href="{{ route('vacancies.edit', $vacancy['v_id']) }}" variant="primary">
                <!-- Edit Icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            <!-- Delete Vacancy Button: Submits a form to delete this vacancy (with confirmation) -->
            <form action="{{ route('vacancies.destroy', $vacancy['v_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vacancy?');">
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
    
    <!-- Main Content: Vacancy details and audit information -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Left/Main Column: Vacancy information, titles, description, requirements, responsibilities -->
        <div class="lg:col-span-2">
            <!-- Vacancy Information Card: Shows main attributes of the vacancy -->
            <x-card title="Vacancy Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Vacancy ID -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $vacancy['v_id'] }}</p>
                    </div>
                    <!-- Status and Urgency -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Status</h4>
                        <p>
                            <span class="px-2 py-1 text-xs rounded-full {{ $vacancy['v_is_active'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                {{ $vacancy['v_is_active'] ? 'Active' : 'Inactive' }}
                            </span>
                                @if($vacancy['v_urgent'])
                                    <span class="inline-flex items-center ml-2 px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Urgent
                                    </span>
                                @endif
                        </p>
                    </div>
                    <!-- Department -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Department</h4>
                        <p>{{ $vacancy['department_name'] ?? '-' }}</p>
                    </div>
                    <!-- Employment Type -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Employment Type</h4>
                        <p>{{ $vacancy['employment_name'] ?? '-' }}</p>
                    </div>
                    <!-- Experience Level -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Experience Level</h4>
                        <p>{{ $vacancy['experience_name'] ?? '-' }}</p>
                    </div>
                    <!-- Job Type -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Job Type</h4>
                        <p>{{ $vacancy['v_type'] ?? '-' }}</p>
                    </div>
                    <!-- Job Posted Date -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Job Posted</h4>
                        <p>{{ isset($vacancy['v_posted_date']) ? date('d M Y', strtotime($vacancy['v_posted_date'])) : '-' }}</p>
                    </div>
                    <!-- Application Deadline -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Application Deadline</h4>
                        <p>{{ isset($vacancy['v_closed_date']) ? date('d M Y', strtotime($vacancy['v_closed_date'])) : '-' }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Vacancy Titles Card: Shows titles in Indonesian and English -->
            <x-card title="Vacancy Titles" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (Indonesian)</h4>
                        <p>{{ $vacancy['v_title_id'] }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (English)</h4>
                        <p>{{ $vacancy['v_title_en'] }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Job Description Card: Shows descriptions in Indonesian and English -->
            <x-card title="Job Description" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Description (Indonesian)</h4>
                        {!! nl2br(e($vacancy['v_description_id'])) !!}
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Description (English)</h4>
                        {!! nl2br(e($vacancy['v_description_en'])) !!}
                    </div>
                </div>
            </x-card>
            
            <!-- Requirement Card: Shows requirements in Indonesian and English -->
            <x-card title="Requirement" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Requirement (Indonesian)</h4>
                        {!! nl2br(e($vacancy['v_requirement_id'])) !!}
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Requirement (English)</h4>
                        {!! nl2br(e($vacancy['v_requirement_en'])) !!}
                    </div>
                </div>
            </x-card>
            
            <!-- Responsibilities Card: Shows responsibilities in Indonesian and English -->
            <x-card title="Responsibilities" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Responsibilities (Indonesian)</h4>
                        {!! nl2br(e($vacancy['v_responsibilities_id'])) !!}
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Responsibilities (English)</h4>
                        {!! nl2br(e($vacancy['v_responsibilities_en'])) !!}
                    </div>
                </div>
            </x-card>
        </div>
        
        <!-- Right/Sidebar Column: Audit information about the vacancy -->
        <div class="lg:col-span-1">
            <!-- Audit Information Card: Shows created/updated timestamps and users -->
            <x-card title="Audit Information">
                <div class="text-sm">
                    <div class="text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created at</span>
                        <span>{{ isset($vacancy['v_created_at']) ? date('d M Y H:i', strtotime($vacancy['v_created_at'])) : '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created by</span>
                        <span>{{ $vacancy['v_created_by'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated at</span>
                        <span>{{ isset($vacancy['v_updated_at']) ? date('d M Y H:i', strtotime($vacancy['v_updated_at'])) : '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated by</span>
                        <span>{{ $vacancy['v_updated_by'] ?? '-' }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection