<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kode extends Model
{
    protected $fillable = [
        'kode_akun',
        'keterangan'
    ];
}
