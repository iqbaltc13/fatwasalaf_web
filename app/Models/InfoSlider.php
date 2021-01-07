<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;

class InfoSlider extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $guarded = [];
    public function image_slide(){
        return $this->hasOne('App\Models\File','id','image_slide_id')->select('id','full_path','full_path_thumbnail');
    }

    public function image_content(){
        return $this->hasOne('App\Models\File','id','image_content_id')->select('id','full_path','full_path_thumbnail');
    }
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
    
}
