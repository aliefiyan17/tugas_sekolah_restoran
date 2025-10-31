<?php
// app/Http/Controllers/TransaksiController.php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // Tampilkan semua transaksi
    public function index()
    {
        $transaksis = Transaksi::with('pelanggan')
            ->latest('tglTransaksi')
            ->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    // Form tambah transaksi
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $pesanans = Pesanan::with('menu')
            ->whereNull('idtransaksi')
            ->get()
            ->groupBy('idpelanggan');
        
        return view('transaksi.create', compact('pelanggans', 'pesanans'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
            'bayar' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Ambil semua pesanan pelanggan yang belum di-transaksi
            $pesanans = Pesanan::where('idpelanggan', $validated['idpelanggan'])
                ->whereNull('idtransaksi')
                ->get();

            if ($pesanans->isEmpty()) {
                return back()->withErrors(['error' => 'Tidak ada pesanan untuk pelanggan ini.']);
            }

            // Hitung total harga
            $totalHarga = $pesanans->sum('totalharga');

            // Validasi uang bayar
            if ($validated['bayar'] < $totalHarga) {
                return back()->withErrors(['bayar' => 'Uang bayar kurang dari total harga.']);
            }

            // Buat transaksi
            $transaksi = Transaksi::create([
                'idpelanggan' => $validated['idpelanggan'],
                'tglTransaksi' => now(),
                'totalHarga' => $totalHarga,
                'bayar' => $validated['bayar'],
            ]);

            // Update pesanan dengan id transaksi
            $pesanans->each(function ($pesanan) use ($transaksi) {
                $pesanan->update(['idtransaksi' => $transaksi->idtransaksi]);
            });

            DB::commit();

            return redirect()->route('transaksi.show', $transaksi->idtransaksi)
                ->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Tampilkan detail transaksi
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['pelanggan', 'pesanan.menu']);
        return view('transaksi.show', compact('transaksi'));
    }
}