@extends('layouts.app')

@section('title', 'Proses Transaksi')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Proses Transaksi</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('transaksi.store') }}" method="POST" id="transaksiForm">
            @csrf
            
            <div class="mb-6">
                <label for="idpelanggan" class="block text-gray-700 font-semibold mb-2">Pilih Pelanggan</label>
                <select 
                    id="idpelanggan" 
                    name="idpelanggan" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                    onchange="loadPesanan()"
                >
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggans as $pelanggan)
                        @if(isset($pesanans[$pelanggan->idpelanggan]) && $pesanans[$pelanggan->idpelanggan]->isNotEmpty())
                            <option value="{{ $pelanggan->idpelanggan }}">
                                {{ $pelanggan->namapelanggan }} ({{ $pesanans[$pelanggan->idpelanggan]->count() }} pesanan)
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div id="pesananDetail" class="mb-6 hidden">
                <h3 class="text-lg font-semibold mb-3">Detail Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Menu</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Harga</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Jumlah</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="pesananList" class="bg-white divide-y divide-gray-200">
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-bold">Total:</td>
                                <td id="totalHarga" class="px-4 py-3 font-bold text-lg">Rp 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div id="bayarSection" class="mb-6 hidden">
                <label for="bayar" class="block text-gray-700 font-semibold mb-2">Uang Bayar</label>
                <input 
                    type="number" 
                    id="bayar" 
                    name="bayar" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                    min="0"
                    oninput="hitungKembalian()"
                >
                <div id="kembalianInfo" class="mt-2 text-lg font-semibold text-green-600 hidden">
                    Kembalian: <span id="kembalian">Rp 0</span>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('transaksi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Batal
                </a>
                <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg hidden">
                    Proses Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript ">
    const pesanansData = @json($pesanans);
    console.log(pesanansData);
    let totalHargaValue = 0;

    function loadPesanan() {
        const pelangganId = document.getElementById('idpelanggan').value;
        const pesananList = document.getElementById('pesananList');
        const pesananDetail = document.getElementById('pesananDetail');
        const bayarSection = document.getElementById('bayarSection');
        const submitBtn = document.getElementById('submitBtn');

        if (!pelangganId || !pesanansData[pelangganId]) {
            pesananDetail.classList.add('hidden');
            bayarSection.classList.add('hidden');
            submitBtn.classList.add('hidden');
            return;
        }

        const pesanans = pesanansData[pelangganId];
        let html = '';
        totalHargaValue = 0;

        pesanans.forEach(pesanan => {
            html += `
                <tr>
                    <td class="px-4 py-2">${pesanan.menu.namamenu}</td>
                    <td class="px-4 py-2">Rp ${pesanan.menu.harga.toLocaleString('id-ID')}</td>
                    <td class="px-4 py-2">${pesanan.jumlah}</td>
                    <td class="px-4 py-2">Rp ${pesanan.totalharga.toLocaleString('id-ID')}</td>
                </tr>
            `;
            totalHargaValue += pesanan.totalharga;
        });

        pesananList.innerHTML = html;
        document.getElementById('totalHarga').textContent = 'Rp ' + totalHargaValue.toLocaleString('id-ID');
        
        pesananDetail.classList.remove('hidden');
        bayarSection.classList.remove('hidden');
        submitBtn.classList.remove('hidden');
    }

    function hitungKembalian() {
        const bayar = parseInt(document.getElementById('bayar').value) || 0;
        const kembalian = bayar - totalHargaValue;
        const kembalianInfo = document.getElementById('kembalianInfo');
        const kembalianSpan = document.getElementById('kembalian');

        if (bayar > 0) {
            kembalianInfo.classList.remove('hidden');
            if (kembalian >= 0) {
                kembalianInfo.classList.remove('text-red-600');
                kembalianInfo.classList.add('text-green-600');
                kembalianSpan.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
            } else {
                kembalianInfo.classList.remove('text-green-600');
                kembalianInfo.classList.add('text-red-600');
                kembalianSpan.textContent = 'Kurang Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
            }
        } else {
            kembalianInfo.classList.add('hidden');
        }
    }
</script>
@endsection