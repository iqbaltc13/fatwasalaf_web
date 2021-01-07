<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Validator;
use Carbon\Carbon;

class AreaController extends Controller
{
    public function get_provinsi(){
        $datas = Provinsi::select('id','nama')->get();
        return $this->success(@count($datas).' data berhasil ditampilkan',$datas);
    }

    public function get_kota($provinsi_id){
        $datas = Kota::select('id','nama')->where('provinsi_id',$provinsi_id)->get();
        return $this->success(@count($datas).' data berhasil ditampilkan',$datas);
    }

    public function get_kota_all(){
        $datas = Kota::select('id','nama','provinsi_id')->get();
        $datas->load(['provinsi']);
        foreach($datas as $data){
            $data->provinsi_nama    = $data->provinsi->nama;
            unset($data->provinsi);
            unset($data->provinsi_id);
        }
        return $this->success(@count($datas).' data berhasil ditampilkan',$datas);
    }

    public function get_kecamatan($kota_id){
        $datas = Kecamatan::select('id','nama')->where('kota_id',$kota_id)->get();
        return $this->success(@count($datas).' data berhasil ditampilkan',$datas);
    }

    public function get_kelurahan($kecamatan_id){
        $datas = Kelurahan::select('id','nama')->where('kecamatan_id',$kecamatan_id)->get();
        return $this->success(@count($datas).' data berhasil ditampilkan',$datas);
    }
}
