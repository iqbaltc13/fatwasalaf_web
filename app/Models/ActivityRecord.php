<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityRecord extends Model
{
    protected $fillable = [
    	'id','user_id','activity', 'from_ip', 'device_info', 'app_version', 'updated_at', 'created_at'
    ];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id')->select('id','name','file_id','email','phone');
    }
}
