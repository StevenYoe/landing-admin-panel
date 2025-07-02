<!--
    Testimonial List Page
    This Blade view displays a list of all testimonials, with options to add, view, edit, or delete testimonials.
    Each section, table, button, and action is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Testimonials - Pazar Website Admin')

@section('page-title', 'Testimonials')

@section('content')

    <!-- Top bar with page title and Add Testimonial button -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Daftar Testimonial</h2>
        <!-- Button: Add new testimonial -->
        <x-button href="{{ route('testimonials.create') }}" variant="primary">
            <!-- Add icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Testimonial
        </x-button>
    </div>
    
    <!-- Card container for the testimonial table/list -->
    <x-card>
        @if(count($testimonials) > 0)
            <!-- Table of testimonials -->
            <div class="overflow-x-auto">
            <x-table 
                :headers="[
                    ['name' => 'ID', 'key' => 't_id'],
                    ['name' => 'Name', 'key' => 't_name'],
                    ['name' => 'Type', 'key' => 't_type'],
                    ['name' => 'Description (ID)', 'key' => 't_description_id'],
                    ['name' => 'Description (EN)', 'key' => 't_description_en'],
                    ['name' => 'Image', 'key' => 't_image']
                ]"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
            >
                @foreach($testimonials as $testimonial)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                        <!-- Testimonial ID -->
                        <td class="px-5 py-4 text-center">{{ $testimonial['t_id'] }}</td>
                        <!-- Name -->
                        <td class="px-5 py-4 text-center">{{ $testimonial['t_name'] }}</td>
                        <!-- Type -->
                        <td class="px-5 py-4 text-center">{{ $testimonial['t_type'] }}</td>
                        <!-- Description in Indonesian (truncated) -->
                        <td class="px-5 py-4 text-center">{{ Str::limit($testimonial['t_description_id'], 50) }}</td>
                        <!-- Description in English (truncated) -->
                        <td class="px-5 py-4 text-center">{{ Str::limit($testimonial['t_description_en'], 50) }}</td>
                        <!-- Testimonial image -->
                        <td class="px-5 py-4 text-center">
                            @if(!empty($testimonial['t_image']))
                                <img src="{{ $testimonial['t_image'] }}" alt="{{ $testimonial['t_name'] }}" class="h-10 w-auto mx-auto">
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- View button -->
                                <a href="{{ route('testimonials.show', $testimonial['t_id']) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <!-- Edit button -->
                                <a href="{{ route('testimonials.edit', $testimonial['t_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete button (with confirmation) -->
                                <form action="{{ route('testimonials.destroy', $testimonial['t_id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimonial ini?');">
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
            <!-- If no testimonials exist, show message and add button -->
            <div class="py-8 text-center">
                <p class="text-gray-400">Belum ada testimonial yang ditambahkan</p>
                <x-button href="{{ route('testimonials.create') }}" variant="primary" class="mt-4">
                    Tambah Testimonial
                </x-button>
            </div>
        @endif
    </x-card>
@endsection