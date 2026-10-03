<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'nama',
        'nik_nip',
        'alamat',
        'jabatan',
        'maksud_tujuan',
        'keterangan',
        'foto',
    ];

    // Cast kolom tanggal ke tipe Date/Carbon
    protected $casts = [
        'tanggal' => 'date',
    ];
}
