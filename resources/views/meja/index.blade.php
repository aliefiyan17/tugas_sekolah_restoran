@extends('layouts.app')

@section('title', 'Manajemen Meja')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-bold text-black">
                Manajemen Meja
            </h2>
            <p class="text-gray-600 mt-2">Kelola dan monitoring status meja restoran</p>
        </div>
        <a href="{{ route('meja.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-600 hover:from-blue-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl shadow-lg transform hover:scale-105 transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Meja
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
            <div class="text-sm text-gray-600">Tersedia</div>
            <div class="text-2xl font-bold text-gray-800">{{ $mejas->where('status', 'tersedia')->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
            <div class="text-sm text-gray-600">Terisi</div>
            <div class="text-2xl font-bold text-gray-800">{{ $mejas->where('status', 'terisi')->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <div class="text-sm text-gray-600">Reserved</div>
            <div class="text-2xl font-bold text-gray-800">{{ $mejas->where('status', 'reserved')->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
            <div class="text-sm text-gray-600">Total Meja</div>
            <div class="text-2xl font-bold text-gray-800">{{ $mejas->count() }}</div>
        </div>
    </div>

    <!-- Meja by Lokasi -->
    @foreach($mejasByLokasi as $lokasi => $mejaGroup)
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-r from-gray-600 to-gray-600 text-white px-4 py-2 rounded-lg shadow-lg">
                    <i class="fas fa-{{ $lokasi == 'VIP' ? 'crown' : ($lokasi == 'Outdoor' ? 'tree' : 'building') }} mr-2"></i>
                    <span class="font-bold">{{ $lokasi }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($mejaGroup as $meja)
                    <div class="meja-card relative group">
                        <!-- Meja Container dengan efek 3D -->
                        <div class="bg-white rounded-2xl shadow-xl p-6 transform hover:scale-105 transition duration-300 border-2 ">
                            <!-- Status Badge -->
                            <div class="absolute top-2 right-2">
                                <span class="px-3 py-1 rounded-full text-xs font-bold text-white {{ $meja->status_badge_color }} shadow-lg">
                                    {{ ucfirst($meja->status) }}
                                </span>
                            </div>

                            <!-- Table Icon/Visual -->
                            <div class="flex justify-center mb-4 mt-2">
                                @if($meja->kapasitas <= 2)
                                    <img src="{{ asset('images/meja2.png') }}" alt="Meja kecil" width="80" height="80" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div style="display:none;" class="text-6xl">🪑</div>
                                @elseif($meja->kapasitas <= 4)
                                    <img src="{{ asset('images/meja4.png') }}" alt="Meja sedang" width="80" height="80" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div style="display:none;" class="text-6xl">🪑</div>
                                @else
                                    <img src="{{ asset('images/meja6.png') }}" alt="Meja besar" width="80" height="80" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div style="display:none;" class="text-6xl">🪑</div>
                                @endif
                            </div>

                            <!-- Meja Info -->
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $meja->nomor_meja }}</h3>
                                <div class="flex items-center justify-center space-x-2 text-gray-600 mb-3">
                                    <span class="text-2xl">{{ $meja->kapasitas_icon }}</span>
                                    <span class="font-semibold">{{ $meja->kapasitas }} Orang</span>
                                </div>
                                
                                @if($meja->status == 'reserved' && $meja->reserved_at)
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3 text-left">
                                        <p class="text-xs font-bold text-yellow-800 mb-1">
                                            <i class="fas fa-calendar-alt mr-1"></i>Reservasi:
                                        </p>
                                        <p class="text-xs text-yellow-700">
                                            <i class="fas fa-clock mr-1"></i>{{ $meja->reserved_at->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="text-xs text-yellow-700">
                                            <i class="fas fa-user mr-1"></i>{{ $meja->reserved_by }}
                                        </p>
                                        @if($meja->reserved_phone)
                                            <p class="text-xs text-yellow-700">
                                                <i class="fas fa-phone mr-1"></i>{{ $meja->reserved_phone }}
                                            </p>
                                        @endif
                                        @if($meja->reserved_note)
                                            <p class="text-xs text-yellow-700 mt-1">
                                                <i class="fas fa-sticky-note mr-1"></i>{{ Str::limit($meja->reserved_note, 30) }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                @if($meja->keterangan)
                                    <p class="text-xs text-gray-500 mb-2">{{ $meja->keterangan }}</p>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 flex flex-col space-y-2">
                                <!-- Status Toggle Buttons -->
                                <div class="flex space-x-1">
                                    <!-- Tombol Tersedia -->
                                    <button onclick="updateStatus('{{ $meja->idmeja }}', 'tersedia')" 
                                        class="flex-1 px-2 py-1 text-xs rounded-lg text-green-600 hover:bg-green-500 hover:text-white transition {{ $meja->status == 'tersedia' ? 'ring-2 ring-green-300' : '' }}">
                                        <i class="fas fa-check"></i>
                                    </button>

                                    <!-- Tombol Terisi -->
                                    <button onclick="updateStatus('{{ $meja->idmeja }}', 'terisi')" 
                                        class="flex-1 px-2 py-1 text-xs rounded-lg  text-red-600 hover:bg-red-500 hover:text-white transition {{ $meja->status == 'terisi' ? 'ring-2 ring-red-300' : '' }}">
                                        <i class="fas fa-users"></i>
                                    </button>

                                    <!-- Tombol Reserved -->
                                    <button onclick="openReserveModal('{{ $meja->idmeja }}', '{{ $meja->nomor_meja }}')" 
                                        class="flex-1 px-2 py-1 text-xs rounded-lg  text-yellow-500 hover:bg-yellow-400 hover:text-white transition {{ $meja->status == 'reserved' ? 'ring-2 ring-yellow-300' : '' }}">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                </div>

                                <!-- Edit & Delete -->
                                <div class="flex space-x-1">
                                    <a href="{{ route('meja.edit', $meja->idmeja) }}" 
                                    class="flex-1 text-xs text-blue-600 hover:text-blue-800 text-center py-2 transition">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('meja.destroy', $meja->idmeja) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus meja {{ $meja->nomor_meja }}?')"
                                                class="w-full text-xs text-red-600 hover:text-red-800 py-2 text-center transition">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Hover Effect Glow -->
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-400 rounded-2xl opacity-0 group-hover:opacity-20 transition duration-300 -z-10 blur-xl"></div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    @if($mejas->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <i class="fas fa-chair text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Meja</h3>
            <p class="text-gray-500 mb-4">Belum ada meja yang ditambahkan atau tidak ada yang sesuai filter.</p>
            <a href="{{ route('meja.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                <i class="fas fa-plus mr-2"></i>Tambah Meja Pertama
            </a>
        </div>
    @endif
</div>

<!-- Modal Reservasi -->
<div id="reserveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeReserveModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-calendar-check text-yellow-600 mr-2"></i>Reservasi Meja
            </h3>
            <button onclick="closeReserveModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
            <p class="text-sm font-semibold text-yellow-800">
                <i class="fas fa-chair mr-2"></i>Meja: <span id="modalMejaNumber"></span>
            </p>
        </div>

        <form id="reserveForm">
            <input type="hidden" id="modalMejaId" name="idmeja">
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt text-yellow-600 mr-2"></i>Tanggal & Waktu Reservasi
                </label>
                <input 
                    type="datetime-local" 
                    id="reserved_at" 
                    name="reserved_at"
                    min="{{ now()->addHours(1)->format('Y-m-d\TH:i') }}"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-user text-yellow-600 mr-2"></i>Nama Pemesan
                </label>
                <input 
                    type="text" 
                    id="reserved_by" 
                    name="reserved_by"
                    placeholder="Masukkan nama pemesan"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-phone text-yellow-600 mr-2"></i>No. Telepon (Opsional)
                </label>
                <input 
                    type="tel" 
                    id="reserved_phone" 
                    name="reserved_phone"
                    placeholder="Masukkan nomor telepon"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500"
                >
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-sticky-note text-yellow-600 mr-2"></i>Catatan (Opsional)
                </label>
                <textarea 
                    id="reserved_note" 
                    name="reserved_note"
                    rows="3"
                    placeholder="Contoh: Ulang tahun, acara keluarga, dll"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500"
                ></textarea>
            </div>

            <div class="flex space-x-3">
                <button 
                    type="button"
                    onclick="closeReserveModal()" 
                    class="flex-1 px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-semibold transition">
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white rounded-xl font-semibold transition">
                    <i class="fas fa-check mr-2"></i>Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateStatus(mejaId, status) {
        if (status === 'reserved') {
            // Untuk reserved, buka modal
            return;
        }

        if (!confirm('Ubah status meja?')) return;

        fetch(`/meja/${mejaId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status meja');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    function openReserveModal(mejaId, mejaNumber) {
        document.getElementById('modalMejaId').value = mejaId;
        document.getElementById('modalMejaNumber').textContent = mejaNumber;
        document.getElementById('reserveModal').classList.remove('hidden');
        document.getElementById('reserveModal').classList.add('flex');
    }

    function closeReserveModal(event) {
        if (!event || event.target.id === 'reserveModal') {
            document.getElementById('reserveModal').classList.add('hidden');
            document.getElementById('reserveModal').classList.remove('flex');
            document.getElementById('reserveForm').reset();
        }
    }

    document.getElementById('reserveForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const mejaId = document.getElementById('modalMejaId').value;
        const formData = {
            status: 'reserved',
            reserved_at: document.getElementById('reserved_at').value,
            reserved_by: document.getElementById('reserved_by').value,
            reserved_phone: document.getElementById('reserved_phone').value,
            reserved_note: document.getElementById('reserved_note').value,
        };

        fetch(`/meja/${mejaId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeReserveModal();
                location.reload();
            } else {
                alert('Gagal membuat reservasi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    });
</script>

<style>
    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }
        50% {
            box-shadow: 0 0 40px rgba(255, 255, 255, 0.8);
        }
    }

    .meja-card:hover {
        animation: pulse-glow 2s infinite;
    }
</style>
@endsection