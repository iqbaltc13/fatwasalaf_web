<?php

namespace App\Http\Controllers\Api\V1\Haji;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
// use Auth;

class PembayaranHajiController extends Controller{
    public function create(Request $request){
        return $this->success('Berhasil',$jamaah_json);
    }

    public function update(Request $request){
        return $this->success('Berhasil');
    }

    public function delete(Request $request){
        return $this->success('Berhasil');
    }

    public function get(Request $request){
        return $this->success('Berhasil');
    }

    public function gets(Request $request){
        return $this->success('Berhasil');
    }
}
