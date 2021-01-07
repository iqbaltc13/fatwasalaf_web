<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
{
    //
    protected $table = 'jamaahs';
    protected $guarded = ['id'];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id')->select('id','name','email','phone');
    }

    public function pendaftar(){
        return $this->hasOne('App\User', 'id', 'pendaftar_id')->select('id','name','email','phone');
    }

    public function foto_ktp(){
        return $this->hasOne('App\Models\File', 'id', 'foto_ktp_id');
    }

    public function provinsi(){
        return $this->hasOne('App\Models\Provinsi', 'id', 'provinsi_id')->select('id','nama');
    }

    public function kota(){
        return $this->hasOne('App\Models\Kota', 'id', 'kota_id')->select('id','nama');
    }

    public function kelurahan(){
        return $this->hasOne('App\Models\Kelurahan', 'id', 'kelurahan_id')->select('id','nama');
    }

    public function kecamatan(){
        return $this->hasOne('App\Models\Kecamatan', 'id', 'kecamatan_id')->select('id','nama');
    }
}
