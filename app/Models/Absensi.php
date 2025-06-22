<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'id_karyawan',
        'tanggal',
        'jam_masuk',
        'foto_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'jam_keluar',       // Tambahkan kolom jam keluar
        'foto_keluar',      // Tambahkan kolom foto keluar
        'latitude_keluar',  // Tambahkan kolom latitude keluar
        'longitude_keluar', // Tambahkan kolom longitude keluar
        'status',
    ];

    // Relasi ke model Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}