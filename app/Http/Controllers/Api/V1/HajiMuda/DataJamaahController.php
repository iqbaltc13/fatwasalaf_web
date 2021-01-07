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
use App\Models\DataJamaah;

class DataJamaahController extends Controller{
    public function create(Request $request){
        $rules = [
            'nasabah_id'            => 'required|integer|exists:nasabahs,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user                               = User::find(Auth::id());
        $new_data                           = DataJamaah::create($request->all());
        $new_data->refresh();
        return $this->success('Berhasil',$new_data);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:data_jamaahs,id',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data                               = DataJamaah::find($request->id);
        $payloads                           = $request->all();
        unset($payloads["id"]);
        try { 
          $data->update($payloads);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $new_data    = DataJamaah::find($request->id);
        return $this->success('Berhasil diupdate.', $new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:data_jamaahs,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = DataJamaah::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:data_jamaahs,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = DataJamaah::find($request->id);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $datas    = DataJamaah::all();
        // $datas->load(['detail_biaya.icon']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
