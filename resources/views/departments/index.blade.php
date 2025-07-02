<!--
    Departments Index Page
    This Blade view displays a list of all departments in the system.
    It provides options to add, view, edit, and delete departments.
    Each section and component is commented to explain its purpose.
-->
@extends('layouts.app')

@section('title', 'Departments - Pazar Website Admin')

@section('page-title', 'Departments')

@section('content')

    <!-- Header section with page title and Add Department button -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Department List</h2>
        <!-- Button to navigate to the department creation form -->
        <x-button href="{{ route('departments.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Department
        </x-button>
    </div>
    
    <!-- Card component to contain the department table or empty state -->
    <x-card>
        @if(count($departments) > 0)
            <!-- Table displaying the list of departments -->
            <div class="overflow-x-auto">
                <x-table 
                    :headers="[
                        ['name' => 'ID', 'key' => 'da_id'],
                        ['name' => 'Title (ID)', 'key' => 'da_title_id'],
                        ['name' => 'Title (EN)', 'key' => 'da_title_en']
                    ]"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                >
                    <!-- Loop through each department and display its data in a table row -->
                    @foreach($departments as $department)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                            <!-- Department ID -->
                            <td class="px-5 py-4 text-center">{{ $department['da_id'] }}</td>
                            <!-- Department Title in Indonesian -->
                            <td class="px-5 py-4">{{ $department['da_title_id'] }}</td>
                            <!-- Department Title in English -->
                            <td class="px-5 py-4">{{ $department['da_title_en'] }}</td>
                            <!-- Action buttons: View, Edit, Delete -->
                            <td class="px-5 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <!-- View department details -->
                                    <a href="{{ route('departments.show', $department['da_id']) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <!-- Edit department -->
                                    <a href="{{ route('departments.edit', $department['da_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <!-- Delete department with confirmation -->
                                    <form action="{{ route('departments.destroy', $department['da_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?');">
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
            <!-- Empty state if there are no departments -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No departments have been added yet</p>
                <!-- Button to add a new department -->
                <x-button href="{{ route('departments.create') }}" variant="primary" class="mt-4">
                    Add Department
                </x-button>
            </div>
        @endif
    </x-card>
@endsection