<!--
    Company Profile Index Page (index.blade.php)
    ------------------------------------------------
    This Blade template displays a list of all Company Profile entries in the Pazar Website Admin panel.
    - Extends the main app layout for consistent styling.
    - Provides a button to add new Company Profile entries.
    - Uses a custom Blade table component to render the list with sorting support.
    - Each row displays the ID, type, and descriptions (Indonesian and English) for a Company Profile entry.
    - Action buttons allow viewing, editing, and deleting each entry.
    - Includes pagination if available.
-->

@extends('layouts.app')

@section('title', 'Company Profile - Pazar Website Admin')

@section('page-title', 'Company Profile')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Company Profile List</h2>
        <!-- Button to add a new Company Profile entry -->
        <x-button href="{{ route('companyprofiles.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Company Profile
        </x-button>
    </div>
    
    <x-card>
        @if(count($companyProfiles) > 0)
            <div class="overflow-x-auto">
            <!-- Table displaying all Company Profile entries -->
            <x-table 
                :headers="[
                    ['name' => 'ID', 'key' => 'cp_id'],
                    ['name' => 'Type', 'key' => 'cp_type'],
                    ['name' => 'Description (ID)', 'key' => 'cp_description_id'],
                    ['name' => 'Description (EN)', 'key' => 'cp_description_en']
                ]"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
            >
                @foreach($companyProfiles as $companyProfile)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                        <!-- Company Profile ID -->
                        <td class="px-5 py-4 text-center">{{ $companyProfile['cp_id'] }}</td>
                        <!-- Profile type -->
                        <td class="px-5 py-4 text-center">{{ $companyProfile['cp_type'] }}</td>
                        <!-- Indonesian description (truncated) -->
                        <td class="px-5 py-4 text-center">{{ Str::limit($companyProfile['cp_description_id'], 50) }}</td>
                        <!-- English description (truncated) -->
                        <td class="px-5 py-4 text-center">{{ Str::limit($companyProfile['cp_description_en'], 50) }}</td>
                        <!-- Action buttons: view, edit, delete -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- View button -->
                                <a href="{{ route('companyprofiles.show', $companyProfile['cp_id']) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <!-- Edit button -->
                                <a href="{{ route('companyprofiles.edit', $companyProfile['cp_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete button with confirmation -->
                                <form action="{{ route('companyprofiles.destroy', $companyProfile['cp_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company profile?');">
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
        <!-- Pagination links if available -->
        @if(isset($paginator))
            <div class="mt-4">
                {{ $paginator->links() }}
            </div>
        @endif
        @else
            <!-- Message if no Company Profile entries exist -->
            <div class="py-8 text-center">
                <p class="text-gray-400">No company profiles have been added yet</p>
                <x-button href="{{ route('companyprofiles.create') }}" variant="primary" class="mt-4">
                    Add Company Profile
                </x-button>
            </div>
        @endif
    </x-card>
@endsection