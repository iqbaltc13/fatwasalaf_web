<?php

namespace App\Http\Controllers\Api\V1\Artikel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use App\Models\Jamaah;
use App\Models\DaftarHaji;
use App\Models\DaftarHajiLog;
use App\Models\PembayaranHaji;
use App\Models\Kbih;
use App\Models\SettingNominalHajiMuda;
use Auth;
use App\Models\PaketTabunganUmrah;
use App\Models\TabunganUmrah;
use App\Helpers\VirtualAccount;
use App\Models\Nasabah;
use DB;
use App\Models\SettingBms;
use App\Models\Artikel;

class ArtikelController extends Controller{
    public function upsert(Request $request){
        $rules = [
            'judul'             => 'required|string',
            'artikel'           => 'required|string',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        if(isset($request->id)){
            $artikel                        = Artikel::find($request->id);
            if($artikel){
                $this->failure('artikel tidak ditemukan');
            }
        }else{
            $artikel                        = new Artikel();
        }
        
        $artikel->judul                     = $request->judul;
        $artikel->artikel                   = $request->artikel;
        $artikel->thumbnail_file_id         = $request->thumbnail_file_id;
        $artikel->konten_file_id            = $request->konten_file_id;
        $artikel->is_active                 = $request->is_active?$request->is_active:true;
        $artikel->save();
        $artikel->refresh();
        DB::commit();
        return $this->success('Berhasil',$artikel);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:artikels,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = Artikel::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function detail(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:artikels,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = Artikel::find($request->id);
        $data->load(['konten_file','thumbnail_file']);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        if(isset($request->hide_artikel) && $request->hide_artikel == 1){
            $datas    = Artikel::select('id','judul','thumbnail_file_id')->orderBy('created_at','desc')->get();
        }else{
            $datas    = Artikel::orderBy('created_at','desc')->get();
        }
        $datas->load(['konten_file','thumbnail_file']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
