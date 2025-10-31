@extends('layouts.app')

@section('title', 'Tambah Meja Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
            Tambah Meja Baru
        </h2>
        <p class="text-gray-600">Tambahkan meja baru untuk restoran Anda</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header dengan gradient -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6">
            <h3 class="text-2xl font-bold text-white">Informasi Meja</h3>
        </div>

        <form action="{{ route('meja.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor Meja -->
                <div class="form-group">
                    <label for="nomor_meja" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-hashtag text-blue-600 mr-2"></i>Nomor Meja
                    </label>
                    <input 
                        type="text" 
                        id="nomor_meja" 
                        name="nomor_meja" 
                        value="{{ old('nomor_meja') }}"
                        placeholder="Contoh: A1, B2, V1"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nomor_meja') border-red-500 @enderror"
                        required
                    >
                    @error('nomor_meja')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kapasitas -->
                <div class="form-group">
                    <label for="kapasitas" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-users text-blue-600 mr-2"></i>Kapasitas (Orang)
                    </label>
                    <select 
                        id="kapasitas" 
                        name="kapasitas" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('kapasitas') border-red-500 @enderror"
                        required
                        onchange="updatePreview()"
                    >
                        <option value="">-- Pilih Kapasitas --</option>
                        <option value="2" {{ old('kapasitas') == 2 ? 'selected' : '' }}>2 Orang (Meja Kecil)</option>
                        <option value="4" {{ old('kapasitas') == 4 ? 'selected' : '' }}>4 Orang (Meja Sedang)</option>
                        <option value="6" {{ old('kapasitas') == 6 ? 'selected' : '' }}>6 Orang (Meja Besar)</option>
                        <option value="10" {{ old('kapasitas') == 10 ? 'selected' : '' }}>10+ Orang (Meja XL)</option>
                    </select>
                    @error('kapasitas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="form-group">
                    <label for="lokasi" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Lokasi
                    </label>
                    <select 
                        id="lokasi" 
                        name="lokasi" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('lokasi') border-red-500 @enderror"
                        required
                        onchange="updatePreview()"
                    >
                        <option value="">-- Pilih Lokasi --</option>
                        <option value="Indoor" {{ old('lokasi') == 'Indoor' ? 'selected' : '' }}>
                            🏢 Indoor (Dalam Ruangan)
                        </option>
                        <option value="Outdoor" {{ old('lokasi') == 'Outdoor' ? 'selected' : '' }}>
                            🌳 Outdoor (Luar Ruangan)
                        </option>
                        <option value="VIP" {{ old('lokasi') == 'VIP' ? 'selected' : '' }}>
                            👑 VIP (Ruang Khusus)
                        </option>
                    </select>
                    @error('lokasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>Status Awal
                    </label>
                    <div class="bg-green-50 border-2 border-green-300 rounded-xl px-4 py-3">
                        <span class="text-green-700 font-semibold">
                            <i class="fas fa-check-circle mr-2"></i>Tersedia (Default)
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Status dapat diubah setelah meja dibuat</p>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="mt-6">
                <label for="keterangan" class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-sticky-note text-blue-600 mr-2"></i>Keterangan (Opsional)
                </label>
                <textarea 
                    id="keterangan" 
                    name="keterangan" 
                    rows="3"
                    placeholder="Contoh: Dekat jendela, View taman, dll"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('keterangan') border-red-500 @enderror"
                >{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Preview Section -->
            <div class="mt-8 bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-6 border-2 border-blue-200">
                <h4 class="text-lg font-bold text-gray-800 mb-4 text-center">
                    <i class="fas fa-eye text-blue-600 mr-2"></i>Preview Meja
                </h4>
                <div class="flex justify-center" id="mejaPreview">
                    <div class="text-center text-gray-400">
                        <i class="fas fa-chair text-6xl mb-2"></i>
                        <p>Pilih kapasitas untuk melihat preview</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t-2">
                <a href="{{ route('meja.index') }}" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-semibold transition transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg transition transform hover:scale-105">
                    <i class="fas  mr-2"></i>Simpan Meja
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePreview() {
        const kapasitas = parseInt(document.getElementById('kapasitas').value);
        const lokasi = document.getElementById('lokasi').value;
        const previewDiv = document.getElementById('mejaPreview');
        
        if (!kapasitas) {
            previewDiv.innerHTML = `
                <div class="text-center text-gray-400">
                    <i class="fas fa-chair text-6xl mb-2"></i>
                    <p>Pilih kapasitas untuk melihat preview</p>
                </div>
            `;
            return;
        }

        let color = '#10b981'; // Default green
        let icon = '👥';
        let svg = '';

        if (kapasitas <= 2) {
            icon = '👥';
            svg = `
                <svg width="120" height="120" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="35" fill="${color}" opacity="0.2"/>
                    <circle cx="50" cy="50" r="30" fill="${color}"/>
                    <circle cx="35" cy="35" r="8" fill="#1f2937"/>
                    <circle cx="65" cy="65" r="8" fill="#1f2937"/>
                </svg>
            `;
        } else if (kapasitas <= 4) {
            icon = '👨‍👩‍👧‍👦';
            svg = `
                <svg width="120" height="120" viewBox="0 0 100 100">
                    <rect x="20" y="20" width="60" height="60" rx="10" fill="${color}" opacity="0.2"/>
                    <rect x="25" y="25" width="50" height="50" rx="8" fill="${color}"/>
                    <circle cx="30" cy="30" r="6" fill="#1f2937"/>
                    <circle cx="70" cy="30" r="6" fill="#1f2937"/>
                    <circle cx="30" cy="70" r="6" fill="#1f2937"/>
                    <circle cx="70" cy="70" r="6" fill="#1f2937"/>
                </svg>
            `;
        } else {
            icon = '👨‍👩‍👧‍👦👨‍👩‍👧‍👦';
            svg = `
                <svg width="150" height="120" viewBox="0 0 120 100">
                    <rect x="15" y="30" width="90" height="40" rx="12" fill="${color}" opacity="0.2"/>
                    <rect x="20" y="35" width="80" height="30" rx="10" fill="${color}"/>
                    <circle cx="20" cy="25" r="5" fill="#1f2937"/>
                    <circle cx="50" cy="20" r="5" fill="#1f2937"/>
                    <circle cx="80" cy="20" r="5" fill="#1f2937"/>
                    <circle cx="110" cy="25" r="5" fill="#1f2937"/>
                    <circle cx="20" cy="75" r="5" fill="#1f2937"/>
                    <circle cx="50" cy="80" r="5" fill="#1f2937"/>
                    <circle cx="80" cy="80" r="5" fill="#1f2937"/>
                    <circle cx="110" cy="75" r="5" fill="#1f2937"/>
                </svg>
            `;
        }

        previewDiv.innerHTML = `
            <div class="text-center">
                ${svg}
                <div class="mt-4">
                    <p class="text-2xl font-bold text-gray-800">${icon} ${kapasitas} Orang</p>
                    ${lokasi ? `<p class="text-gray-600 mt-2">${lokasi == 'Indoor' ? '🏢' : (lokasi == 'Outdoor' ? '🌳' : '👑')} ${lokasi}</p>` : ''}
                </div>
            </div>
        `;
    }

    // Update preview on page load if editing
    document.addEventListener('DOMContentLoaded', updatePreview);
</script>

<style>
    .form-group {
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    input:focus, select:focus, textarea:focus {
        transform: scale(1.02);
    }
</style>
@endsection