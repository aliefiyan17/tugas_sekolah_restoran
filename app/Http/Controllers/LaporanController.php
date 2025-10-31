<?php
// app/Http/Controllers/LaporanController.php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'pesanan.menu']);

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai) {
            $query->whereDate('tglTransaksi', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_selesai') && $request->tanggal_selesai) {
            $query->whereDate('tglTransaksi', '<=', $request->tanggal_selesai);
        }

        $transaksis = $query->latest('tglTransaksi')->paginate(10);

        // Statistik
        $totalPendapatan = $query->sum('totalHarga');
        $totalTransaksi = $query->count();
        
        // Menu terlaris
        $menuTerlaris = DB::table('pesanan')
            ->join('menu', 'pesanan.idmenu', '=', 'menu.idmenu')
            ->select('menu.namamenu', DB::raw('SUM(pesanan.jumlah) as total_terjual'))
            ->groupBy('menu.idmenu', 'menu.namamenu')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return view('laporan.index', compact('transaksis', 'totalPendapatan', 'totalTransaksi', 'menuTerlaris'));
    }

    public function export(Request $request)
    {
        // Implementasi export ke Excel/PDF bisa ditambahkan di sini
        // Misalnya menggunakan package Laravel Excel atau DomPDF
    }
}