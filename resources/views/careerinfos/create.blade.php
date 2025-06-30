@extends('layouts.app')

@section('title', 'Tambah Career Info - Pazar Website Admin')

@section('page-title', 'Tambah Career Info')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('careerinfos.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('careerinfos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="ci_title_id" 
                        label="Judul (Indonesia)" 
                        placeholder="Masukkan judul dalam Bahasa Indonesia" 
                        :value="old('ci_title_id')"
                        required
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="ci_title_en" 
                        label="Judul (Inggris)" 
                        placeholder="Masukkan judul dalam Bahasa Inggris" 
                        :value="old('ci_title_en')"
                        required
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="ci_description_id" 
                        label="Deskripsi (Indonesia)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Indonesia" 
                        :value="old('ci_description_id')"
                        rows="4"
                        required
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="ci_description_en" 
                        label="Deskripsi (Inggris)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Inggris" 
                        :value="old('ci_description_en')"
                        rows="4"
                        required
                    />
                </div>
                
                <div class="md:col-span-2">
                    <label for="ci_image" class="block text-sm font-medium mb-2">Gambar Career Info</label>
                    <input type="file" name="ci_image" id="ci_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('careerinfos.index') }}" variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Simpan
                </x-button>
            </div>
        </form>
    </x-card>
@endsection