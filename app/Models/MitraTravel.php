<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;

class MitraTravel extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $table = 'mitra_travels';
    protected $fillable = [
        'nama','deskripsi','no_izin_kemenag','tahun_berdiri','nama_direktur','lokasi_kantor',
        'titik_keberangkatan','telepon','website','social_media','order','is_active','logo_id'
    ];

    public function logo(){
        return $this->hasOne('App\Models\File','id','logo_id')->select('id','full_path','full_path_thumbnail');
    }
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
}