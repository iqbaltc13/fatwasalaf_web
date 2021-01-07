<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewComment extends Model
{
    protected $fillable = [
        'user_id', 'comment', 'review_id', 'user_name', 'is_admin'
    ];

    public function user(){
        return $this->hasOne('App\User','id','user_id')->select('id','name','email','phone','file_id');
    }
}
