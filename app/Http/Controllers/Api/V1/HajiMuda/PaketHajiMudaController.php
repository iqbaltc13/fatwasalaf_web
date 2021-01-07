<?php

namespace App\Http\Controllers\Api\V1\HajiMuda;

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
use App\Models\PaketHajiMuda;

class PaketHajiMudaController extends Controller{
    public function upsert(Request $request){
        $rules = [
            'nama'                  => 'required|string',
            'deskripsi'             => 'required|string',
            'is_default'            => 'required|boolean',
            'nominal_dp'            => 'required|integer',
            'nominal_angsuran'      => 'required|integer',
            'total_bulan_angsuran'  => 'required|integer',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user                   = User::find(Auth::id());
        if(isset($request->id)){
            $data               = PaketHajiMuda::find($request->id);
            if($data){
                $this->failure('Paket tidak ditemukan');
            }
        }else{
            $data               = PaketHajiMuda::where('nama',$request->nama)->first();
            if($data){
                return $this->failure('Paket '.$request->nama.' sudah ada');
            }
            $data               = new PaketHajiMuda();
        }
        if($request->is_default == 1){
            PaketHajiMuda::whereNotNull('is_default')->update(['is_default' => 0]);
        }
        $new_data                           = new PaketHajiMuda();
        $new_data->nama                     = $request->nama;
        $new_data->deskripsi                = $request->deskripsi;
        $new_data->rincian                  = $request->rincian;
        $new_data->nominal_dp               = $request->nominal_dp;
        $new_data->nominal_angsuran         = $request->nominal_angsuran;
        $new_data->total_bulan_angsuran     = $request->total_bulan_angsuran;
        $new_data->is_default               = $request->is_default;
        $new_data->created_by_name          = $user->name;
        $new_data->last_updated_by_name     = $user->name;
        $new_data->save();
        $new_data->refresh();
        return $this->success('Berhasil',$new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:paket_haji_mudas,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = PaketHajiMuda::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function default(Request $request){
        $data           = PaketHajiMuda::where('is_default',1)->first();
        return $this->success('Berhasil', $data);
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:paket_haji_mudas,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = PaketHajiMuda::find($request->id);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $datas    = PaketHajiMuda::all();
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
