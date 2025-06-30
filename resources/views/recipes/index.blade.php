@extends('layouts.app')

@section('title', 'Recipes - Pazar Website Admin')

@section('page-title', 'Recipes')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Recipe List</h2>
        <x-button href="{{ route('recipes.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Recipe
        </x-button>
    </div>
    
    <x-card>
        <div class="mb-4">
            <form action="{{ route('recipes.index') }}" method="GET" class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="w-full sm:w-1/3">
                    <x-form.select 
                        name="category_id" 
                        label="Filter by Category" 
                        :options="collect($categories)->pluck('rc_title_id', 'rc_id')->toArray()" 
                        :selected="$categoryId ?? ''"
                        placeholder="All Categories"
                        class="mb-0"
                    />
                </div>
                <div class="flex items-end space-x-2 pt-5">
                    <x-button type="submit" variant="secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </x-button>
                    @if($categoryId)
                        <x-button href="{{ route('recipes.index') }}" variant="outline">
                            Clear
                        </x-button>
                    @endif
                </div>
            </form>
        </div>
        
        @if(count($recipes) > 0)
            <div class="overflow-x-auto">
                <x-table 
                    :headers="[
                        ['name' => 'ID', 'key' => 'r_id'],
                        ['name' => 'Name (ID)', 'key' => 'r_title_id'],
                        ['name' => 'Name (EN)', 'key' => 'r_title_en'],
                        ['name' => 'Categories', 'key' => ''],
                        ['name' => 'Status', 'key' => 'r_is_active'],
                        ['name' => 'Image', 'key' => 'r_image']
                    ]"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                >
                    @foreach($recipes as $recipe)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                            <td class="px-5 py-4 text-center">{{ $recipe['r_id'] }}</td>
                            <td class="px-5 py-4">{{ $recipe['r_title_id'] }}</td>
                            <td class="px-5 py-4">{{ $recipe['r_title_en'] }}</td>
                            <td class="px-5 py-4">
                                @if(isset($recipe['categories']) && is_array($recipe['categories']))
                                    <div class="flex justify-center flex-wrap gap-1">
                                        @foreach($recipe['categories'] as $category)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-700 text-white">
                                                {{ $category['rc_title_id'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if(isset($recipe['r_is_active']))
                                    <span class="px-2 py-1 text-xs rounded-full {{ $recipe['r_is_active'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                        {{ $recipe['r_is_active'] ? 'Active' : 'Inactive' }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if(!empty($recipe['r_image']))
                                    <img src="{{ $recipe['r_image'] }}" alt="{{ $recipe['r_title_id'] }}" class="h-12 w-auto mx-auto">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('recipes.show', $recipe['r_id']) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('recipes.edit', $recipe['r_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('recipes.destroy', $recipe['r_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
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
            @if(isset($paginator))
                <div class="mt-4">
                    {{ $paginator->links() }}
                </div>
            @endif
        @else
            <div class="py-8 text-center">
                <p class="text-gray-400">No recipes have been added yet</p>
                <x-button href="{{ route('recipes.create') }}" variant="primary" class="mt-4">
                    Add Recipe
                </x-button>
            </div>
        @endif
    </x-card>
@endsection