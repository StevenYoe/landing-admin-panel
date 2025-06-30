@extends('layouts.app')

@section('title', 'Add Popup - Pazar Website Admin')

@section('page-title', 'Tambah Popup')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('popups.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('popups.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <x-form.input 
                        name="pu_link" 
                        label="Link" 
                        placeholder="Masukkan link (URL)" 
                        :value="old('pu_link')"
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <!-- Hidden field to always set pu_is_active as false for new popups -->
                <input type="hidden" name="pu_is_active" value="0">
                
                <div class="md:col-span-2">
                <label for="pu_image" class="block text-sm font-medium mb-2">Gambar Pop Up</label>
                    <input type="file" name="pu_image" id="pu_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('popups.index') }}" variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Simpan
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
