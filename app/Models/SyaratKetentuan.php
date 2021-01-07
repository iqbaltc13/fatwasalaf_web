<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\WebHelperController;
use DateTime;

class SyaratKetentuan extends Model
{
    protected $appends = [
        'tanggal_input',
    ];
    protected $fillable = [
        'jenis', 'judul', 'html_konten', 'created_at', 'updated_at'
    ];
 
 
    public function getTanggalInputAttribute(){
        $objWebHelper = new WebHelperController();
        $valDateTime =$objWebHelper->olahTanggalToBaku($this->attributes['created_at']);
        return $valDateTime;
    }
}
