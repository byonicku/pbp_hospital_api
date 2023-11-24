<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPeriksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasien',
        'dokter_spesialis',
        'jenis_perawatan',
        'tanggal_periksa',
        'gambar_dokter',
        'ruangan',
        'status_checkin',
    ];
}
