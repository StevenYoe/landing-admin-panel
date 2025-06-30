@extends('layouts.app')

@section('title', 'Product Catalogs - Pazar Website Admin')

@section('page-title', 'Product Catalogs')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Product Catalog List</h2>
        <x-button href="{{ route('productcatalogs.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Product Catalog
        </x-button>
    </div>
    
    <x-card>
        @if(count($catalogs) > 0)
            <div class="overflow-x-auto">
                <x-table 
                    :headers="[
                        ['name' => 'ID', 'key' => 'pct_id'],
                        ['name' => 'Indonesian Catalog', 'key' => 'pct_catalog_id'],
                        ['name' => 'English Catalog', 'key' => 'pct_catalog_en'],
                        ['name' => 'Created At', 'key' => 'pct_created_at']
                    ]"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                >
                    @foreach($catalogs as $catalog)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-600">
                            <td class="px-5 py-4 text-center">{{ $catalog['pct_id'] }}</td>
                            <td class="px-5 py-4 text-center">
                                @if(!empty($catalog['pct_catalog_id']))
                                    <a href="{{ $catalog['pct_catalog_id'] }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if(!empty($catalog['pct_catalog_en']))
                                    <a href="{{ $catalog['pct_catalog_en'] }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                {{ isset($catalog['pct_created_at']) ? date('d M Y H:i', strtotime($catalog['pct_created_at'])) : '-' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('productcatalogs.show', $catalog['pct_id']) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('productcatalogs.edit', $catalog['pct_id']) }}" class="text-yellow-500 hover:text-yellow-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('productcatalogs.destroy', $catalog['pct_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product catalog?');">
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
                <p class="text-gray-400">No product catalogs have been added yet</p>
                <x-button href="{{ route('productcatalogs.create') }}" variant="primary" class="mt-4">
                    Add Product Catalog
                </x-button>
            </div>
        @endif
    </x-card>
@endsection