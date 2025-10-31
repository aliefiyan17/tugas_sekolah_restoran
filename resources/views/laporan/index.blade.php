{{-- resources/views/laporan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-5xl font-bold mb-3">Laporan Transaksi</h3>
            <p class="text-muted mb-0">Ringkasan dan detail transaksi</p>
        </div>
        <button class="btn btn-outline-primary rounded-lg" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Cetak
        </button>
    </div>

    {{-- Filter --}}
    <div class="card mb-4 rounded-xl">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.index') }}">
                <div class="row g-3">
                    <div class="col-md-5 rounded-lg">
                        <label class="form-label mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" 
                               value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="col-md-5 rounded-lg">
                        <label class="form-label mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" 
                               value="{{ request('tanggal_selesai') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100 rounded-lg">Filter</button>
                    </div>
                </div>
                @if(request('tanggal_mulai') || request('tanggal_selesai'))
                <div class="mt-2">
                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-link text-decoration-none">
                        <i class="bi bi-x-circle me-1"></i> Hapus Filter
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 bg-primary text-white rounded-xl">
                <div class="card-body">
                    <div class="small mb-1 opacity-75">Total Pendapatan</div>
                    <h4 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-success text-white rounded-xl">
                <div class="card-body">
                    <div class="small mb-1 opacity-75">Total Transaksi</div>
                    <h4 class="mb-0">{{ number_format($totalTransaksi) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-secondary text-white rounded-xl">
                <div class="card-body">
                    <div class="small mb-1 opacity-75">Rata-rata Transaksi</div>
                    <h4 class="mb-0">
                        Rp {{ $totalTransaksi > 0 ? number_format($totalPendapatan / $totalTransaksi, 0, ',', '.') : '0' }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Terlaris --}}
    <div class="card mb-4 rounded-xl">
        <div class="card-header bg-white">
            <h5 class="mb-0">Menu Terlaris</h5>
        </div>
        <div class="card-body">
            @if($menuTerlaris->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($menuTerlaris as $index => $menu)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-secondary me-3">{{ $index + 1 }}</span>
                            <span>{{ $menu->namamenu }}</span>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ number_format($menu->total_terjual) }} terjual</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center mb-0">Tidak ada data</p>
            @endif
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="card rounded-xl">
        <div class="card-header bg-white">
            <h5 class="mb-0">Detail Transaksi</h5>
        </div>
        <div class="card-body p-0 rounded-xl">
            @if($transaksis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Pesanan</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $transaksi)
                            <tr>
                                <td><strong>#{{ $transaksi->idtransaksi }}</strong></td>
                                <td>
                                    {{ \Carbon\Carbon::parse($transaksi->tglTransaksi)->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($transaksi->tglTransaksi)->format('H:i') }}</small>
                                </td>
                                <td>
                                    {{ $transaksi->pelanggan->namapelanggan ?? '-' }}<br>
                                    <small class="text-muted">{{ $transaksi->pelanggan->telepon ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($transaksi->pesanan->count() > 0)
                                        @foreach($transaksi->pesanan as $pesanan)
                                        <div class="small">
                                            • {{ $pesanan->menu->namamenu ?? '-' }} 
                                            <span class="text-muted">({{ $pesanan->jumlah }}x)</span>
                                        </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <strong>Rp {{ number_format($transaksi->totalHarga, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">Total:</th>
                                <th class="text-end">
                                    Rp {{ number_format($transaksis->sum('totalHarga'), 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menampilkan {{ $transaksis->firstItem() }} - {{ $transaksis->lastItem() }} 
                            dari {{ $transaksis->total() }} transaksi
                        </small>
                        {{ $transaksis->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-muted mb-2">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-muted mb-0">Tidak ada transaksi</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .btn, form, .pagination, .card-footer {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .table > :not(caption) > * > * {
        padding: 0.75rem;
    }
</style>
@endpush

@push('scripts')
{{-- Tambahkan Bootstrap Icons jika belum ada --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endpush
@endsection