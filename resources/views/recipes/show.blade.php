<!--
    Recipe Details Page
    This Blade view displays detailed information about a single recipe, including its basic info, details, image, video, and metadata.
    Each section, card, field, button, and metadata is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Recipe Details - Pazar Website Admin')

@section('page-title', 'Recipe Details')

@section('content')
    <!-- Top bar with Back, Edit, and Delete buttons -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Button: Back to recipe list -->
        <x-button href="{{ route('recipes.index') }}" variant="outline">
            <!-- Back icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <!-- Button: Edit recipe -->
            <x-button href="{{ route('recipes.edit', $recipe['r_id']) }}" variant="primary">
                <!-- Edit icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <!-- Button: Delete recipe (with confirmation) -->
            <form action="{{ route('recipes.destroy', $recipe['r_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
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
        <!-- Main content: Recipe information and details -->
        <div class="lg:col-span-2">
            <!-- Card: General recipe information -->
            <x-card title="Recipe Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <!-- Recipe ID -->
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $recipe['r_id'] }}</p>
                    </div>
                    
                    <div>
                        <!-- Recipe status (active/inactive) -->
                        <h4 class="text-sm font-medium text-gray-400">Status</h4>
                        <p>
                            <span class="px-2 py-1 text-xs rounded-full {{ $recipe['r_is_active'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                {{ $recipe['r_is_active'] ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <!-- Recipe categories as badges -->
                        <h4 class="text-sm font-medium text-gray-400">Categories</h4>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @if(isset($recipe['categories']) && count($recipe['categories']) > 0)
                                @foreach($recipe['categories'] as $category)
                                    <!-- Category badge -->
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-900 text-blue-300">
                                        {{ $category['rc_title_id'] }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-400">No categories assigned</span>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Basic recipe information in both languages -->
            <x-card title="Basic Information" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <!-- Recipe title in Indonesian -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (Indonesia)</h4>
                        <p>{{ $recipe['r_title_id'] }}</p>
                    </div>
                    
                    <div>
                        <!-- Recipe title in English -->
                        <h4 class="text-sm font-medium text-gray-400 mb-2">Title (English)</h4>
                        <p>{{ $recipe['r_title_en'] }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Recipe details (if available) -->
            <x-card title="Recipe Details" class="mt-6">
                @if(isset($recipeDetail) && $recipeDetail)
                    <!-- Button: Edit recipe details -->
                    <div class="mb-4 flex justify-end">
                        <x-button href="{{ route('recipedetails.edit', $recipe['r_id']) }}" variant="secondary" size="sm">
                            <!-- Edit icon -->
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Details
                        </x-button>
                    </div>
                    <!-- Recipe detail fields -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <!-- Recipe Detail ID -->
                            <h4 class="text-sm font-medium text-gray-400 mb-2">ID</h4>
                            <p>{{ $recipeDetail['rd_id'] }}</p>

                            <!-- Description in Indonesian -->
                            <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (Indonesia)</h4>
                            <p>{!! $recipeDetail['rd_desc_id'] ?? '-' !!}</p>
                            
                            <!-- Ingredients in Indonesian -->
                            <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Ingredients (Indonesia)</h4>
                            <p>{!! $recipeDetail['rd_ingredients_id'] ?? '-' !!}</p>
                            
                            <!-- Cooking instructions in Indonesian -->
                            <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Cooking Instructions (Indonesia)</h4>
                            <p>{!! $recipeDetail['rd_cook_id'] ?? '-' !!}</p>
                        </div>
                        
                        <div>
                            <!-- Recipe Detail: ID Recipe -->
                            <h4 class="text-sm font-medium text-gray-400 mb-2">ID Recipe</h4>
                            <p>{{ $recipeDetail['rd_id_recipe'] }}</p>

                            <!-- Description in English -->
                            <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Description (English)</h4>
                            <p>{!! $recipeDetail['rd_desc_en'] ?? '-' !!}</p>
                            
                            <!-- Ingredients in English -->
                            <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Ingredients (English)</h4>
                            <p>{!! $recipeDetail['rd_ingredients_en'] ?? '-' !!}</p>
                            
                            <!-- Cooking instructions in English -->
                            <h4 class="text-sm font-medium text-gray-400 mt-4 mb-2">Cooking Instructions (English)</h4>
                            <p>{!! $recipeDetail['rd_cook_en'] ?? '-' !!}</p>
                        </div>
                    </div>
                @else
                    <!-- If no recipe details exist, show message and add button -->
                    <div class="text-center py-6">
                        <p class="text-gray-400 mb-4">No detailed information available for this recipe.</p>
                        <!-- Button: Add recipe details -->
                        <x-button href="{{ route('recipedetails.create', $recipe['r_id']) }}" variant="primary">
                            <!-- Add icon -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Recipe Details
                        </x-button>
                    </div>
                @endif
            </x-card>
        </div>
        
        <!-- Sidebar: Recipe image, video, and metadata -->
        <div class="lg:col-span-1">
            <!-- Card: Recipe image -->
            <x-card title="Image">
                @if(!empty($recipe['r_image']))
                    <div class="mb-4">
                        <!-- Recipe image -->
                        <img src="{{ $recipe['r_image'] }}" alt="{{ $recipe['r_title_id'] }}" class="w-full rounded-md">
                    </div>
                @else
                    <!-- Placeholder if no image -->
                    <div class="flex items-center justify-center h-48 bg-gray-800 rounded-md">
                        <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-center text-sm text-gray-400 mt-2">No image available</p>
                @endif
            </x-card>
            
            <!-- Card: YouTube video if available -->
            @if(isset($recipeDetail) && $recipeDetail && !empty($recipeDetail['rd_link_youtube']))
                <x-card title="Video" class="mt-6">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-800 rounded-md overflow-hidden">
                        <iframe 
                            src="{{ str_replace('watch?v=', 'embed/', $recipeDetail['rd_link_youtube']) }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="w-full h-full"
                        ></iframe>
                    </div>
                </x-card>
            @endif
            
            <!-- Card: Recipe metadata (created/updated info) -->
            <x-card title="Metadata" class="mt-6">
                <div class="text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created at</span>
                        <span>{{ isset($recipe['r_created_at']) ? date('d M Y H:i', strtotime($recipe['r_created_at'])) : '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created by</span>
                        <span>
                            @if(isset($recipe['created_by']) && isset($recipe['created_by']['name']))
                                {{ $recipe['created_by']['name'] }}
                            @else
                                {{ $recipe['r_created_by'] ?? '-' }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated at</span>
                        <span>{{ isset($recipe['r_updated_at']) ? date('d M Y H:i', strtotime($recipe['r_updated_at'])) : '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated by</span>
                        <span>
                            @if(isset($recipe['updated_by']) && isset($recipe['updated_by']['name']))
                                {{ $recipe['updated_by']['name'] }}
                            @else
                                {{ $recipe['r_updated_by'] ?? '-' }}
                            @endif
                        </span>
                    </div>
                </div>
            </x-card>
            
            <!-- Card: Recipe detail metadata (created/updated info for details) -->
            @if(isset($recipeDetail) && $recipeDetail)
                <x-card title="Recipe Detail Metadata" class="mt-6">
                    <div class="text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-700">
                            <span class="text-gray-400">Created at</span>
                            <span>{{ isset($recipeDetail['rd_created_at']) ? date('d M Y H:i', strtotime($recipeDetail['rd_created_at'])) : '-' }}</span>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-700">
                            <span class="text-gray-400">Created by</span>
                            <span>
                                @if(isset($recipeDetail['created_by']) && isset($recipeDetail['created_by']['name']))
                                    {{ $recipeDetail['created_by']['name'] }}
                                @else
                                    {{ $recipeDetail['rd_created_by'] ?? '-' }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-700">
                            <span class="text-gray-400">Updated at</span>
                            <span>{{ isset($recipeDetail['rd_updated_at']) ? date('d M Y H:i', strtotime($recipeDetail['rd_updated_at'])) : '-' }}</span>
                        </div>
                        
                        <div class="flex justify-between py-2 border-b border-gray-700">
                            <span class="text-gray-400">Updated by</span>
                            <span>
                                @if(isset($recipeDetail['updated_by']) && isset($recipeDetail['updated_by']['name']))
                                    {{ $recipeDetail['updated_by']['name'] }}
                                @else
                                    {{ $recipeDetail['rd_updated_by'] ?? '-' }}
                                @endif
                            </span>
                        </div>
                    </div>
                </x-card>
            @endif
        </div>
    </div>
@endsection