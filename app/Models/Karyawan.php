<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // kalau mau bisa login
use Illuminate\Notifications\Notifiable;

class Karyawan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'karyawans';

    protected $fillable = [
        'nama_karyawan',
        'nip',
        'nik',
        'email',
        'no_handphone',
        'alamat',
        'password',
        'jabatan_id',
        'device_code',
        'avatar',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Relasi ke tabel jabatan
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
