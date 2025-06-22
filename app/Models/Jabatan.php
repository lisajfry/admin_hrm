<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    
        protected $table = 'jabatan';
    
        protected $fillable = [
            'jabatan',
            'gaji_pokok',
            'uang_kehadiran_perhari',
            'uang_makan',
            'bonus',
            'tunjangan',
            'potongan',
        ];
    
    
    // Model Jabatan.php
public function karyawans()
{
    return $this->hasMany(Karyawan::class, 'jabatan_id');
}

}
