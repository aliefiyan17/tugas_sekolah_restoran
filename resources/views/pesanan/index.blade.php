@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-bold text-black">
                Daftar Pesanan
            </h2>
            <p class="text-gray-600 mt-2">Kelola pesanan pelanggan yang belum di-transaksi</p>
        </div>
        <a href="{{ route('pesanan.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-600 hover:from-blue-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl shadow-lg transform hover:scale-105 transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Pesanan
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 text-sm">
    <!-- Total Pesanan Pending -->
    <div class="bg-yellow-500 rounded-lg shadow-md p-4 text-white transform hover:scale-105 transition duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-lg font-medium opacity-90 ">Total Pesanan Pending</p>
                <h3 class="text-xl font-bold mt-1">{{ $pesanans->total() }}</h3>
            </div>
            <div class="bg-yellow-500 bg-opacity-30 rounded-full p-3">
                <i class="fas fa-clipboard-list text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Item -->
    <div class="bg-red-400 rounded-lg shadow-md p-4 text-white transform hover:scale-105 transition duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-lg font-medium opacity-90">Total Item</p>
                <h3 class="text-xl font-bold mt-1">{{ $pesanans->sum('jumlah') }}</h3>
            </div>
            <div class="bg-red-400 bg-opacity-30  p-3">
                <i class="fas fa-boxes text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Nilai -->
    <div class="bg-secondary rounded-lg shadow-md p-4 text-white transform hover:scale-105 transition duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-lg font-medium opacity-90">Total Nilai</p>
                <h3 class="text-lg font-bold mt-1">Rp {{ number_format($pesanans->sum('totalharga'), 0, ',', '.') }}</h3>
            </div>
            <div class="bg-secondary bg-opacity-30 rounded-full p-3">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
        </div>
    </div>
</div>


    <!-- Pesanan Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-gray-600 to-gray-600 p-6">
            <h3 class="text-2xl font-bold text-white">
                <i class="fas mr-2"></i>List Pesanan Aktif
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Menu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Meja</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pesanans as $index => $pesanan)
                        <tr class="hover:bg-blue-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $pesanans->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-[#D4AF37] flex items-center justify-center text-white font-bold">
                                            {{ substr($pesanan->pelanggan->namapelanggan, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $pesanan->pelanggan->namapelanggan }}</div>
                                        @if($pesanan->pelanggan->nomortelepon)
                                            <div class="text-xs text-gray-500">{{ $pesanan->pelanggan->nomortelepon }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $pesanan->menu->namamenu }}</div>
                                <div class="text-xs text-gray-500">@ {{ $pesanan->menu->formatted_harga }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($pesanan->meja)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        <i class="fas fa-chair mr-1"></i>{{ $pesanan->meja->nomor_meja }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="fas fa-minus mr-1"></i>Tidak ada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                    {{ $pesanan->jumlah }}x
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ $pesanan->formatted_total_harga }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                <i class="fas fa-clock mr-1"></i>{{ $pesanan->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('pesanan.edit', $pesanan->idpesanan) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('pesanan.destroy', $pesanan->idpesanan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus pesanan ini?')"
                                                class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
                                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Pesanan</h3>
                                    <p class="text-gray-500 mb-4">Belum ada pesanan yang perlu diproses</p>
                                    <a href="{{ route('pesanan.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                                        <i class="fas fa-plus mr-2"></i>Buat Pesanan Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pesanans->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $pesanans->links() }}
            </div>
        @endif
    </div>

    
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    tbody tr {
        animation: fadeIn 0.3s ease-out;
    }
</style>
@endsection