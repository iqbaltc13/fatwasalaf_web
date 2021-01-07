<?php

namespace App\Http\Controllers\Api\V1\Tabungan\Haji;

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
use App\Models\PaketTabunganHaji;

class PaketTabunganHajiController extends Controller{
    public function create(Request $request){
        $rules = [
            'nominal_tabungan'      => 'required|integer',
            'biaya_administrasi'    => 'required|integer',
            'deskripsi'             => 'required|string',
            'nama'                  => 'required|string',
            'is_default'            => 'required|boolean',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user                   = User::find(Auth::id());
        $data                   = PaketTabunganHaji::where('nama',$request->nama)->first();
        if($data){
            return $this->failure('Paket '.$request->nama.' sudah ada');
        }
        if($request->is_default == 1){
            PaketTabunganHaji::whereNotNull('is_default')->update(['is_default' => 0]);
        }
        $new_data                       = new PaketTabunganHaji();
        $new_data->nominal_tabungan     = $request->nominal_tabungan;
        $new_data->biaya_administrasi   = $request->biaya_administrasi;
        $new_data->deskripsi            = $request->deskripsi;
        $new_data->nama                 = $request->nama;
        $new_data->is_default           = $request->is_default;
        $new_data->created_by_name      = $user->name;
        $new_data->save();
        $new_data->refresh();
        return $this->success('Berhasil',$new_data);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:paket_tabungan_hajis,id',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        if($request->is_default && $request->is_default == 1){
            PaketTabunganHaji::whereNotNull('is_default')->update(['is_default' => 0]);
        }
        $data                               = PaketTabunganHaji::find($request->id);
        $payloads                           = $request->all();
        $payloads['last_updated_by_name']   = $user->name;
        unset($payloads["id"]);
        try { 
          $data->update($payloads);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $new_data    = PaketTabunganHaji::find($request->id);
        return $this->success('Berhasil diupdate.', $new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:paket_tabungan_hajis,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = PaketTabunganHaji::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function default(Request $request){
        $data           = PaketTabunganHaji::where('is_default',1)->first();
        return $this->success('Berhasil', $data);
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:paket_tabungan_hajis,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = PaketTabunganHaji::find($request->id);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $datas    = PaketTabunganHaji::all();
        $datas->load(['detail_biaya.icon']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
