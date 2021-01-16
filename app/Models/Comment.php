<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;

class Comment extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $guarded = [
        
    ];
    protected $table = 'comments';
    
 
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
    public function post(){
        return $this->belongsTo('App\Models\Post','post','id');
    }
}
