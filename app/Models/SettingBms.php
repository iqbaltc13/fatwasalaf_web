<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingBms extends Model
{
    protected $fillable = [
        'username', 'password', 'token', 'id_perusahaan'
    ];
}
