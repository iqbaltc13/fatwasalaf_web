<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;

class InspirasiShare extends Model
{
    //
    protected $guarded = [];
    public function inspirasi()
    {
        return $this->belongsTo('App\Models\Inspirasi', 'inspirasi_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    
    
  
    protected $appends = [
        'tanggal_input',
    ];
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
}
