@extends('layouts.app')

@section('title', 'Edit Sertifikasi - Pazar Website Admin')

@section('page-title', 'Edit Sertifikasi')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('certifications.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('certifications.update', $certification['c_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="c_label_id" 
                        label="Label (Indonesia)" 
                        placeholder="Masukkan label dalam Bahasa Indonesia" 
                        :value="old('c_label_id', $certification['c_label_id'])"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="c_label_en" 
                        label="Label (Inggris)" 
                        placeholder="Masukkan label dalam Bahasa Inggris" 
                        :value="old('c_label_en', $certification['c_label_en'])"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="c_title_id" 
                        label="Judul (Indonesia)" 
                        placeholder="Masukkan judul dalam Bahasa Indonesia" 
                        :value="old('c_title_id', $certification['c_title_id'])"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="c_title_en" 
                        label="Judul (Inggris)" 
                        placeholder="Masukkan judul dalam Bahasa Inggris" 
                        :value="old('c_title_en', $certification['c_title_en'])"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.textarea 
                        name="c_description_id" 
                        label="Deskripsi (Indonesia)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Indonesia" 
                        :value="old('c_description_id', $certification['c_description_id'])"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.textarea 
                        name="c_description_en" 
                        label="Deskripsi (Inggris)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Inggris" 
                        :value="old('c_description_en', $certification['c_description_en'])"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <label for="c_image" class="block text-sm font-medium mb-2">Gambar Sertifikasi</label>
                    <input type="file" name="c_image" id="c_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                    
                    @if(!empty($certification['c_image']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Gambar Sertifikasi Saat Ini:</p>
                            <img src="{{ $certification['c_image'] }}" alt="Certification Image" class="h-32 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('certifications.index') }}" variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Perbarui
                </x-button>
            </div>
        </form>
    </x-card>
@endsection