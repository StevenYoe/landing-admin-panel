@extends('layouts.app')

@section('title', 'Edit Product Details - Pazar Website Admin')

@section('page-title', 'Edit Product Details')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('products.show', $product['p_id']) }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Product
        </x-button>
    </div>
    
    <x-card>
        <div class="mb-6 px-4 py-3 bg-gray-700 rounded-md">
            <h3 class="font-semibold text-lg">Product: {{ $product['p_title_id'] }}</h3>
            <p class="text-gray-400 text-sm mt-1">ID: {{ $product['p_id'] }}</p>
        </div>
        
        <form action="{{ route('productdetails.update', $productDetail['pd_id']) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="pd_id_product" value="{{ $product['p_id'] }}">
            
            <div class="grid grid-cols-1 gap-6">
                <div class="md:col-span-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-form.input 
                                name="pd_net_weight" 
                                label="Net Weight" 
                                placeholder="Enter Net Weight" 
                                :value="old('pd_net_weight', $productDetail['pd_net_weight'] ?? '')"
                            />
                        </div>
                    </div>
                    
                    <div>
                        <x-form.textarea 
                            name="pd_longdesc_id" 
                            label="Long Description (Indonesia)" 
                            placeholder="Enter long description in Indonesian" 
                            :value="old('pd_longdesc_id', $productDetail['pd_longdesc_id'] ?? '')"
                            rows="6"
                        />
                    </div>
                    
                    <div>
                        <x-form.textarea 
                            name="pd_longdesc_en" 
                            label="Long Description (English)" 
                            placeholder="Enter long description in English" 
                            :value="old('pd_longdesc_en', $productDetail['pd_longdesc_en'] ?? '')"
                            rows="6"
                        />
                    </div>
                </div>

                <div class="md:col-span-1">
                    <h4 class="font-medium mb-4 pb-2 border-b border-gray-700">E-commerce Links</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-form.input 
                                name="pd_link_shopee" 
                                label="Shopee Link" 
                                placeholder="Enter Shopee product link" 
                                :value="old('pd_link_shopee', $productDetail['pd_link_shopee'] ?? '')"
                                helper="Full URL including https://"
                            />
                        </div>
                        
                        <div>
                            <x-form.input 
                                name="pd_link_tokopedia" 
                                label="Tokopedia Link" 
                                placeholder="Enter Tokopedia product link" 
                                :value="old('pd_link_tokopedia', $productDetail['pd_link_tokopedia'] ?? '')"
                                helper="Full URL including https://"
                            />
                        </div>
                        
                        <div>
                            <x-form.input 
                                name="pd_link_blibli" 
                                label="Blibli Link" 
                                placeholder="Enter Blibli product link" 
                                :value="old('pd_link_blibli', $productDetail['pd_link_blibli'] ?? '')"
                                helper="Full URL including https://"
                            />
                        </div>
                        
                        <div>
                            <x-form.input 
                                name="pd_link_lazada" 
                                label="Lazada Link" 
                                placeholder="Enter Lazada product link" 
                                :value="old('pd_link_lazada', $productDetail['pd_link_lazada'] ?? '')"
                                helper="Full URL including https://"
                            />
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('products.show', $product['p_id']) }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
