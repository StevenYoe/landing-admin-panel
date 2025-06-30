@extends('layouts.app')

@section('title', 'Tambah Work At Pazar - Pazar Website Admin')

@section('page-title', 'Tambah Work At Pazar')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('workatpazars.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('workatpazars.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="wap_title_id" 
                        label="Judul (Indonesia)" 
                        placeholder="Masukkan judul dalam Bahasa Indonesia" 
                        :value="old('wap_title_id')"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="wap_title_en" 
                        label="Judul (Inggris)" 
                        placeholder="Masukkan judul dalam Bahasa Inggris" 
                        :value="old('wap_title_en')"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="wap_description_id" 
                        label="Deskripsi (Indonesia)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Indonesia (opsional)" 
                        :value="old('wap_description_id')"
                        rows="4"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="wap_description_en" 
                        label="Deskripsi (Inggris)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Inggris (opsional)" 
                        :value="old('wap_description_en')"
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.input 
                        name="wap_type" 
                        label="Tipe" 
                        placeholder="Masukkan tipe Work At Pazar" 
                        :value="old('wap_type')"
                        required
                    />
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('workatpazars.index') }}" variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Simpan
                </x-button>
            </div>
        </form>
    </x-card>
@endsection