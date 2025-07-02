<!--
    Product Catalog Details Page
    This Blade view displays detailed information about a specific product catalog in the admin panel.
    Includes catalog info, file download links, quick actions, and metadata.
-->
@extends('layouts.app')

@section('title', 'Product Catalog Details - Pazar Website Admin')

@section('page-title', 'Product Catalog Details')

@section('content')
    <!--
        Header section: Back to List button and action buttons (Edit, Delete) for the product catalog.
    -->
    <div class="mb-6 flex justify-between items-center">
        <x-button href="{{ route('productcatalogs.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
        <div class="flex justify-center space-x-2">
            <!-- Edit button: Navigates to the product catalog edit page -->
            <x-button href="{{ route('productcatalogs.edit', $catalog['pct_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            <!-- Delete button: Submits a form to delete the product catalog (with confirmation) -->
            <form action="{{ route('productcatalogs.destroy', $catalog['pct_id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product catalog?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </x-button>
            </form>
        </div>
    </div>
    <!--
        Main content: Two-column layout with catalog information, files, quick actions, and metadata.
    -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <!--
                Card with catalog information: ID and other details.
            -->
            <x-card title="Catalog Information">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400">ID</h4>
                        <p>{{ $catalog['pct_id'] }}</p>
                    </div>
                </div>
            </x-card>
            <!--
                Card with catalog files: Shows download/view links for Indonesian and English catalog files if available.
                If no files are available, shows a message and upload button.
            -->
            <x-card title="Catalog Files" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-4">Indonesian Catalog</h4>
                        @if(!empty($catalog['pct_catalog_id']))
                            <div class="border border-gray-600 rounded-lg p-4 bg-gray-800">
                                <div class="flex items-center justify-center mb-4">
                                    <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-300 mb-3">Indonesian Catalog File</p>
                                    <a href="{{ $catalog['pct_catalog_id'] }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-blue-400 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        View File
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="border border-gray-600 rounded-lg p-6 bg-gray-800 text-center">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-400">No Indonesian catalog file available</p>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-400 mb-4">English Catalog</h4>
                        @if(!empty($catalog['pct_catalog_en']))
                            <div class="border border-gray-600 rounded-lg p-4 bg-gray-800">
                                <div class="flex items-center justify-center mb-4">
                                    <svg class="w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-300 mb-3">English Catalog File</p>
                                    <a href="{{ $catalog['pct_catalog_en'] }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-green-400 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        View File
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="border border-gray-600 rounded-lg p-6 bg-gray-800 text-center">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-400">No English catalog file available</p>
                            </div>
                        @endif
                    </div>
                </div>
                <!--
                    If both catalog files are missing, show a message and upload button.
                -->
                @if(empty($catalog['pct_catalog_id']) && empty($catalog['pct_catalog_en']))
                    <div class="text-center py-6 mt-6 border-t border-gray-700">
                        <p class="text-gray-400 mb-4">No catalog files available.</p>
                        <x-button href="{{ route('productcatalogs.edit', $catalog['pct_id']) }}" variant="primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Upload Catalogs
                        </x-button>
                    </div>
                @endif
            </x-card>
        </div>
        <div class="lg:col-span-1">
            <!--
                Card with quick actions: Download links for catalog files if available.
            -->
            <x-card title="Quick Actions">
                <div class="space-y-3">
                    @if(!empty($catalog['pct_catalog_id']))
                        <a href="{{ $catalog['pct_catalog_id'] }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download ID Catalog
                        </a>
                    @endif
                    @if(!empty($catalog['pct_catalog_en']))
                        <a href="{{ $catalog['pct_catalog_en'] }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 bg-opacity-20 hover:bg-opacity-30 rounded-md text-green-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download EN Catalog
                        </a>
                    @endif
                </div>
            </x-card>
            <!--
                Card with metadata: Shows created/updated dates and users.
            -->
            <x-card title="Metadata" class="mt-6">
                <div class="text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created at</span>
                        <span>{{ isset($catalog['pct_created_at']) ? date('d M Y H:i', strtotime($catalog['pct_created_at'])) : '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Created by</span>
                        <span>
                            @if(isset($catalog['created_by']) && isset($catalog['created_by']['name']))
                                {{ $catalog['created_by']['name'] }}
                            @else
                                {{ $catalog['pct_created_by'] ?? '-' }}
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated at</span>
                        <span>{{ isset($catalog['pct_updated_at']) ? date('d M Y H:i', strtotime($catalog['pct_updated_at'])) : '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-700">
                        <span class="text-gray-400">Updated by</span>
                        <span>
                            @if(isset($catalog['updated_by']) && isset($catalog['updated_by']['name']))
                                {{ $catalog['updated_by']['name'] }}
                            @else
                                {{ $catalog['pct_updated_by'] ?? '-' }}
                            @endif
                        </span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection