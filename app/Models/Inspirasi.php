<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;


class Inspirasi extends Model
{

    protected $appends = [
        'tanggal_input',
    ];
    protected $guarded = [
        
    ];
    
 
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
    public function thumbnail(){
        return $this->hasOne('App\Models\File','id','thumbnail_id')->select('id','full_path','full_path_thumbnail');
    }

    public function header_image(){
        return $this->hasOne('App\Models\File','id','header_image_id')->select('id','full_path','full_path_thumbnail');
    }

    public function audio(){
        return $this->hasOne('App\Models\File','id','audio_id')->select('id','full_path','full_path_thumbnail');
    }

    public function video(){
        return $this->hasOne('App\Models\File','id','video_id')->select('id','full_path','full_path_thumbnail');
    }
    public function comments(){
        return $this->hasMany('App\Models\InspirasiComment','inspirasi_id','id');
    }
    public function likes(){
        return $this->hasMany('App\Models\InspirasiLike','inspirasi_id','id');
    }
    public function shares(){
        return $this->hasMany('App\Models\InspirasiShare','inspirasi_id','id');
    }
    public function views(){
        return $this->hasMany('App\Models\InspirasiView','inspirasi_id','id');
    }
    
}
