<?php
// app/Models/Meja.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'meja';
    protected $primaryKey = 'idmeja';

    protected $fillable = [
        'nomor_meja',
        'kapasitas',
        'status',
        'lokasi',
        'keterangan',
        'reserved_at',
        'reserved_by',
        'reserved_phone',
        'reserved_note',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
    ];

    // Relationship dengan Pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idmeja', 'idmeja');
    }

    // Method untuk check apakah meja tersedia
    public function isTersedia(): bool
    {
        return $this->status === 'tersedia';
    }

    // Method untuk check apakah meja terisi
    public function isTerisi(): bool
    {
        return $this->status === 'terisi';
    }

    // Method untuk check apakah meja reserved
    public function isReserved(): bool
    {
        return $this->status === 'reserved';
    }

    // Method untuk ubah status meja
    public function setStatus(string $status): void
    {
        $updateData = ['status' => $status];
        
        // Clear reserved info jika status bukan reserved
        if ($status !== 'reserved') {
            $updateData['reserved_at'] = null;
            $updateData['reserved_by'] = null;
            $updateData['reserved_phone'] = null;
            $updateData['reserved_note'] = null;
        }
        
        $this->update($updateData);
    }

    // Method untuk set reservasi
    public function setReservation($reservedAt, $reservedBy, $reservedPhone = null, $reservedNote = null): void
    {
        $this->update([
            'status' => 'reserved',
            'reserved_at' => $reservedAt,
            'reserved_by' => $reservedBy,
            'reserved_phone' => $reservedPhone,
            'reserved_note' => $reservedNote,
        ]);
    }

    // Method untuk get badge color berdasarkan status
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'tersedia' => 'bg-green-500',
            'terisi' => 'bg-red-500',
            'reserved' => 'bg-yellow-500',
            default => 'bg-gray-500',
        };
    }

    // Method untuk get icon berdasarkan kapasitas
    public function getKapasitasIconAttribute(): string
    {
        if ($this->kapasitas <= 2) {
            return '👥';
        } elseif ($this->kapasitas <= 4) {
            return '👨‍👩‍👧‍👦';
        } else {
            return '👨‍👩‍👧‍👦👨‍👩‍👧‍👦';
        }
    }

    // Scope untuk filter berdasarkan status
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeTerisi($query)
    {
        return $query->where('status', 'terisi');
    }

    // Scope untuk filter berdasarkan kapasitas
    public function scopeByKapasitas($query, $kapasitas)
    {
        return $query->where('kapasitas', '>=', $kapasitas);
    }
}