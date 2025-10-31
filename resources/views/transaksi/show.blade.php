@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-6 border-b pb-4">
            <h2 class="text-3xl font-bold text-gray-800">STRUK PEMBAYARAN</h2>
            <p class="text-gray-600 mt-2">Restoran XYZ</p>
            <p class="text-sm text-gray-500">{{ $transaksi->tglTransaksi->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">No. Transaksi:</p>
                    <p class="font-semibold">#{{ str_pad($transaksi->idtransaksi, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Pelanggan:</p>
                    <p class="font-semibold">{{ $transaksi->pelanggan->namapelanggan }}</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">Detail Pesanan</h3>
            <table class="min-w-full">
                <thead class="border-b-2 border-gray-300">
                    <tr>
                        <th class="text-left py-2">Menu</th>
                        <th class="text-center py-2">Qty</th>
                        <th class="text-right py-2">Harga</th>
                        <th class="text-right py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->pesanan as $pesanan)
                        <tr class="border-b">
                            <td class="py-2">{{ $pesanan->menu->namamenu }}</td>
                            <td class="text-center py-2">{{ $pesanan->jumlah }}</td>
                            <td class="text-right py-2">{{ $pesanan->menu->formatted_harga }}</td>
                            <td class="text-right py-2">{{ $pesanan->formatted_total_harga }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-gray-300 pt-4">
            <div class="flex justify-between mb-2">
                <span class="text-lg font-semibold">Total:</span>
                <span class="text-lg font-semibold">{{ $transaksi->formatted_total_harga }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-lg">Bayar:</span>
                <span class="text-lg">{{ $transaksi->formatted_bayar }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-xl font-bold text-green-600">Kembalian:</span>
                <span class="text-xl font-bold text-green-600">{{ $transaksi->formatted_kembalian }}</span>
            </div>
        </div>

        <div class="mt-8 text-center border-t pt-4">
            <p class="text-gray-600">Terima kasih atas kunjungan Anda!</p>
            <p class="text-sm text-gray-500 mt-2">Simpan struk ini sebagai bukti pembayaran</p>
        </div>

        <div class="mt-6 flex justify-center gap-4">
            <a href="{{ route('transaksi.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Kembali
            </a>
            <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-print mr-2"></i>Cetak Struk
            </button>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .max-w-4xl, .max-w-4xl * {
            visibility: visible;
        }
        .max-w-4xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        button, a {
            display: none !important;
        }
    }
</style>
@endsection