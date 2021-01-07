<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;


class PaketTabunganHaji extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $fillable = [
    	'id','nama','deskripsi','biaya_administrasi','nominal_tabungan','is_default','created_by_name','last_updated_by_name','status','banner_file_id'
    ];
    public function image_slide(){
        return $this->hasOne('App\Models\File','id','banner_file_id')->select('id','full_path','full_path_thumbnail');
    }
    public function detail_biaya(){
        return $this->hasMany('App\Models\DetailBiayaHaji', 'paket_tabungan_haji_id');
    }
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
}