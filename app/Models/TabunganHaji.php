<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabunganHaji extends Model
{
	protected $fillable = [
		'id','nasabah_id','paket_tabungan_haji_id','biaya_administrasi','nominal_tabungan','tahun_rencana_berangkat',
		'tahun_berangkat','status_tabungan_haji_id','catatan_customer','catatan_admin','last_updated_by_name'
    ];

    public function pembayarans(){
        return $this->morphMany('App\Models\Pembayaran', 'pembayaran');
    }

    public function nasabah(){
        return $this->hasOne('App\Models\Nasabah', 'id', 'nasabah_id');
    }

    public function status_tabungan_haji(){
        return $this->hasOne('App\Models\StatusTabunganHaji', 'id', 'status_tabungan_haji_id')->select('id','name','display_name');
    }

    public function paket_tabungan_haji(){
        return $this->hasOne('App\Models\PaketTabunganHaji', 'id', 'paket_tabungan_haji_id');
    }
}