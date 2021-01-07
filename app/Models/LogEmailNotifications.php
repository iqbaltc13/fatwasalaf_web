<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;

class LogEmailNotifications extends Model
{
    protected $guarded = [];
    protected $appends = [
           'tanggal_input',
       ];
    public function getTanggalInputAttribute(){
           $objWebHelper = new WebHelperController();
           $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
           return $valDateTime;
    }
}
