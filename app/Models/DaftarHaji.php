<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarHaji extends Model
{
    protected $fillable = [
        'jamaah_id', 'kbih_id', 'status_daftar_haji_id', 'verified_by_id', 'verified_at','nominal_total',
        'nominal_talangan','biaya_administrasi','terakhir_pelunasan_admin','terakhir_pelunasan_talangan',
        'tanggal_setor_bpsbpih','nomor_porsi','tahun_berangkat',
    ];

    public function jamaah(){
        return $this->hasOne('App\Models\Jamaah','id','jamaah_id');
    }

    public function kbih(){
        return $this->hasOne('App\Models\Kbih','id','kbih_id');
    }

    public function status_daftar_haji(){
        return $this->hasOne('App\Models\statusDaftarHaji','id','status_daftar_haji_id');
    }

    public function verified_by(){
        return $this->hasOne('App\User','id','verified_by_id')->select('id','name');
    }
}