<?php
// app/Http/Controllers/PesananController.php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Tampilkan semua pesanan
    public function index()
    {
        $pesanans = Pesanan::with(['menu', 'pelanggan'])
            ->whereNull('idtransaksi')
            ->latest()
            ->paginate(10);
        return view('pesanan.index', compact('pesanans'));
    }

    // Form tambah pesanan
    public function create()
    {
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        $mejas = \App\Models\Meja::where('status', 'tersedia')->get();
        return view('pesanan.create', compact('menus', 'pelanggans', 'mejas'));
    }

    // Simpan pesanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
            'idmeja' => 'nullable|exists:meja,idmeja',
            'idmenu' => 'required|array|min:1',
            'idmenu.*' => 'exists:menu,idmenu',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'integer|min:1',
        ]);

        foreach ($validated['idmenu'] as $index => $idmenu) {
            Pesanan::create([
                'idpelanggan' => $validated['idpelanggan'],
                'idmenu' => $idmenu,
                'idmeja' => $validated['idmeja'] ?? null,
                'jumlah' => $validated['jumlah'][$index],
            ]);
        }

        if (!empty($validated['idmeja'])) {
            $meja = \App\Models\Meja::find($validated['idmeja']);
            $meja->setStatus('terisi');
        }

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil ditambahkan dengan beberapa menu.');
    }

    // Form edit pesanan
    public function edit(Pesanan $pesanan)
    {
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        $mejas = \App\Models\Meja::where('status', 'tersedia')
            ->orWhere('idmeja', $pesanan->idmeja)
            ->get();
        return view('pesanan.edit', compact('pesanan', 'menus', 'pelanggans', 'mejas'));
    }

    // Update pesanan
    public function update(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
            'idmenu' => 'required|exists:menu,idmenu',
            'idmeja' => 'nullable|exists:meja,idmeja',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Jika meja berubah, update status meja lama dan baru
        if ($pesanan->idmeja != $validated['idmeja']) {
            // Set meja lama jadi tersedia jika tidak ada pesanan lain
            if ($pesanan->idmeja) {
                $mejaLama = \App\Models\Meja::find($pesanan->idmeja);
                $pesananLain = Pesanan::where('idmeja', $pesanan->idmeja)
                    ->where('idpesanan', '!=', $pesanan->idpesanan)
                    ->whereNull('idtransaksi')
                    ->count();
                if ($pesananLain == 0) {
                    $mejaLama->setStatus('tersedia');
                }
            }

            // Set meja baru jadi terisi
            if ($validated['idmeja']) {
                $mejaBaru = \App\Models\Meja::find($validated['idmeja']);
                $mejaBaru->setStatus('terisi');
            }
        }

        $pesanan->update($validated);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    // Hapus pesanan
    public function destroy(Pesanan $pesanan)
    {
        // Check dan update status meja jika perlu
        if ($pesanan->idmeja) {
            $meja = \App\Models\Meja::find($pesanan->idmeja);
            $pesananLain = Pesanan::where('idmeja', $pesanan->idmeja)
                ->where('idpesanan', '!=', $pesanan->idpesanan)
                ->whereNull('idtransaksi')
                ->count();
            
            if ($pesananLain == 0) {
                $meja->setStatus('tersedia');
            }
        }

        $pesanan->delete();

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}