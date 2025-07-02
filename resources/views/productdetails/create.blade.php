<!--
    Add Product Details Page
    This Blade view provides a form for adding detailed information to a specific product in the admin panel.
    Includes fields for net weight, long descriptions, and e-commerce links, using custom Blade components for UI consistency.
-->
@extends('layouts.app')

@section('title', 'Add Product Details - Pazar Website Admin')

@section('page-title', 'Add Product Details')

@section('content')
    <!--
        Back to Product button: Navigates back to the product details page.
    -->
    <div class="mb-6">
        <x-button href="{{ route('products.show', $product['p_id']) }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Product
        </x-button>
    </div>
    <!--
        Card container for the product details creation form.
    -->
    <x-card>
        <!--
            Product summary: Shows the product name and ID for context.
        -->
        <div class="mb-6 px-4 py-3 bg-gray-700 rounded-md">
            <h3 class="font-semibold text-lg">Product: {{ $product['p_title_id'] }}</h3>
            <p class="text-gray-400 text-sm mt-1">ID: {{ $product['p_id'] }}</p>
        </div>
        <!--
            Form to add product details.
            Submits to the productdetails.store route using POST method.
        -->
        <form action="{{ route('productdetails.store', $product['p_id']) }}" method="POST">
            @csrf
            <!--
                Form fields for product details and e-commerce links.
            -->
            <div class="grid grid-cols-1 gap-6">
                <div class="md:col-span-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <!-- Input for net weight -->
                            <x-form.input 
                                name="pd_net_weight" 
                                label="Net Weight" 
                                placeholder="Enter Net Weight" 
                                :value="old('pd_net_weight')"
                            />
                        </div>
                        <div>
                            <!-- Textarea for long description in Indonesian -->
                            <x-form.textarea 
                                name="pd_longdesc_id" 
                                label="Long Description (Indonesia)" 
                                placeholder="Enter long description in Indonesian" 
                                :value="old('pd_longdesc_id')"
                                rows="6"
                            />
                        </div>
                        <div>
                            <!-- Textarea for long description in English -->
                            <x-form.textarea 
                                name="pd_longdesc_en" 
                                label="Long Description (English)" 
                                placeholder="Enter long description in English" 
                                :value="old('pd_longdesc_en')"
                                rows="6"
                            />
                        </div>
                    </div>
                </div>
                <div class="md:col-span-1">
                    <!--
                        Section for e-commerce product links.
                    -->
                    <h4 class="font-medium mb-4 pb-2 border-b border-gray-700">E-commerce Links</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <!-- Input for Shopee link -->
                            <x-form.input 
                                name="pd_link_shopee" 
                                label="Shopee Link" 
                                placeholder="Enter Shopee product link" 
                                :value="old('pd_link_shopee')"
                                helper="Full URL including https://"
                            />
                        </div>
                        <div>
                            <!-- Input for Tokopedia link -->
                            <x-form.input 
                                name="pd_link_tokopedia" 
                                label="Tokopedia Link" 
                                placeholder="Enter Tokopedia product link" 
                                :value="old('pd_link_tokopedia')"
                                helper="Full URL including https://"
                            />
                        </div>
                        <div>
                            <!-- Input for Blibli link -->
                            <x-form.input 
                                name="pd_link_blibli" 
                                label="Blibli Link" 
                                placeholder="Enter Blibli product link" 
                                :value="old('pd_link_blibli')"
                                helper="Full URL including https://"
                            />
                        </div>
                        <div>
                            <!-- Input for Lazada link -->
                            <x-form.input 
                                name="pd_link_lazada" 
                                label="Lazada Link" 
                                placeholder="Enter Lazada product link" 
                                :value="old('pd_link_lazada')"
                                helper="Full URL including https://"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <!--
                Action buttons: Cancel returns to the product page, Save submits the form.
            -->
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('products.show', $product['p_id']) }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
