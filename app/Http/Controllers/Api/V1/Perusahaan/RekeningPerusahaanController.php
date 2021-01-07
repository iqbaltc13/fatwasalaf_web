<?php

namespace App\Http\Controllers\Api\V1\Perusahaan;

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
use App\Models\Pembayaran;
use DB;
use Carbon\Carbon;
use App\Models\RekeningPerusahaan;

class RekeningPerusahaanController extends Controller{
    public function create(Request $request){
        $rules = [
            'nomor_rekening'        => 'required|string|unique:rekening_perusahaans,nomor_rekening',
            'atas_nama'             => 'required|string',
            'nama_bank'             => 'required|string',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }

        DB::beginTransaction();
        $new_data                           = new RekeningPerusahaan();
        $new_data->nomor_rekening           = $request->nomor_rekening;
        $new_data->atas_nama                = $request->atas_nama;
        $new_data->nama_bank                = $request->nama_bank;
        $new_data->status_aktif             = $request->status_aktif?$request->status_aktif:1;
        $new_data->keterangan               = $request->keterangan;
        $new_data->logo_bank_id             = $request->logo_bank_id;
        $new_data->save();
        $new_data->refresh();
        DB::commit();
        return $this->success('Berhasil',$new_data);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:rekening_perusahaans,id',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data                               = RekeningPerusahaan::find($request->id);
        $payloads                           = $request->all();
        unset($payloads["id"]);
        try { 
          $data->update($payloads);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $new_data    = RekeningPerusahaan::find($request->id);
        return $this->success('Berhasil diupdate.', $new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:rekening_perusahaans,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = RekeningPerusahaan::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function all(Request $request){
        $datas    = RekeningPerusahaan::all();
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }

    public function available(Request $request){
        $datas    = RekeningPerusahaan::where('status_aktif',1)->get();
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
