<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;



// Route untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route untuk Administrator
    Route::middleware('role:administrator')->group(function () {
        Route::resource('menu', MenuController::class);
        Route::resource('pelanggan', PelangganController::class);
        Route::resource('meja', MejaController::class);
        Route::post('meja/{meja}/status', [MejaController::class, 'updateStatus'])->name('meja.updateStatus');
    });

    Route::middleware('role:waiter,administrator')->group(function () {
        Route::get('/meja/tersedia/get', [MejaController::class, 'getTersedia'])->name('meja.getTersedia');
    });

    // Route untuk Waiter
    Route::middleware('role:waiter,administrator')->group(function () {
        Route::resource('pesanan', PesananController::class);
    });

    // Route untuk Kasir
    Route::middleware('role:kasir,administrator')->group(function () {
        Route::resource('transaksi', TransaksiController::class);
    });

    // Route untuk Owner
    Route::middleware('role:owner,kasir,waiter')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    });
});