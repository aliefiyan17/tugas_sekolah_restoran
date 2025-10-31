@extends('layouts.app')

@section('title', 'Tambah Pesanan Baru')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h2 class="text-4xl font-bold text-black mb-2">
            Buat Pesanan Baru
        </h2>
        <p class="text-gray-600">Tambahkan pesanan untuk pelanggan</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-[#333333] p-6">
                    <h3 class="text-2xl font-bold text-white">
                        <i class="fas fa-edit mr-2"></i>Detail Pesanan
                    </h3>
                </div>

                <form action="{{ route('pesanan.store') }}" method="POST" id="pesananForm" class="p-8">
                    @csrf
                    
                    <!-- Pelanggan -->
                    <div class="mb-6">
                        <label for="idpelanggan" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas  text-yellow-600 mr-2"></i>Pelanggan
                        </label>
                        <select 
                            id="idpelanggan" 
                            name="idpelanggan" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('idpelanggan') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->idpelanggan }}" {{ old('idpelanggan') == $pelanggan->idpelanggan ? 'selected' : '' }}>
                                    {{ $pelanggan->namapelanggan }}
                                    @if($pelanggan->nomortelepon)
                                        - {{ $pelanggan->nomortelepon }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('idpelanggan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <a href="{{ route('pelanggan.create') }}" class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">
                            <i class="fas fa-plus-circle mr-1"></i>Tambah Pelanggan Baru
                        </a>
                    </div>

                    <!-- Menu -->
                    
                    <!-- Meja -->
                    <div class="mb-6">
                            <label for="idmeja" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas text-yellow-600 mr-2"></i>Meja 
                            </label>
                            <select 
                            id="idmeja" 
                            name="idmeja" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('idmeja') border-red-500 @enderror"
                            >
                            <option value="">-- Pilih Meja (Opsional) --</option>
                            @foreach($mejas as $meja)
                            <option value="{{ $meja->idmeja }}" {{ old('idmeja') == $meja->idmeja ? 'selected' : '' }}>
                                Meja {{ $meja->nomor_meja }} - {{ $meja->kapasitas }} Orang ({{ $meja->lokasi }})
                            </option>
                            @endforeach
                        </select>
                        @error('idmeja')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @if($mejas->isEmpty())
                        <p class="text-xs text-amber-600 mt-1">
                            <i class="fas fa-exclamation-triangle mr-1"></i>Tidak ada meja tersedia saat ini
                        </p>
                        @endif
                    </div>
                
                    <!-- Daftar Menu Dinamis -->
                    <div id="menuContainer" class="space-y-6">
                        <div class="menu-item border-2 border-gray-200 rounded-xl p-4 relative bg-gray-50">
                            <button type="button" onclick="removeMenuItem(this)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 hidden">
                                <i class="fas fa-times-circle text-xl"></i>
                            </button>

                            <!-- Menu -->
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    <i class="fas  text-yellow-600 mr-2"></i>Menu
                                </label>
                                <select name="idmenu[]" onchange="updateHarga(this)" required
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 transition">
                                    <option value="">-- Pilih Menu --</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->idmenu }}" data-harga="{{ $menu->harga }}">
                                            {{ $menu->namamenu }} - {{ $menu->formatted_harga }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jumlah -->
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-bold text-gray-700">
                                    <i class="fas fa-sort-numeric-up text-yellow-600 mr-2"></i>Jumlah
                                </label>
                                <div class="flex items-center space-x-2">
                                    <button type="button" onclick="decreaseJumlah(this)"
                                        class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg font-bold text-xl">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="jumlah[]" value="1" min="1"
                                        oninput="hitungTotal()"
                                        class="w-20 text-center px-2 py-2 border-2 border-gray-300 rounded-lg text-lg font-bold focus:ring-2 focus:ring-yellow-500">
                                    <button type="button" onclick="increaseJumlah(this)"
                                        class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg font-bold text-xl">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tambah Menu -->
                    <div class="mt-4">
                        <button type="button" onclick="addMenuItem()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-semibold transition">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Menu Lain
                        </button>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between items-center pt-6 border-t-2">
                        <a href="{{ route('pesanan.index') }}" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-semibold transition transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i>Batal
                        </a>
                        <button type="submit" class="px-8 py-3 bg-[#333333] hover:from-yellow-700 hover:to-orange-700 text-white rounded-xl font-semibold shadow-lg transition transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Simpan Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden sticky top-4">
                <div class="bg-[#1F3B3B] p-6">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-calculator mr-2"></i>Ringkasan
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Menu Info -->
                    <div id="summaryMenu" class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Menu</p>
                        <p class="text-sm font-semibold text-gray-800">Belum dipilih</p>
                    </div>

                    <!-- Harga Satuan -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Harga Satuan:</span>
                        <span id="hargaSatuan" class="text-lg font-bold text-gray-800">Rp 0</span>
                    </div>

                    <!-- Jumlah -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Jumlah:</span>
                        <span id="jumlahSummary" class="text-lg font-bold text-gray-800">0x</span>
                    </div>

                    <div class="border-t-2 border-dashed pt-4">
                        <!-- Total -->
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-gray-800">Total Harga:</span>
                            <span id="totalHarga" class="text-2xl font-bold text-green-600">Rp 0</span>
                        </div>

                        <!-- Visual Indicator -->
                        <div class="bg-[#1F3B3B] rounded-xl p-4 text-white text-center">
                            <i class="fas fa-money-bill-wave text-3xl mb-2"></i>
                            <p class="text-sm">Siap untuk disimpan!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-yellow-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-bold text-yellow-800 mb-2">Tips Cepat:</h4>
                        <ul class="text-xs text-yellow-700 space-y-1">
                            <li>✓ Pilih meja jika pelanggan makan di tempat</li>
                            <li>✓ Gunakan tombol +/- untuk ubah jumlah</li>
                            <li>✓ Total akan dihitung otomatis</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let hargaSatuanValue = [];
    
    function addMenuItem() {
        const container = document.getElementById('menuContainer');
        const newItem = container.firstElementChild.cloneNode(true);
        newItem.querySelector('select').value = "";
        newItem.querySelector('input[name="jumlah[]"]').value = 1;

        // Tampilkan tombol hapus kalau sudah lebih dari 1 item
        newItem.querySelector('button[onclick="removeMenuItem(this)"]').classList.remove('hidden');

        container.appendChild(newItem);
        hitungTotal();
    }

    function removeMenuItem(button) {
        const container = document.getElementById('menuContainer');
        if (container.children.length > 1) {
            button.parentElement.remove();
            hitungTotal();
        } else {
            alert("Minimal satu menu harus ada.");
        }
    }

    function updateHarga(selectEl) {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;
        selectEl.dataset.harga = harga;
        hitungTotal();
    }

    function hitungTotal() {
        let total = 0;
        const menuItems = document.querySelectorAll('#menuContainer .menu-item');
        menuItems.forEach(item => {
            const selectEl = item.querySelector('select');
            const harga = parseInt(selectEl.dataset.harga) || 0;
            const jumlah = parseInt(item.querySelector('input[name="jumlah[]"]').value) || 0;
            total += harga * jumlah;
        });
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('jumlahSummary').textContent = menuItems.length + ' item';
    }

    function increaseJumlah(btn) {
        const input = btn.parentElement.querySelector('input[name="jumlah[]"]');
        input.value = parseInt(input.value) + 1;
        hitungTotal();
    }

    function decreaseJumlah(btn) {
        const input = btn.parentElement.querySelector('input[name="jumlah[]"]');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            hitungTotal();
        }
    }

    document.addEventListener('DOMContentLoaded', hitungTotal);
</script>


<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .lg\:col-span-1 > div {
        animation: slideIn 0.5s ease-out;
    }

    input:focus, select:focus {
        transform: scale(1.02);
    }
</style>
@endsection