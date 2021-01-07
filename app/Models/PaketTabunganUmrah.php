<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;


class PaketTabunganUmrah extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $fillable = [
        'id', 'nama', 'deskripsi','biaya_administrasi','nominal_tabungan','is_default','created_by_name','last_updated_by_name','created_at','updated_at'
    ];

    public function detail_biaya(){
        return $this->hasMany('App\Models\DetailBiayaUmrah', 'paket_tabungan_umrah_id');
    }
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
}