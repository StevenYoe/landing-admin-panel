@extends('layouts.app')

@section('title', 'Detail Work At Pazar - Pazar Website Admin')

@section('page-title', 'Detail Work At Pazar')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <x-button href="{{ route('workatpazars.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </x-button>
        
        <div class="flex justify-center space-x-2">
            <x-button href="{{ route('workatpazars.edit', $workAtPazar['wap_id']) }}" variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </x-button>
            
            <form action="{{ route('workatpazars.destroy', $workAtPazar['wap_id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item Work At Pazar ini?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </x-button>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 gap-6">
        <x-card title="Informasi Work At Pazar">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <h4 class="text-sm font-medium text-gray-400">ID</h4>
                    <p>{{ $workAtPazar['wap_id'] }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-400">Tipe</h4>
                    <p>{{ $workAtPazar['wap_type'] }}</p>
                </div>
            </div>
        </x-card>
        
        <x-card title="Judul">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <h4 class="text-sm font-medium text-gray-400 mb-2">Judul (Indonesia)</h4>
                    <p>{{ $workAtPazar['wap_title_id'] }}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-400 mb-2">Judul (Inggris)</h4>
                    <p>{{ $workAtPazar['wap_title_en'] }}</p>
                </div>
            </div>
        </x-card>
        
        <x-card title="Deskripsi">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <h4 class="text-sm font-medium text-gray-400 mb-2">Deskripsi (Indonesia)</h4>
                    @if(!empty($workAtPazar['wap_description_id']))
                        <p>{{ $workAtPazar['wap_description_id'] }}</p>
                    @else
                        <p class="text-gray-400 italic">Tidak ada deskripsi</p>
                    @endif
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-400 mb-2">Deskripsi (Inggris)</h4>
                    @if(!empty($workAtPazar['wap_description_en']))
                        <p>{{ $workAtPazar['wap_description_en'] }}</p>
                    @else
                        <p class="text-gray-400 italic">Tidak ada deskripsi</p>
                    @endif
                </div>
            </div>
        </x-card>
    </div>
@endsection