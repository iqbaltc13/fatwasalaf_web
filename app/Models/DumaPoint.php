<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DumaPoint extends Model
{
    protected $fillable = [
        'in','out','description','user_id','created_at','updated_at','deleted_at'
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
