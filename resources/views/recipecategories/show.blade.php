<!--
    Recipe Category Details Page
    This Blade view displays detailed information about a single recipe category, including its titles and related recipes.
    Each section, card, field, button, and related recipe is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Recipe Category Details - Pazar Website Admin')

@section('page-title', 'Recipe Category Details')

@section('content')
    <!-- Top bar with Back, Edit, and Delete buttons -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Button: Back to recipe category list -->
        <x-button href="{{ route('recipecategories.index') }}" variant="outline">
            <!-- Back icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Button: Edit recipe category -->
            <x-button href="{{ route('recipecategories.edit', $category['rc_id']) }}" variant="primary">
                <!-- Edit icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <!-- Button: Delete recipe category (with confirmation) -->
            <form action="{{ route('recipecategories.destroy', $category['rc_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe category?');">
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
        <!-- Main content: Recipe category information and titles -->
        <div class="lg:col-span-2">
            <!-- Card: Recipe category information (ID) -->
            <x-card title="Recipe Category Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <!-- Recipe category ID -->
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $category['rc_id'] }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Recipe category titles in both languages -->
            <x-card title="Recipe Category Titles" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <!-- Title in Indonesian -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (Indonesian)</h4>
                        <p>{{ $category['rc_title_id'] }}</p>
                    </div>
                    
                    <div>
                        <!-- Title in English -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (English)</h4>
                        <p>{{ $category['rc_title_en'] }}</p>
                    </div>
                </div>
            </x-card>
        </div>
        
        <!-- Section: Related recipes for this category -->
        <div class="lg:col-span-3">
            <x-card title="Related Recipes">
                @if(count($recipes) > 0)
                    <!-- Grid of related recipes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($recipes as $recipe)
                            <div class="border border-gray-700 rounded-lg overflow-hidden">
                                @if(!empty($recipe['r_image']))
                                    <!-- Recipe image -->
                                    <img src="{{ $recipe['r_image'] }}" alt="{{ $recipe['r_title_id'] }}" class="w-full h-40 object-cover">
                                @else
                                    <!-- Placeholder if no image -->
                                    <div class="w-full h-40 bg-gray-800 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <!-- Recipe title in Indonesian -->
                                    <h3 class="text-lg font-semibold mb-2">{{ $recipe['r_title_id'] }}</h3>
                                    <!-- Recipe title in English -->
                                    <p class="text-sm text-gray-400">{{ $recipe['r_title_en'] }}</p>
                                    <div class="mt-4">
                                        <!-- Button: View recipe details -->
                                        <a href="{{ route('recipes.show', $recipe['r_id']) }}" class="text-blue-500 hover:text-blue-700 text-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- If no related recipes exist -->
                    <p class="text-gray-400 text-center py-4">There are no recipes related to this category.</p>
                @endif
            </x-card>
        </div>
    </div>
@endsection