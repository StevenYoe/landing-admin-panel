<!--
    History List Page
    This Blade view displays a list of all history entries in the system.
    It provides options to add, view, edit, and delete histories.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'History - Pazar Website Admin')

@section('page-title', 'History')

@section('content')

    <!-- Header section with page title and Add History button -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">History List</h2>
        <!-- Button to navigate to the history creation form -->
        <x-button href="{{ route('histories.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add History
        </x-button>
    </div>
    
    <!-- Card component to contain the history table or empty state -->
    <x-card>
        @if(count($histories) > 0)
            <!-- Table displaying the list of histories -->
            <div class="overflow-x-auto">
            <x-table 
                :headers="[
                    ['name' => 'ID', 'key' => 'hs_id'],
                    ['name' => 'Year', 'key' => 'hs_year'],
                    ['name' => 'Description (ID)', 'key' => 'hs_description_id'],
                    ['name' => 'Description (EN)', 'key' => 'hs_description_en'],
                    ['name' => 'Image', 'key' => 'hs_image']
                ]"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
            >
                <!-- Loop through each history and display its data in a table row -->
                @foreach($histories as $history)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                        <!-- History ID -->
                        <td class="px-5 py-4 text-center">{{ $history['hs_id'] }}</td>
                        <!-- History Year -->
                        <td class="px-5 py-4 text-center">{{ $history['hs_year'] }}</td>
                        <!-- History Description in Indonesian (limited to 50 chars) -->
                        <td class="px-5 py-4 text-center">{{ Str::limit($history['hs_description_id'], 50) }}</td>
                        <!-- History Description in English (limited to 50 chars) -->
                        <td class="px-5 py-4 text-center">{{ Str::limit($history['hs_description_en'], 50) }}</td>
                        <!-- History Image (if available) -->
                        <td class="px-5 py-4 text-center">
                            @if(!empty($history['hs_image']))
                                <img src="{{ $history['hs_image'] }}" alt="History Image" class="h-10 w-auto mx-auto">
                            @else
                                -
                            @endif
                        </td>
                        <!-- Action buttons: View, Edit, Delete -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- View history details -->
                                <a href="{{ route('histories.show', $history['hs_id']) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <!-- Edit history -->
                                <a href="{{ route('histories.edit', $history['hs_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete history with confirmation -->
                                <form action="{{ route('histories.destroy', $history['hs_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this history?');">
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
        <!-- Pagination links if paginator is set -->
        @if(isset($paginator))
            <div class="mt-4">
                {{ $paginator->links() }}
            </div>
        @endif
        @else
            <!-- Empty state if there are no histories -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No histories have been added yet</p>
                <!-- Button to add a new history -->
                <x-button href="{{ route('histories.create') }}" variant="primary" class="mt-4">
                    Add History
                </x-button>
            </div>
        @endif
    </x-card>
@endsection