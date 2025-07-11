<!--
    Popup List Page
    This Blade view displays a list of all popups in the admin panel.
    Includes a table with popup details and actions to view, edit, or delete each popup.
-->
@extends('layouts.app')

@section('title', 'Popup - Pazar Website Admin')

@section('page-title', 'Popup')

@section('content')
    <!--
        Header section: Shows the page title and a button to add a new popup.
    -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Popup List</h2>
        <x-button href="{{ route('popups.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Popup
        </x-button>
    </div>
    
    <!--
        Card container for the popup table or empty state.
    -->
    <x-card>
        @if(count($popups) > 0)
            <!--
                Table of popups: Displays ID, link, status, image, and actions for each popup.
            -->
            <div class="overflow-x-auto">
            <x-table 
                :headers="[
                    ['name' => 'ID', 'key' => 'pu_id'],
                    ['name' => 'Link', 'key' => 'pu_link'],
                    ['name' => 'Status', 'key' => 'pu_is_active'],
                    ['name' => 'Image', 'key' => 'pu_image']
                ]"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
            >
                @foreach($popups as $popup)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                        <!-- Popup ID -->
                        <td class="px-5 py-4 text-center">{{ $popup['pu_id'] }}</td>
                        <!-- Popup Link (truncated if too long) -->
                        <td class="px-5 py-4 text-center">
                            @if($popup['pu_link'])
                                {{ Str::limit($popup['pu_link'], 30) }}
                            @else
                                -
                            @endif
                        </td>
                        <!-- Popup Status (Active/Inactive) -->
                        <td class="px-5 py-4 text-center">
                            @if(isset($popup['pu_is_active']))
                                <span class="px-2 py-1 text-xs rounded-full {{ $popup['pu_is_active'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $popup['pu_is_active'] ? 'Active' : 'Inactive' }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <!-- Popup Image (thumbnail if available) -->
                        <td class="px-5 py-4 text-center">
                            @if(!empty($popup['pu_image']))
                                <img src="{{ $popup['pu_image'] }}" alt="Popup Image" class="h-10 w-auto mx-auto">
                            @else
                                -
                            @endif
                        </td>
                        <!-- Action buttons: View, Edit, Delete -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- View button -->
                                <a href="{{ route('popups.show', $popup['pu_id']) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <!-- Edit button -->
                                <a href="{{ route('popups.edit', $popup['pu_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete button (with confirmation) -->
                                <form action="{{ route('popups.destroy', $popup['pu_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this popup?');">
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
        <!--
            Pagination links if paginator is set.
        -->
        @if(isset($paginator))
            <div class="mt-4">
                {{ $paginator->links() }}
            </div>
        @endif
        @else
            <!--
                Empty state: Shown if there are no popups in the database.
            -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No popups have been added yet</p>
                <x-button href="{{ route('popups.create') }}" variant="primary" class="mt-4">
                    Add Popup
                </x-button>
            </div>
        @endif
    </x-card>
@endsection