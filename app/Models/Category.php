<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;

class Category extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $guarded = [
        
    ];
    protected $table = 'categories';
    
 
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }

    public function category_x_post() {
        return $this->hasMany('App\Models\PostXCategory', 'category_id','id');
    }
}
