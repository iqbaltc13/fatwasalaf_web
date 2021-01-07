<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;




class User extends Authenticatable 
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasApiTokens;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'jenis_kelamin', 'is_active','built_in',
        'email_verified_at','phone_verified_at','last_access','last_activity','last_signedin',
        'last_update_location','latitude','longitude','firebase_uid','number_id', 'pin',
        'access_token', 'current_apk_version_name', 'current_apk_version_code', 'device_info', 'token_firebase',
        'signin_provider',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','access_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public function file(){
        return $this->hasOne('App\Models\File','id','file_id')->select('id','full_path','full_path_thumbnail');
    }

    public function jamaah()
    {
        return $this->hasOne('App\Models\Jamaah', 'user_id', 'id');
    }
    
    public function jamaahs()
    {
        return $this->hasMany('App\Models\Jamaah', 'pendaftar_id');
    }

    public function user_devices(){
        return $this->hasMany('App\Models\UserDevice', 'user_id');
    }
}
