<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranHaji extends Model
{
    protected $fillable = [
        'daftar_haji_id', 'jenis_pembayaran_haji_id', 'nominal', 'catatan', 'created_at', 'updated_at'
    ];

    public function jenis_pembayaran_haji(){
        return $this->hasOne('App\Models\JenisPembayaranHaji','id','jenis_pembayaran_haji_id');
    }

    public function kbih(){
        return $this->hasOne('App\Models\Kbih','id','kbih_id');
    }

    public function status_daftar_haji(){
        return $this->hasOne('App\Models\statusDaftarHaji','id','status_daftar_haji_id');
    }
}