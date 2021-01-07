<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningPerusahaan extends Model
{
    protected $fillable = [
        'nomor_rekening', 'atas_nama', 'nama_bank', 'keterangan', 'status_aktif', 'logo_bank_id'
    ];
}
