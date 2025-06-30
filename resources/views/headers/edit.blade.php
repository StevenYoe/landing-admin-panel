@extends('layouts.app')

@section('title', 'Edit Header - Pazar Website Admin')

@section('page-title', 'Edit Header')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('headers.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('headers.update', $header['h_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.textarea 
                        name="h_title_id" 
                        label="Judul (Indonesia)" 
                        placeholder="Masukkan judul dalam Bahasa Indonesia" 
                        :value="old('h_title_id', $header['h_title_id'])"
                        required
                        rows="4"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="h_title_en" 
                        label="Judul (Inggris)" 
                        placeholder="Masukkan judul dalam Bahasa Inggris" 
                        :value="old('h_title_en', $header['h_title_en'])"
                        required
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.input 
                        name="h_description_id" 
                        label="Deskripsi (Indonesia)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Indonesia" 
                        :value="old('h_description_id', $header['h_description_id'])"
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.input 
                        name="h_description_en" 
                        label="Deskripsi (Inggris)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Inggris" 
                        :value="old('h_description_en', $header['h_description_en'])"
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="h_page_name" 
                        label="Nama Halaman" 
                        placeholder="Masukkan Nama Halaman" 
                        :value="old('h_page_name', $header['h_page_name'])"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div class="md:col-span-2">
                <label for="h_image" class="block text-sm font-medium mb-2">Gambar Header</label>
                    <input type="file" name="h_image" id="h_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                    
                    @if(!empty($header['h_image']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Gambar Header Saat Ini:</p>
                            <img src="{{ $header['h_image'] }}" alt="Header Image" class="h-32 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('headers.index') }}" variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Perbarui
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
