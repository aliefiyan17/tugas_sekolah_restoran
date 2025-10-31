<?php
// app/Http/Controllers/MenuController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Tampilkan semua menu
    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        return view('menu.index', compact('menus'));
    }

    // Form tambah menu
    public function create()
    {
        return view('menu.create');
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'namamenu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
        ]);

        Menu::create($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    // Form edit menu
    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    // Update menu
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'namamenu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
        ]);

        $menu->update($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    // Hapus menu
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}