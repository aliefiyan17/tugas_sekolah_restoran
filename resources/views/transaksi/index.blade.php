@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Transaksi</h2>
        <a href="{{ route('transaksi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Tambah Transaksi
        </a>
    </div>

    <table class="min-w-full border border-gray-300 rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 text-left">#</th>
                <th class="py-2 px-4">Tanggal</th>
                <th class="py-2 px-4">Pelanggan</th>
                <th class="py-2 px-4 text-right">Total</th>
                <th class="py-2 px-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $transaksi->tglTransaksi->format('d/m/Y H:i') }}</td>
                    <td class="py-2 px-4">{{ $transaksi->pelanggan->namapelanggan }}</td>
                    <td class="py-2 px-4 text-right">{{ $transaksi->formatted_total_harga }}</td>
                    <td class="py-2 px-4 text-center">
                        <a href="{{ route('transaksi.show', $transaksi->idtransaksi) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                            Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        {{ $transaksis->links() }}
    </div>
</div>
@endsection
