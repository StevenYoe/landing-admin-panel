@extends('layouts.app')

@section('title', 'Vacancies - Pazar Website Admin')

@section('page-title', 'Vacancies')

@section('content')

@php
    $hasWriteAccess = app('App\Http\Controllers\BaseController')->hasWriteAccess();
@endphp

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Vacancy List</h2>
        @if($hasWriteAccess)
        <x-button href="{{ route('vacancies.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Vacancy
        </x-button>
        @endif
    </div>
    
    <x-card class="mb-6">
        <form action="{{ route('vacancies.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <x-form.select 
                        name="department_id" 
                        label="Department" 
                        :options="collect($departments)->pluck('da_title_en', 'da_id')->prepend('All Departments', '')" 
                        :selected="$departmentId"
                    />
                </div>
                
                <div>
                    <x-form.select 
                        name="employment_id" 
                        label="Employment Type" 
                        :options="collect($employments)->pluck('e_title_en', 'e_id')->prepend('All Employment Types', '')" 
                        :selected="$employmentId"
                    />
                </div>
                
                <div>
                    <x-form.select 
                        name="experience_id" 
                        label="Experience Level" 
                        :options="collect($experiences)->pluck('ex_title_en', 'ex_id')->prepend('All Experience Levels', '')" 
                        :selected="$experienceId"
                    />
                </div>
                
                <div>
                    <x-form.select 
                        name="is_active" 
                        label="Status" 
                        :options="['' => 'All Statuses', '1' => 'Active', '0' => 'Inactive']" 
                        :selected="$isActive"
                    />
                </div>
                
                <div>
                    <x-form.select 
                        name="is_urgent" 
                        label="Urgency" 
                        :options="['' => 'All', '1' => 'Urgent', '0' => 'Normal']" 
                        :selected="$isUrgent"
                    />
                </div>
            </div>
            
            <div class="flex justify-end">
                <x-button type="submit" variant="primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </x-button>
            </div>
        </form>
    </x-card>
    
    <x-card>
        @if(count($vacancies) > 0)
            <div class="overflow-x-auto">
                <x-table 
                    :headers="[
                        ['name' => 'ID', 'key' => 'v_id'],
                        ['name' => 'Title', 'key' => 'v_title_en'],
                        ['name' => 'Department', 'key' => 'department_name'],
                        ['name' => 'Employment', 'key' => 'employment_name'],
                        ['name' => 'Experience', 'key' => 'experience_name'],
                        ['name' => 'Posted Date', 'key' => 'v_posted_date'],
                        ['name' => 'Status', 'key' => 'v_is_active']
                    ]"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                >
                    @foreach($vacancies as $vacancy)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                            <td class="px-5 py-4 text-center">{{ $vacancy['v_id'] }}</td>
                            <td class="px-5 py-4">
                                {{ $vacancy['v_title_en'] }}
                            </td>
                            <td class="px-5 py-4">{{ $vacancy['department_name'] ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $vacancy['employment_name'] ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $vacancy['experience_name'] ?? '-' }}</td>
                            <td class="px-5 py-4">{{ isset($vacancy['v_posted_date']) ? date('d M Y', strtotime($vacancy['v_posted_date'])) : '-' }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($vacancy['v_is_active'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Inactive
                                    </span>
                                @endif
                                @if($vacancy['v_urgent'])
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Urgent
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('vacancies.show', $vacancy['v_id']) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    @if($hasWriteAccess)
                                    <a href="{{ route('vacancies.edit', $vacancy['v_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('vacancies.destroy', $vacancy['v_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vacancy?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
            @if(isset($paginator))
                <div class="mt-4">
                    {{ $paginator->links() }}
                </div>
            @endif
        @else
            <div class="py-8 text-center">
                <p class="text-gray-400">No vacancies have been added yet</p>
                @if($hasWriteAccess)
                <x-button href="{{ route('vacancies.create') }}" variant="primary" class="mt-4">
                    Add Vacancy
                </x-button>
                @endif
            </div>
        @endif
    </x-card>
@endsection