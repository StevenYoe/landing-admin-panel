@extends('layouts.app')

@section('title', 'Edit Recipe Details - Pazar Website Admin')

@section('page-title', 'Edit Recipe Details')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('recipes.show', $recipe['r_id']) }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Recipe
        </x-button>
    </div>
    
    <x-card>
        <div class="mb-6 px-4 py-3 bg-gray-700 rounded-md">
            <h3 class="font-semibold text-lg">Recipe: {{ $recipe['r_title_id'] }}</h3>
            <p class="text-gray-400 text-sm mt-1">ID: {{ $recipe['r_id'] }}</p>
        </div>
        
        <form action="{{ route('recipedetails.update', $recipeDetail['rd_id']) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="rd_id_recipe" value="{{ $recipe['r_id'] }}">
            
            <div class="grid grid-cols-1 gap-6">
                <div class="md:col-span-1">
                    <h4 class="font-medium mb-4 pb-2 border-b border-gray-700">Description</h4>
                    
                    <div class="mb-6">
                        <x-form.textarea 
                            name="rd_desc_id" 
                            label="Description (Indonesia)" 
                            placeholder="Enter description in Indonesian" 
                            :value="old('rd_desc_id', $recipeDetail['rd_desc_id'] ?? '')"
                            rows="6"
                            helper="You can use HTML tags for formatting"
                        />
                    </div>
                    
                    <div>
                        <x-form.textarea 
                            name="rd_desc_en" 
                            label="Description (English)" 
                            placeholder="Enter description in English" 
                            :value="old('rd_desc_en', $recipeDetail['rd_desc_en'] ?? '')"
                            rows="6"
                            helper="You can use HTML tags for formatting"
                        />
                    </div>
                </div>
                
                <div class="md:col-span-1">
                    <h4 class="font-medium mb-4 pb-2 border-b border-gray-700">Ingredients</h4>
                    
                    <div class="mb-6">
                        <x-form.textarea 
                            name="rd_ingredients_id" 
                            label="Ingredients (Indonesia)" 
                            placeholder="Enter ingredients in Indonesian" 
                            :value="old('rd_ingredients_id', $recipeDetail['rd_ingredients_id'] ?? '')"
                            rows="6"
                            helper="You can use HTML tags for formatting"
                        />
                    </div>
                    
                    <div>
                        <x-form.textarea 
                            name="rd_ingredients_en" 
                            label="Ingredients (English)" 
                            placeholder="Enter ingredients in English" 
                            :value="old('rd_ingredients_en', $recipeDetail['rd_ingredients_en'] ?? '')"
                            rows="6"
                            helper="You can use HTML tags for formatting"
                        />
                    </div>
                </div>
                
                <div class="md:col-span-1">
                    <h4 class="font-medium mb-4 pb-2 border-b border-gray-700">Cooking Instructions</h4>
                    
                    <div class="mb-6">
                        <x-form.textarea 
                            name="rd_cook_id" 
                            label="Cooking Instructions (Indonesia)" 
                            placeholder="Enter cooking instructions in Indonesian" 
                            :value="old('rd_cook_id', $recipeDetail['rd_cook_id'] ?? '')"
                            rows="6"
                            helper="You can use HTML tags for formatting"
                        />
                    </div>
                    
                    <div>
                        <x-form.textarea 
                            name="rd_cook_en" 
                            label="Cooking Instructions (English)" 
                            placeholder="Enter cooking instructions in English" 
                            :value="old('rd_cook_en', $recipeDetail['rd_cook_en'] ?? '')"
                            rows="6"
                            helper="You can use HTML tags for formatting"
                        />
                    </div>
                </div>
                
                <div class="md:col-span-1">
                    <h4 class="font-medium mb-4 pb-2 border-b border-gray-700">Video Link</h4>
                    
                    <div>
                        <x-form.input 
                            name="rd_link_youtube" 
                            label="YouTube Link" 
                            placeholder="Enter YouTube video link" 
                            :value="old('rd_link_youtube', $recipeDetail['rd_link_youtube'] ?? '')"
                            helper="Full URL including https://"
                        />
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('recipes.show', $recipe['r_id']) }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection