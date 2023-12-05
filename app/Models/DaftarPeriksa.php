<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPeriksa extends Model
{
    use HasFactory;

    protected $table = 'daftar_periksas';
    protected $primaryKey = 'id_daftar_periksa';
    protected $fillable = [
        'nama_pasien',
        'dokter_spesialis',
        'price',
        'jenis_perawatan',
        'tanggal_periksa',
        'gambar_dokter',
        'ruangan',
        'status_checkin',
        'id_user',
        'rating',
        'ulasan',
    ];
}
