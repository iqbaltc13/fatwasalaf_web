<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';
    public function provinsi(){
        return $this->hasOne('App\Models\Provinsi', 'id', 'provinsi_id')->select('id','nama');
    }
}
