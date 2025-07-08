<!--
    Testimonial Details Page
    This Blade view displays detailed information about a single testimonial, including name, type, gender, descriptions, product info, link, and image.
    Each section, card, field, button, and image is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Testimonial Details - Pazar Website Admin')

@section('page-title', 'Testimonial Details')

@section('content')
    <!-- Top bar with Back, Edit, and Delete buttons -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Button: Back to testimonial list -->
        <x-button href="{{ route('testimonials.index') }}" variant="outline">
            <!-- Back icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Button: Edit testimonial -->
            <x-button href="{{ route('testimonials.edit', $testimonial['t_id']) }}" variant="primary">
                <!-- Edit icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <!-- Button: Delete testimonial (with confirmation) -->
            <form action="{{ route('testimonials.destroy', $testimonial['t_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    <!-- Delete icon -->
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </x-button>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main content: Testimonial information and descriptions -->
        <div class="lg:col-span-2">
            <!-- Card: Testimonial information -->
            <x-card title="Testimonial Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <!-- Testimonial ID -->
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $testimonial['t_id'] }}</p>
                    </div>
                    <div>
                        <!-- Name -->
                        <h4 class="text-sm font-medium text-gray-400">Name</h4>
                        <p>{{ $testimonial['t_name'] }}</p>
                    </div>
                    <div>
                        <!-- Type -->
                        <h4 class="text-sm font-medium text-gray-400">Type</h4>
                        <p>{{ $testimonial['t_type'] }}</p>
                    </div>
                    <div>
                        <!-- Gender -->
                        <h4 class="text-sm font-medium text-gray-400">Gender</h4>
                        <p>{{ $testimonial['t_gender'] }}</p>
                    </div>
                    <div>
                        <!-- Link -->
                        <h4 class="text-sm font-medium text-gray-400">Link</h4>
                        @if(!empty($testimonial['t_link']))
                            <a href="{{ $testimonial['t_link'] }}" target="_blank" class="text-blue-400 hover:text-blue-300 break-all">
                                {{ $testimonial['t_link'] }}
                            </a>
                        @else
                            <p class="text-gray-500">-</p>
                        @endif
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Testimonial descriptions in both languages -->
            <x-card title="Description" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <!-- Description in Indonesian -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Description (Indonesian)</h4>
                        <p>{{ $testimonial['t_description_id'] }}</p>
                    </div>
                    
                    <div>
                        <!-- Description in English -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Description (English)</h4>
                        <p>{{ $testimonial['t_description_en'] }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Product information in both languages -->
            <x-card title="Product Information" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <!-- Product name in Indonesian -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Product Name (Indonesian)</h4>
                        <p>{{ !empty($testimonial['t_product_id']) ? $testimonial['t_product_id'] : '-' }}</p>
                    </div>
                    
                    <div>
                        <!-- Product name in English -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Product Name (English)</h4>
                        <p>{{ !empty($testimonial['t_product_en']) ? $testimonial['t_product_en'] : '-' }}</p>
                    </div>
                </div>
            </x-card>
        </div>
        
        <!-- Sidebar: Testimonial image -->
        <div class="lg:col-span-1">
            <x-card title="Gambar">
                @if(!empty($testimonial['t_image']))
                    <div class="mb-4">
                        <!-- Testimonial image -->
                        <img src="{{ $testimonial['t_image'] }}" alt="Testimonial dari {{ $testimonial['t_name'] }}" class="w-full rounded-md">
                    </div>
                @else
                    <!-- Placeholder if no image -->
                    <p class="text-gray-400">No image available</p>
                @endif
            </x-card>
        </div>
    </div>
@endsection