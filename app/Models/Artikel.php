<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = [
        'id', 'judul', 'artikel', 'thumbnail_file_id', 'konten_file_id', 'is_active'
    ];

    public function thumbnail_file(){
        return $this->hasOne('App\Models\File','id','thumbnail_file_id')->select('id','full_path','full_path_thumbnail');
    }
    
    public function konten_file(){
        return $this->hasOne('App\Models\File','id','konten_file_id')->select('id','full_path','full_path_thumbnail');
    }
}
