<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;
 

class DetailBiayaHaji extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $guarded = [];
    public function icon(){
        return $this->hasOne('App\Models\File','id','icon_file_id')->select('id','full_path','full_path_thumbnail');
    }
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
}
