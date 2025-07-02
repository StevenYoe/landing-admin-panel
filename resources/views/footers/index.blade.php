<!--
    Footer List Page
    This Blade view displays a list of all footer entries in the system.
    It provides options to add, view, edit, and delete footers.
    Each section and component is commented to explain its purpose and logic.
-->
@extends('layouts.app')

@section('title', 'Footer - Pazar Website Admin')

@section('page-title', 'Footer')

@section('content')

    <!-- Header section with page title and Add Footer button -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Footer List</h2>
        <!-- Button to navigate to the footer creation form -->
        <x-button href="{{ route('footers.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Footer
        </x-button>
    </div>
    
    <!-- Card component to contain the footer table or empty state -->
    <x-card>
        @if(count($footers) > 0)
            <!-- Table displaying the list of footers -->
            <div class="overflow-x-auto">
            <x-table 
                :headers="[
                    ['name' => 'ID', 'key' => 'f_id'],
                    ['name' => 'Type', 'key' => 'f_type'],
                    ['name' => 'Label (ID)', 'key' => 'f_label_id'],
                    ['name' => 'Label (EN)', 'key' => 'f_label_en'],
                    ['name' => 'Icon', 'key' => 'f_icon'],
                    ['name' => 'Link', 'key' => 'f_link']
                ]"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
            >
                <!-- Loop through each footer and display its data in a table row -->
                @foreach($footers as $footer)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                        <!-- Footer ID -->
                        <td class="px-5 py-4 text-center">{{ $footer['f_id'] }}</td>
                        <!-- Footer Type -->
                        <td class="px-5 py-4 text-center">{{ $footer['f_type'] }}</td>
                        <!-- Footer Label in Indonesian -->
                        <td class="px-5 py-4 text-center">{{ $footer['f_label_id'] }}</td>
                        <!-- Footer Label in English -->
                        <td class="px-5 py-4 text-center">{{ $footer['f_label_en'] }}</td>
                        <!-- Footer Icon (if available) -->
                        <td class="px-5 py-4 text-center">
                            @if(!empty($footer['f_icon']))
                                <img src="{{ $footer['f_icon'] }}"></img>
                            @else
                                -
                            @endif
                        </td>
                        <!-- Footer Link (if available, limited to 30 chars) -->
                        <td class="px-5 py-4 text-center">
                            @if($footer['f_link'])
                                {{ Str::limit($footer['f_link'], 30) }}
                            @else
                                -
                            @endif
                        </td>
                        <!-- Action buttons: View, Edit, Delete -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- View footer details -->
                                <a href="{{ route('footers.show', $footer['f_id']) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <!-- Edit footer -->
                                <a href="{{ route('footers.edit', $footer['f_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete footer with confirmation -->
                                <form action="{{ route('footers.destroy', $footer['f_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this footer?');">
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
            <!-- Empty state if there are no footers -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No footers have been added yet</p>
                <!-- Button to add a new footer -->
                <x-button href="{{ route('footers.create') }}" variant="primary" class="mt-4">
                    Add Footer
                </x-button>
            </div>
        @endif
    </x-card>
@endsection