<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    protected $fillable = [
        'keterangan',
        'kode_akun',
        'tanggal',
        'omset_konter',
        'omset_retail',
        'investor',
        'refund',
        'pemindahan_dana',
        'status'
    ];
}
