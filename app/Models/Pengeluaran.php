<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'keterangan',
        'kode_akun',
        'tanggal',
        'gaji',
        'biaya_kirim',
        'transportasi',
        'lpti',
        'atk',
        'bahan',
        'peralatan',
        'lain_lain',
        'invest',
        'vendor',
        'profit',
        'cicilan',
        'pajak',
        'pemindahan',
        'status'
    ];
}
