@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h2 class="text-4xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent mb-2">
            ✏️ Edit Pesanan
        </h2>
        <p class="text-gray-600">Perbarui detail pesanan</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-600 to-orange-600 p-6">
                    <h3 class="text-2xl font-bold text-white">
                        <i class="fas fa-edit mr-2"></i>Detail Pesanan
                    </h3>
                </div>

                <form action="{{ route('pesanan.update', $pesanan->idpesanan) }}" method="POST" id="pesananForm" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Pelanggan -->
                    <div class="mb-6">
                        <label for="idpelanggan" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-user text-yellow-600 mr-2"></i>Pelanggan
                        </label>
                        <select 
                            id="idpelanggan" 
                            name="idpelanggan" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('idpelanggan') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->idpelanggan }}" {{ old('idpelanggan', $pesanan->idpelanggan) == $pelanggan->idpelanggan ? 'selected' : '' }}>
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
                    </div>

                    <!-- Menu -->
                    <div class="mb-6">
                        <label for="idmenu" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-utensils text-yellow-600 mr-2"></i>Menu
                        </label>
                        <select 
                            id="idmenu" 
                            name="idmenu" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('idmenu') border-red-500 @enderror"
                            required
                            onchange="updateHarga()"
                        >
                            <option value="">-- Pilih Menu --</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->idmenu }}" 
                                        data-harga="{{ $menu->harga }}"
                                        {{ old('idmenu', $pesanan->idmenu) == $menu->idmenu ? 'selected' : '' }}>
                                    {{ $menu->namamenu }} - {{ $menu->formatted_harga }}
                                </option>
                            @endforeach
                        </select>
                        @error('idmenu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Meja -->
                    <div class="mb-6">
                        <label for="idmeja" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-chair text-yellow-600 mr-2"></i>Meja (Opsional)
                        </label>
                        <select 
                            id="idmeja" 
                            name="idmeja" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('idmeja') border-red-500 @enderror"
                        >
                            <option value="">-- Pilih Meja (Opsional) --</option>
                            @foreach($mejas as $meja)
                                <option value="{{ $meja->idmeja }}" {{ old('idmeja', $pesanan->idmeja) == $meja->idmeja ? 'selected' : '' }}>
                                    Meja {{ $meja->nomor_meja }} - {{ $meja->kapasitas }} Orang ({{ $meja->lokasi }})
                                </option>
                            @endforeach
                        </select>
                        @error('idmeja')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div class="mb-6">
                        <label for="jumlah" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-sort-numeric-up text-yellow-600 mr-2"></i>Jumlah
                        </label>
                        <div class="flex items-center space-x-4">
                            <button type="button" 
                                    onclick="decreaseJumlah()" 
                                    class="w-12 h-12 bg-gray-200 hover:bg-gray-300 rounded-lg font-bold text-xl transition">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input 
                                type="number" 
                                id="jumlah" 
                                name="jumlah" 
                                value="{{ old('jumlah', $pesanan->jumlah) }}"
                                min="1"
                                class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-xl text-center text-2xl font-bold focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('jumlah') border-red-500 @enderror"
                                required
                                oninput="hitungTotal()"
                            >
                            <button type="button" 
                                    onclick="increaseJumlah()" 
                                    class="w-12 h-12 bg-gray-200 hover:bg-gray-300 rounded-lg font-bold text-xl transition">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        @error('jumlah')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Pesanan Sebelumnya -->
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold text-blue-800 mb-2">Data Pesanan Sebelumnya:</h4>
                                <div class="text-xs text-blue-700 space-y-1">
                                    <p><strong>Pelanggan:</strong> {{ $pesanan->pelanggan->namapelanggan }}</p>
                                    <p><strong>Menu:</strong> {{ $pesanan->menu->namamenu }}</p>
                                    <p><strong>Jumlah:</strong> {{ $pesanan->jumlah }}x</p>
                                    <p><strong>Total:</strong> {{ $pesanan->formatted_total_harga }}</p>
                                    @if($pesanan->meja)
                                        <p><strong>Meja:</strong> {{ $pesanan->meja->nomor_meja }}</p>
                                    @endif
                                    <p><strong>Dibuat:</strong> {{ $pesanan->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between items-center pt-6 border-t-2">
                        <a href="{{ route('pesanan.index') }}" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-semibold transition transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i>Batal
                        </a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 text-white rounded-xl font-semibold shadow-lg transition transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Update Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden sticky top-4">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 p-6">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-calculator mr-2"></i>Ringkasan Baru
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Menu Info -->
                    <div id="summaryMenu" class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Menu</p>
                        <p class="text-sm font-semibold text-gray-800">Loading...</p>
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

                        <!-- Perubahan -->
                        <div id="perubahanInfo" class="bg-yellow-50 rounded-xl p-3 text-center hidden">
                            <p class="text-xs text-yellow-700 mb-1">Perubahan Total:</p>
                            <p id="perubahanText" class="text-sm font-bold"></p>
                        </div>

                        <!-- Visual Indicator -->
                        <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-xl p-4 text-white text-center mt-4">
                            <i class="fas fa-edit text-3xl mb-2"></i>
                            <p class="text-sm">Siap untuk diupdate!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let hargaSatuanValue = 0;
    const totalSebelumnya = '{{ $pesanan->totalharga }}';

    function updateHarga() {
        const menuSelect = document.getElementById('idmenu');
        const selectedOption = menuSelect.options[menuSelect.selectedIndex];
        const menuName = selectedOption.text.split(' - ')[0];
        
        hargaSatuanValue = parseInt(selectedOption.getAttribute('data-harga')) || 0;
        
        document.getElementById('summaryMenu').innerHTML = `
            <p class="text-xs text-gray-500 mb-1">Menu</p>
            <p class="text-sm font-semibold text-gray-800">${menuName || 'Belum dipilih'}</p>
        `;
        
        document.getElementById('hargaSatuan').textContent = 'Rp ' + hargaSatuanValue.toLocaleString('id-ID');
        
        hitungTotal();
    }

    function hitungTotal() {
        const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
        const total = hargaSatuanValue * jumlah;
        
        document.getElementById('jumlahSummary').textContent = jumlah + 'x';
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        
        // Show perubahan
        const perubahan = total - totalSebelumnya;
        const perubahanInfo = document.getElementById('perubahanInfo');
        const perubahanText = document.getElementById('perubahanText');
        
        if (perubahan !== 0) {
            perubahanInfo.classList.remove('hidden');
            if (perubahan > 0) {
                perubahanText.innerHTML = `<span class="text-green-600">+Rp ${Math.abs(perubahan).toLocaleString('id-ID')}</span>`;
            } else {
                perubahanText.innerHTML = `<span class="text-red-600">-Rp ${Math.abs(perubahan).toLocaleString('id-ID')}</span>`;
            }
        } else {
            perubahanInfo.classList.add('hidden');
        }
    }

    function increaseJumlah() {
        const jumlahInput = document.getElementById('jumlah');
        jumlahInput.value = parseInt(jumlahInput.value) + 1;
        hitungTotal();
    }

    function decreaseJumlah() {
        const jumlahInput = document.getElementById('jumlah');
        if (parseInt(jumlahInput.value) > 1) {
            jumlahInput.value = parseInt(jumlahInput.value) - 1;
            hitungTotal();
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateHarga();
        hitungTotal();
    });
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