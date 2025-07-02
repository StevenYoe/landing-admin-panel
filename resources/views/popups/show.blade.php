<!--
    Popup Details Page
    This Blade view displays detailed information about a specific popup in the admin panel.
    Includes popup info, image, and actions to edit or delete the popup.
-->
@extends('layouts.app')

@section('title', 'Popup Details - Pazar Website Admin')

@section('page-title', 'Popup Details')

@section('content')
    <!--
        Header section: Back to List button and action buttons (Edit, Delete) for the popup.
    -->
    <div class="mb-6 flex justify-between items-center">
        <x-button href="{{ route('popups.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        <div class="flex justify-center space-x-2">
            <!-- Edit button: Navigates to the popup edit page -->
            <x-button href="{{ route('popups.edit', $popup['pu_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            <!-- Delete button: Submits a form to delete the popup (with confirmation) -->
            <form action="{{ route('popups.destroy', $popup['pu_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this popup?');">
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
    <!--
        Main content: Two-column layout with popup information and image.
    -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <!--
                Card with popup information: ID, status, and link.
            -->
            <x-card title="Popup Information">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $popup['pu_id'] }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Status</h4>
                        <p>
                            @if($popup['pu_is_active'])
                                <span class="px-2 py-1 text-xs rounded-full bg-green-500 text-white">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-500 text-white">Inactive</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">Link</h4>
                        <p>
                            @if($popup['pu_link'])
                                <a href="{{ $popup['pu_link'] }}" target="_blank" class="text-blue-500 hover:underline">
                                    {{ $popup['pu_link'] }}
                                </a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="lg:col-span-2">
            <!--
                Card with popup image: Shows the image if available, otherwise displays a placeholder message.
            -->
            <x-card title="Image">
                @if(!empty($popup['pu_image']))
                    <div class="mb-4 flex justify-center">
                        <img src="{{ $popup['pu_image'] }}" alt="Popup Image" class="max-w-full rounded-md">
                    </div>
                @else
                    <div class="py-12 flex justify-center items-center bg-gray-800 rounded-md">
                        <p class="text-gray-400">No image available</p>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
@endsection
