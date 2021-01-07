<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{

    protected $table = 'pembayarans';
    protected $fillable = [
        'nasabah_id','jenis_layanan_id','jenis_pembayaran_id','pembayaran_type','pembayaran_id','deskripsi','nominal', 'nominal_seharusnya',
        'verified_at','verified_by_id','verified_by_name','verified_result','catatan_customer','catatan_verifikator','file_id',
        'duma_point_id','duma_cash_id'
    ];
    public function pembayaranable(){
        return $this->morphTo();
    }

    public function nasabah()
    {
        return $this->belongsTo('App\Models\Nasabah', 'nasabah_id')->select('id','nama','nomor_va','nomor_hp','user_id','foto_ktp_id','foto_ktp_selfie_id');
    }
    public function jenis_layanan()
    {
        return $this->belongsTo('App\Models\JenisLayanan', 'jenis_layanan_id', 'id')->select('id','name','display_name');
    }
    public function jenis_pembayaran()
    {
        return $this->belongsTo('App\Models\JenisPembayaran', 'jenis_pembayaran_id', 'id')->select('id','name','display_name');
    }
    public function file(){
        return $this->hasOne('App\Models\File','id','file_id')->select('id','full_path','full_path_thumbnail');
    }
    public function duma_point()
    {
        return $this->belongsTo('App\Models\DumaPoint', 'duma_point_id');
    }
    public function duma_cash()
    {
        return $this->belongsTo('App\Models\DumaCash', 'duma_cash_id');
    }
}
