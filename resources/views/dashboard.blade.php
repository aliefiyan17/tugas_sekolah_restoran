@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto ">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h2>
    
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-xl font-semibold mb-4">Selamat Datang, {{ auth()->user()->namalengkap }}!</h3>
        <p class="text-gray-600">Role: <span class="font-semibold text-blue-600">{{ ucfirst(auth()->user()->role) }}</span></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @if(auth()->user()->isAdministrator())
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100">Total Menu</p>
                        <h4 class="text-3xl font-bold">{{ \App\Models\Menu::count() }}</h4>
                    </div>
                    <i class="fas fa-utensils text-5xl text-blue-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100">Meja Tersedia</p>
                        <h4 class="text-3xl font-bold">{{ \App\Models\Meja::where('status', 'tersedia')->count() }}</h4>
                    </div>
                    <i class="fas fa-chair text-5xl text-purple-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100">Total Pelanggan</p>
                        <h4 class="text-3xl font-bold">{{ \App\Models\Pelanggan::count() }}</h4>
                    </div>
                    <i class="fas fa-users text-5xl text-green-200"></i>
                </div>
            </div>
        @endif

        @if(auth()->user()->isWaiter() || auth()->user()->isAdministrator())
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-500 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100">Pesanan Pending</p>
                        <h4 class="text-3xl font-bold">{{ \App\Models\Pesanan::whereNull('idtransaksi')->count() }}</h4>
                    </div>
                    <i class="fas fa-clipboard-list text-5xl text-yellow-200"></i>
                </div>
            </div>
        @endif

        @if(auth()->user()->isKasir() || auth()->user()->isAdministrator())
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100">Transaksi Hari Ini</p>
                        <h4 class="text-3xl font-bold">{{ \App\Models\Transaksi::whereDate('tglTransaksi', today())->count() }}</h4>
                    </div>
                    <i class="fas fa-cash-register text-5xl text-purple-200"></i>
                </div>
            </div>
        @endif

        @if(auth()->user()->isOwner() || auth()->user()->isAdministrator())
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white">Pendapatan Hari Ini</p>
                        <h4 class="text-2xl font-bold">Rp {{ number_format(\App\Models\Transaksi::whereDate('tglTransaksi', today())->sum('totalHarga'), 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-chart-line text-5xl text-white-200"></i>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4">Menu Akses Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @if(auth()->user()->isAdministrator())
                <a href="{{ route('menu.index') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition">
                    <i class="fas fa-utensils text-3xl text-blue-600 mb-2"></i>
                    <p class="font-semibold">Kelola Menu</p>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition">
                    <i class="fas fa-users text-3xl text-green-600 mb-2"></i>
                    <p class="font-semibold">Kelola Pelanggan</p>
                </a>
                <a href="{{ route('meja.index') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center transition">
                    <i class="fas fa-chair text-3xl text-purple-600 mb-2"></i>
                    <p class="font-semibold">Kelola Meja</p>
                </a>
            @endif
            
            @if(auth()->user()->isWaiter())
                <a href="{{ route('pesanan.create') }}" class="bg-yellow-50 hover:bg-yellow-100 p-4 rounded-lg text-center transition">
                    <i class="fas fa-plus-circle text-3xl text-yellow-600 mb-2"></i>
                    <p class="font-semibold">Buat Pesanan</p>
                </a>
            @endif
            
            @if(auth()->user()->isKasir())
                <a href="{{ route('transaksi.create') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center transition">
                    <i class="fas fa-cash-register text-3xl text-purple-600 mb-2"></i>
                    <p class="font-semibold">Proses Transaksi</p>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection