<!--
    Header List Page
    This Blade view displays a list of all header entries in the system.
    It provides options to add, view, edit, and delete headers.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'Header - Pazar Website Admin')

@section('page-title', 'Header')

@section('content')

    <!-- Header section with page title and Add Header button -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Header List</h2>
        <!-- Button to navigate to the header creation form -->
        <x-button href="{{ route('headers.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Header
        </x-button>
    </div>
    
    <!-- Card component to contain the header table or empty state -->
    <x-card>
        @if(count($headers) > 0)
            <!-- Table displaying the list of headers -->
            <div class="overflow-x-auto">
            <x-table 
                :headers="[
                    ['name' => 'ID', 'key' => 'h_id'],
                    ['name' => 'Title (ID)', 'key' => 'h_title_id'],
                    ['name' => 'Title (EN)', 'key' => 'h_title_en'],
                    ['name' => 'Page Name', 'key' => 'h_page_name'],
                    ['name' => 'Image', 'key' => 'h_image']
                ]"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
            >
                <!-- Loop through each header and display its data in a table row -->
                @foreach($headers as $header)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                        <!-- Header ID -->
                        <td class="px-5 py-4 text-center">{{ $header['h_id'] }}</td>
                        <!-- Header Title in Indonesian -->
                        <td class="px-5 py-4 text-center">{{ $header['h_title_id'] }}</td>
                        <!-- Header Title in English -->
                        <td class="px-5 py-4 text-center">{{ $header['h_title_en'] }}</td>
                        <!-- Page Name -->
                        <td class="px-5 py-4 text-center">{{ $header['h_page_name'] }}</td>
                        <!-- Header Image (if available) -->
                        <td class="px-5 py-4 text-center">
                            @if(!empty($header['h_image']))
                                <img src="{{ $header['h_image'] }}" alt="Header Image" class="h-10 w-auto mx-auto">
                            @else
                                -
                            @endif
                        </td>
                        <!-- Action buttons: View, Edit, Delete -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- View header details -->
                                <a href="{{ route('headers.show', $header['h_id']) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <!-- Edit header -->
                                <a href="{{ route('headers.edit', $header['h_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete header with confirmation -->
                                <form action="{{ route('headers.destroy', $header['h_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this header?');">
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
            <!-- Empty state if there are no headers -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No headers have been added yet</p>
                <!-- Button to add a new header -->
                <x-button href="{{ route('headers.create') }}" variant="primary" class="mt-4">
                    Add Header
                </x-button>
            </div>
        @endif
    </x-card>
@endsection