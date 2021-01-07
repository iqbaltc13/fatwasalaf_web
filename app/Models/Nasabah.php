<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $fillable = [
    	'id','user_id','jenis_layanan_id','nomor_va','nama','nomor_ktp','nomor_hp','email','alamat','nama_ibu','tempat_lahir','tanggal_lahir',
    	'provinsi_id', 'kota_id', 'kecamatan_id', 'kelurahan_id', 'foto_ktp_id', 'foto_ktp_selfie_id','jenis_kelamin'
    ];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id')->select('id','name','email','phone','current_apk_version_name','current_apk_version_code','device_info');
    }

    public function jenis_layanan(){
        return $this->hasOne('App\Models\JenisLayanan', 'id', 'jenis_layanan_id')->select('id','display_name');
    }

    public function foto_ktp(){
        return $this->hasOne('App\Models\File', 'id', 'foto_ktp_id')->select('id','full_path','full_path_thumbnail');
    }

    public function foto_ktp_selfie(){
        return $this->hasOne('App\Models\File', 'id', 'foto_ktp_selfie_id')->select('id','full_path','full_path_thumbnail');
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