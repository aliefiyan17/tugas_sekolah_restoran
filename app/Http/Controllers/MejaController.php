<?php
// app/Http/Controllers/MejaController.php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    // Tampilkan semua meja dengan visualisasi
    public function index(Request $request)
    {
        $query = Meja::query();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan lokasi
        if ($request->has('lokasi') && $request->lokasi != '') {
            $query->where('lokasi', $request->lokasi);
        }

        // Filter berdasarkan kapasitas
        if ($request->has('kapasitas') && $request->kapasitas != '') {
            $query->where('kapasitas', '>=', $request->kapasitas);
        }

        $mejas = $query->orderBy('nomor_meja')->get();

        // Group by lokasi untuk visualisasi
        $mejasByLokasi = $mejas->groupBy('lokasi');

        return view('meja.index', compact('mejas', 'mejasByLokasi'));
    }

    // Form tambah meja
    public function create()
    {
        return view('meja.create');
    }

    // Simpan meja baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|string|unique:meja,nomor_meja|max:10',
            'kapasitas' => 'required|integer|min:1|max:20',
            'lokasi' => 'required|in:Indoor,Outdoor,VIP',
            'keterangan' => 'nullable|string',
        ]);

        Meja::create($validated);

        return redirect()->route('meja.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    // Form edit meja
    public function edit(Meja $meja)
    {
        return view('meja.edit', compact('meja'));
    }

    // Update meja
    public function update(Request $request, Meja $meja)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|string|max:10|unique:meja,nomor_meja,' . $meja->idmeja . ',idmeja',
            'kapasitas' => 'required|integer|min:1|max:20',
            'status' => 'required|in:tersedia,terisi,reserved',
            'lokasi' => 'required|in:Indoor,Outdoor,VIP',
            'keterangan' => 'nullable|string',
        ]);

        $meja->update($validated);

        return redirect()->route('meja.index')
            ->with('success', 'Meja berhasil diperbarui.');
    }

    // Hapus meja
    public function destroy(Meja $meja)
    {
        // Check apakah meja sedang digunakan
        if ($meja->pesanan()->whereNull('idtransaksi')->exists()) {
            return redirect()->route('meja.index')
                ->withErrors(['error' => 'Meja tidak dapat dihapus karena sedang digunakan.']);
        }

        $meja->delete();

        return redirect()->route('meja.index')
            ->with('success', 'Meja berhasil dihapus.');
    }

    // Update status meja (AJAX)
    public function updateStatus(Request $request, Meja $meja)
    {
        $validated = $request->validate([
            'status' => 'required|in:tersedia,terisi,reserved',
            'reserved_at' => 'required_if:status,reserved|nullable|date|after:now',
            'reserved_by' => 'required_if:status,reserved|nullable|string|max:255',
            'reserved_phone' => 'nullable|string|max:20',
            'reserved_note' => 'nullable|string|max:500',
        ]);

        if ($validated['status'] === 'reserved') {
            $meja->setReservation(
                $validated['reserved_at'],
                $validated['reserved_by'],
                $validated['reserved_phone'] ?? null,
                $validated['reserved_note'] ?? null
            );
        } else {
            $meja->setStatus($validated['status']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status meja berhasil diperbarui.',
            'meja' => $meja->fresh(),
        ]);
    }

    // Get meja tersedia berdasarkan kapasitas (untuk form pesanan)
    public function getTersedia(Request $request)
    {
        $kapasitas = $request->input('kapasitas', 1);
        
        $mejas = Meja::tersedia()
            ->byKapasitas($kapasitas)
            ->orderBy('kapasitas')
            ->orderBy('nomor_meja')
            ->get();

        return response()->json($mejas);
    }
}