<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
    protected $fillable = [
        'user_id', 'review_id', 'user_name'
    ];
}
