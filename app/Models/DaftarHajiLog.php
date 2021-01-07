<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarHajiLog extends Model
{
    protected $fillable = [
        'daftar_haji_id', 'updated_by_id', 'updated_by_name','status_daftar_haji_id_before', 'status_daftar_haji_id_after', 'catatan'
    ];

    public function status_daftar_haji_before(){
        return $this->hasOne('App\Models\statusDaftarHaji','id','status_daftar_haji_id_before')->select('id','name','display_name');
    }

    public function status_daftar_haji_after(){
        return $this->hasOne('App\Models\statusDaftarHaji','id','status_daftar_haji_id_after')->select('id','name','display_name');
    }
}
