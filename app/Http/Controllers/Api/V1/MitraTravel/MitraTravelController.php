<?php

namespace App\Http\Controllers\Api\V1\MitraTravel;

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
use App\Models\MitraTravel;

class MitraTravelController extends Controller{
    public function upsert(Request $request){
        $rules = [
            'nama'      => 'required|string',
            'logo_id'   => 'required|int|exists:files,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data_request 	                    = $request->all();
        if(isset($request->id)){
            $data                           = MitraTravel::find($request->id);
            if(!$data){
                return $this->failure('Mitra Travel tidak ditemukan');
            }
            $data->update($data_request);
        }else{
            $data                           = MitraTravel::create($data_request);
        }
        $data->refresh();
        return $this->success('Berhasil',$data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:mitra_travels,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = MitraTravel::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function detail(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:mitra_travels,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = MitraTravel::find($request->id);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $datas    = MitraTravel::where('is_active',1)->orderBy('order','asc')->get();
        $datas->load(['logo']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
