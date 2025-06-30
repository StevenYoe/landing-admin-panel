@extends('layouts.app')

@section('title', 'Edit Footer - Pazar Website Admin')

@section('page-title', 'Edit Footer')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('footers.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('footers.update', $footer['f_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="f_type" 
                        label="Tipe Footer" 
                        placeholder="Masukkan tipe footer" 
                        :value="old('f_type', $footer['f_type'])"
                        required
                        helper="Contoh: link, social, contact, dll. Maksimal 50 karakter"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <label for="f_icon" class="block text-sm font-medium mb-2">Icon</label>
                    <input type="file" name="f_icon" id="f_icon" accept="image/svg+xml,image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload SVG, JPG, PNG, atau GIF (max 2MB)</p>
                    
                    @if(!empty($footer['f_icon']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Icon Saat Ini:</p>
                            <img src="{{ $footer['f_icon'] }}" alt="Icon" class="h-32 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
                
                <div>
                    <x-form.input 
                        name="f_label_id" 
                        label="Label (Indonesia)" 
                        placeholder="Masukkan label dalam Bahasa Indonesia" 
                        :value="old('f_label_id', $footer['f_label_id'])"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="f_label_en" 
                        label="Label (Inggris)" 
                        placeholder="Masukkan label dalam Bahasa Inggris" 
                        :value="old('f_label_en', $footer['f_label_en'])"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.input 
                        name="f_link" 
                        label="Link" 
                        placeholder="Masukkan link (URL)" 
                        :value="old('f_link', $footer['f_link'])"
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.textarea 
                        name="f_description_id" 
                        label="Deskripsi (Indonesia)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Indonesia" 
                        :value="old('f_description_id', $footer['f_description_id'])"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.textarea 
                        name="f_description_en" 
                        label="Deskripsi (Inggris)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Inggris" 
                        :value="old('f_description_en', $footer['f_description_en'])"
                        rows="4"
                    />
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('footers.index') }}" variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Perbarui
                </x-button>
            </div>
        </form>
    </x-card>
@endsection