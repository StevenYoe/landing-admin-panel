@extends('layouts.app')

@section('title', 'Company Profile Details - Pazar Website Admin')

@section('page-title', 'Company Profile Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <x-button href="{{ route('companyprofiles.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <x-button href="{{ route('companyprofiles.edit', $companyProfile['cp_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <form action="{{ route('companyprofiles.destroy', $companyProfile['cp_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company profile?');">
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
        <x-card title="Company Profile Information">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <h4 class="text-sm font-medium text-gray-400">ID</h4>
                    <p>{{ $companyProfile['cp_id'] }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-400">Tipe</h4>
                    <p>{{ $companyProfile['cp_type'] }}</p>
                </div>
            </div>
        </x-card>
        
        <x-card title="Company Profile Description">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <h4 class="text-sm font-medium text-gray-400 mb-2">Description (Indonesian)</h4>
                    <div class="p-4 bg-gray-700 rounded-md">
                        <p>{{ $companyProfile['cp_description_id'] }}</p>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-400 mb-2">Description (English)</h4>
                    <div class="p-4 bg-gray-700 rounded-md">
                        <p>{{ $companyProfile['cp_description_en'] }}</p>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
@endsection