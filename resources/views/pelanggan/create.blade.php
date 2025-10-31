{{-- resources/views/menu/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tambah Pelanggan Baru</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="namapelanggan" class="block text-gray-700 font-semibold mb-2">Nama Pelanggan</label>
                <input 
                    type="text" 
                    id="namapelanggan" 
                    name="namapelanggan" 
                    value="{{ old('namapelanggan') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('namapelanggan') border-red-500 @enderror"
                    required
                >
                @error('namapelanggan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="alamat" class="block text-gray-700 font-semibold mb-2">Alamat</label>
                <input 
                    type="text" 
                    id="alamat" 
                    name="alamat" 
                    value="{{ old('alamat') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror"
                    required
                    min="0"
                >
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="nomortelepon" class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                <input 
                    type="number" 
                    id="nomortelepon" 
                    name="nomortelepon" 
                    value="{{ old('nomortelepon') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nomortelepon') border-red-500 @enderror"
                    required
                    min="0"
                >
                @error('nomortelepon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('pelanggan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
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