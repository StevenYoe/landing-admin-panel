<!--
    Work At Pazar List Page
    This Blade view displays a list of all 'Work At Pazar' entries in the admin panel.
    Comments are provided throughout to explain the structure and logic for future developers.
-->
@extends('layouts.app')

@section('title', 'Work At Pazar - Pazar Website Admin')

@section('page-title', 'Work At Pazar')

@section('content')

    <!-- Header section: Page title and Add Work At Pazar button -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Work At Pazar List</h2>
        <!-- Add Work At Pazar Button: Navigates to the create form -->
        <x-button href="{{ route('workatpazars.create') }}" variant="primary">
            <!-- Plus Icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Work At Pazar
        </x-button>
    </div>
    
    <!-- Main Card: Contains the table or empty state -->
    <x-card>
        @if(count($workAtPazars) > 0)
            <div class="overflow-x-auto">
            <!-- Work At Pazar Table: Shows all entries with columns for ID, titles, descriptions, and type -->
            <x-table 
                :headers="[
                    ['name' => 'ID', 'key' => 'wap_id'],
                    ['name' => 'Title (ID)', 'key' => 'wap_title_id'],
                    ['name' => 'Title (EN)', 'key' => 'wap_title_en'],
                    ['name' => 'Description (ID)', 'key' => 'wap_description_id'],
                    ['name' => 'Description (EN)', 'key' => 'wap_description_en'],
                    ['name' => 'Type', 'key' => 'wap_type']
                ]"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
            >
                @foreach($workAtPazars as $workAtPazar)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                        <!-- Work At Pazar ID -->
                        <td class="px-5 py-4 text-center">{{ $workAtPazar['wap_id'] }}</td>
                        <!-- Title in Indonesian (truncated) -->
                        <td class="px-5 py-4 text-center">{{ Str::limit($workAtPazar['wap_title_id'], 30) }}</td>
                        <!-- Title in English (truncated) -->
                        <td class="px-5 py-4 text-center">{{ Str::limit($workAtPazar['wap_title_en'], 30) }}</td>
                        <!-- Description in Indonesian (truncated) -->
                        <td class="px-5 py-4 text-center">
                            @if(!empty($workAtPazar['wap_description_id']))
                                {{ Str::limit($workAtPazar['wap_description_id'], 50) }}
                            @else
                                -
                            @endif
                        </td>
                        <!-- Description in English (truncated) -->
                        <td class="px-5 py-4 text-center">
                            @if(!empty($workAtPazar['wap_description_en']))
                                {{ Str::limit($workAtPazar['wap_description_en'], 50) }}
                            @else
                                -
                            @endif
                        </td>
                        <!-- Type -->
                        <td class="px-5 py-4 text-center">{{ $workAtPazar['wap_type'] }}</td>
                        <!-- Action Buttons: View, Edit, Delete -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- View Work At Pazar Button -->
                                <a href="{{ route('workatpazars.show', $workAtPazar['wap_id']) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <!-- Edit Work At Pazar Button -->
                                <a href="{{ route('workatpazars.edit', $workAtPazar['wap_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete Work At Pazar Button (with confirmation) -->
                                <form action="{{ route('workatpazars.destroy', $workAtPazar['wap_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Work At Pazar?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
        <!-- Pagination Links (if available) -->
        @if(isset($paginator))
            <div class="mt-4">
                {{ $paginator->links() }}
            </div>
        @endif
        @else
            <!-- Empty State: No Work At Pazar entries found -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No Work At Pazar have been added yet</p>
                <!-- Add Work At Pazar Button in empty state -->
                <x-button href="{{ route('workatpazars.create') }}" variant="primary" class="mt-4">
                    Add Work At Pazar
                </x-button>
            </div>
        @endif
    </x-card>
@endsection