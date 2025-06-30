@extends('layouts.app')

@section('title', 'Edit Testimonial - Pazar Website Admin')

@section('page-title', 'Edit Testimonial')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('testimonials.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('testimonials.update', $testimonial['t_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <x-form.input 
                        name="t_name" 
                        label="Nama" 
                        placeholder="Masukkan nama" 
                        :value="old('t_name', $testimonial['t_name'])"
                        required
                        helper="Maksimal 255 karakter"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="t_description_id" 
                        label="Deskripsi (Indonesia)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Indonesia" 
                        :value="old('t_description_id', $testimonial['t_description_id'])"
                        required
                        rows="4"
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="t_description_en" 
                        label="Deskripsi (Inggris)" 
                        placeholder="Masukkan deskripsi dalam Bahasa Inggris" 
                        :value="old('t_description_en', $testimonial['t_description_en'])"
                        required
                        rows="4"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <x-form.input 
                        name="t_type" 
                        label="Tipe" 
                        placeholder="Masukkan tipe testimonial" 
                        :value="old('t_type', $testimonial['t_type'])"
                        required
                        helper="Maksimal 50 karakter"
                    />
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Gender</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input id="t_gender_male" name="t_gender" type="radio" value="Male" class="h-4 w-4 text-accent focus:ring-accent-light border-gray-600" {{ (old('t_gender', $testimonial['t_gender']) == 'Male') ? 'checked' : '' }} required>
                            <label for="t_gender_male" class="ml-2 block text-sm font-medium">
                                Laki-laki
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="t_gender_female" name="t_gender" type="radio" value="Female" class="h-4 w-4 text-accent focus:ring-accent-light border-gray-600" {{ (old('t_gender', $testimonial['t_gender']) == 'Female') ? 'checked' : '' }}>
                            <label for="t_gender_female" class="ml-2 block text-sm font-medium">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label for="t_image" class="block text-sm font-medium mb-2">Gambar Testimonial</label>
                    <input type="file" name="t_image" id="t_image" accept="image/*"
                        class="block w-full text-sm text-gray-400 border border-gray-600 rounded-md 
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-medium
                        file:bg-accent file:text-white
                        hover:file:bg-accent-dark">
                    <p class="mt-1 text-xs text-gray-400">Upload JPG, PNG, or GIF (max 2MB)</p>
                    
                    @if(!empty($testimonial['t_image']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-2">Gambar Testimonial Saat Ini:</p>
                            <img src="{{ $testimonial['t_image'] }}" alt="Testimonial Image" class="h-32 w-auto border border-gray-700 rounded-md">
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('testimonials.index') }}" variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Perbarui
                </x-button>
            </div>
        </form>
    </x-card>
@endsection