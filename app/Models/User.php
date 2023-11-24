<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telp',
        'tanggal_lahir',
        'jenis_kelamin',
        'profile_photo',
    ];
}
