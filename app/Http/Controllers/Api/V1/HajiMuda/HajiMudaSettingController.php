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
use App\Models\HajiMudaSetting;

class HajiMudaSettingController extends Controller{
    public function create(Request $request){
        $rules = [
            'label'                 => 'required|string',
            'value_text'            => 'required|string',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user                               = User::find(Auth::id());
        $new_data                           = new HajiMudaSetting();
        $new_data->label                    = $request->label;
        $new_data->value_text               = $request->value_text;
        $new_data->save();
        $new_data->refresh();
        return $this->success('Berhasil',$new_data);
    }

    public function update(Request $request){
        $rules = [
            'label'         => 'required|integer|exists:haji_muda_settings,label',
        ];
        $user                               = User::find(Auth::id());
        $validator                          =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data                               = HajiMudaSetting::where('label',$request->label)->first();
        $payloads                           = $request->all();
        unset($payloads["id"]);
        try { 
          $data->update($payloads);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $new_data    = HajiMuda::find($request->id);
        return $this->success('Berhasil diupdate.', $new_data);
    }

    public function delete(Request $request){
        $rules = [
            'label'         => 'required|integer|exists:haji_muda_settings,label',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = HajiMudaSetting::where('label',$request->label)->first();
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function get(Request $request){
        $rules = [
            'label'         => 'required|integer|exists:haji_muda_settings,label',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = HajiMudaSetting::where('label',$request->label)->first();
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $datas    = HajiMudaSetting::all();
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
