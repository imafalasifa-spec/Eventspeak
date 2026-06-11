<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // PENTING: Karena di gambar tabelmu namanya 'Event' (bukan 'events')
    protected $table = 'Event'; 

    // Kolom yang boleh diisi sesuai gambar struktur tabelmu
    protected $fillable = [
        'Jenis_Event',
        'Nama_Event',
        'Deskripsi',
        'Tanggal',
        'Lokasi',
        'Harga',
        'Pemateri',
        'Gambar',
        'id_penyelenggara'
    ];

    // Agar kolom Tanggal bisa langsung dimanipulasi pakai Carbon di Blade
    protected $casts = [
        'Tanggal' => 'datetime',
    ];
}