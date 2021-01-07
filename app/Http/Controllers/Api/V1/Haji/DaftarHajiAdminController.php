<?php

namespace App\Http\Controllers\Api\V1\Haji;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use App\Models\Jamaah;
use App\Models\DaftarHaji;
use App\Models\Kbih;
use App\Models\SettingNominalHajiMuda;
use App\Models\StatusDaftarHaji;
use Auth;

class DaftarHajiAdminController extends Controller{
    public function totalByStatus(Request $request){
        $status_daftars = StatusDaftarHaji::select('id','name','display_name')->get();
        foreach ($status_daftars as $status_daftar) {
            $status_daftar->total   = DaftarHaji::where('status_daftar_haji_id',$status_daftar->id)->count();
        }
        return $this->success(@count($status_daftars).' data daftar haji berdasarkan status pendaftaran berhasil ditampilkan', $status_daftars);
    }

    public function getsByStatus(Request $request){
        $rules = [
            'status_daftar_haji_id'         => 'required|integer',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $status_daftar  = StatusDaftarHaji::find($request->status_daftar_haji_id);
        if($status_daftar){
            $daftar_hajis   = DaftarHaji::where('status_daftar_haji_id',$status_daftar->id)->get();
        }else{
            $daftar_hajis   = DaftarHaji::get();
        }
        $daftar_hajis->load(['jamaah','kbih','status_daftar_haji']);
        return $this->success(@count($daftar_hajis).' data daftar haji berhasil ditampilkan', $daftar_hajis);
    }

    public function uploadLampiran(Request $request){
        return $this->success('Berhasil');
    }
}
