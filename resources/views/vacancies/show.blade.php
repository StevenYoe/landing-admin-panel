@extends('layouts.app')

@section('title', 'Vacancy Details - Pazar Website Admin')

@section('page-title', 'Vacancy Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <x-button href="{{ route('vacancies.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <x-button href="{{ route('vacancies.edit', $vacancy['v_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <form action="{{ route('vacancies.destroy', $vacancy['v_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vacancy?');">
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
            <x-card title="Vacancy Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $vacancy['v_id'] }}</p>
                    </div>
                    
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
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Department</h4>
                        <p>{{ $vacancy['department_name'] ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Employment Type</h4>
                        <p>{{ $vacancy['employment_name'] ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Experience Level</h4>
                        <p>{{ $vacancy['experience_name'] ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Job Type</h4>
                        <p>{{ $vacancy['v_type'] ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Job Posted</h4>
                        <p>{{ isset($vacancy['v_posted_date']) ? date('d M Y', strtotime($vacancy['v_posted_date'])) : '-' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Application Deadline</h4>
                        <p>{{ isset($vacancy['v_closed_date']) ? date('d M Y', strtotime($vacancy['v_closed_date'])) : '-' }}</p>
                    </div>
                </div>
            </x-card>
            
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
        
        <div class="lg:col-span-1">
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