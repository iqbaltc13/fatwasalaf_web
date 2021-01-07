<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspirasiSubComment extends Model
{
    public function user(){
        return $this->hasOne('App\User','id','user_id')->select('id','file_id','name');
    }
}
