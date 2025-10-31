{{-- resources/views/menu/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tambah Menu Baru</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('menu.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="namamenu" class="block text-gray-700 font-semibold mb-2">Nama Menu</label>
                <input 
                    type="text" 
                    id="namamenu" 
                    name="namamenu" 
                    value="{{ old('namamenu') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('namamenu') border-red-500 @enderror"
                    required
                >
                @error('namamenu')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="harga" class="block text-gray-700 font-semibold mb-2">Harga</label>
                <input 
                    type="number" 
                    id="harga" 
                    name="harga" 
                    value="{{ old('harga') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('harga') border-red-500 @enderror"
                    required
                    min="0"
                >
                @error('harga')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('menu.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection