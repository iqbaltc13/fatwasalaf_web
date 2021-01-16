<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;

class Post extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $guarded = [
        
    ];
    protected $table = 'posts';
    
 
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
    public function post_x_category() {
        return $this->hasMany('App\Models\PostXCategory', 'post_id','id');
    }
    public function comment() {
        return $this->hasMany('App\Models\Comment', 'post_id','id');
    }
}
