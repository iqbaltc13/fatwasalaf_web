<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'review', 'rate', 'file_id'
    ];

    public function file(){
        return $this->hasOne('App\Models\File','id','file_id')->select('id','full_path','full_path_thumbnail');
    }

    public function user(){
        return $this->hasOne('App\User','id','user_id')->select('id','name','email','phone','file_id');
    }

    public function comments(){
        return $this->hasMany('App\Models\ReviewComment', 'review_id');
    }

    public function likes(){
        return $this->hasMany('App\Models\ReviewLike', 'review_id');
    }
}
