<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kbih extends Model
{
    //
    protected $table="kbihs";
    protected $fillable=['name','alamat','email','status_aktif','kota_id','latitude','longitude'];
    public function kota(){
        return $this->hasOne('App\Models\Kota', 'id', 'kota_id');
    }
}
