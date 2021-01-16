<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;


class LogSearch extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $guarded = [
        
    ];
    protected $table = 'log_searchs';
    
 
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
}
