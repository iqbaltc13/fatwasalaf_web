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
use App\Models\HajiMuda;

class HajiMudaController extends Controller{
    public function create(Request $request){
        $rules = [
            'nasabah_json'          => 'required|json',
            'data_pasangan_json'    => 'required|json',
            'data_keluarga_json'    => 'required|json',
            'data_sosmed_json'      => 'required|json',
            'data_pekerjaan_json'   => 'required|json',
            'data_keuangan_json'    => 'required|json',
            'data_jamaah_json'      => 'required|json',
            'paket_haji_muda_id'    => 'required|integer|exists:paket_haji_mudas,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user                               = User::find(Auth::id());

        $nasabah_json                       = json_decode($request->nasabah_json, TRUE);
        $nasabah                            = Nasabah::create($nasabah_json);

        $data_pasangan_json                 = json_decode($request->data_pasangan_json, TRUE);
        $data_pasangan                      = DataKeluarga::create($data_pasangan_json);

        $data_keluarga_json                 = json_decode($request->data_keluarga_json, TRUE);
        $data_keluarga                      = DataKeluarga::create($data_keluarga_json);

        $data_sosmed_json                   = json_decode($request->data_sosmed_json, TRUE);
        $data_sosmed                        = DataSosmed::create($data_sosmed_json);

        $data_pekerjaan_json                = json_decode($request->data_pekerjaan_json, TRUE);
        $data_pekerjaan                     = DataPekerjaan::create($data_pekerjaan_json);

        $data_keuangan_json                 = json_decode($request->data_keuangan_json, TRUE);
        $data_keuangan                      = DataKeuangan::create($data_keuangan_json);

        $data_jamaah_json["data_pasangan_id"]   = $data_pasangan->id;
        $data_jamaah_json["data_keluarga_id"]   = $data_keluarga->id;
        $data_jamaah_json["data_sosmed_id"]     = $data_sosmed->id;
        $data_jamaah_json["data_pekerjaan_id"]  = $data_pekerjaan->id;
        $data_jamaah_json["data_keuangan_id"]   = $data_keuangan->id;
        unset($data_jamaah_json["id"]);
        unset($data_jamaah_json["data_pasangan"]);
        unset($data_jamaah_json["data_keluarga"]);
        unset($data_jamaah_json["data_sosmed"]);
        unset($data_jamaah_json["data_pekerjaan"]);
        unset($data_jamaah_json["data_keuangan"]);
        $data_jamaah_json                       = json_decode($request->data_jamaah_json, TRUE);
        $data_jamaah                            = DataJamaah::create($data_jamaah_json);

        $new_data                           = new HajiMuda();
        $new_data->nasabah_id               = $request->nasabah_id;
        $new_data->data_jamaah_id           = $request->data_jamaah_id;
        $new_data->paket_haji_muda_id       = $request->paket_haji_muda_id;
        $new_data->nominal_dp               = $request->nominal_dp;
        $new_data->nominal_angsuran         = $request->nominal_angsuran;
        $new_data->total_bulan_angsuran     = $request->total_bulan_angsuran;
        $new_data->catatan_admin            = $request->catatan_admin;
        $new_data->catatan_customer         = $request->catatan_customer;
        $new_data->status_id                = 1;
        $new_data->kota_id                  = $request->kota_id;
        $new_data->save();
        $new_data->refresh();
        return $this->success('Berhasil',$new_data);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:haji_mudas,id',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        if($request->is_default && $request->is_default == 1){
            PaketHajiMuda::whereNotNull('is_default')->update(['is_default' => 0]);
        }
        $data                               = HajiMuda::find($request->id);
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
            'id'         => 'required|integer|exists:haji_mudas,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = HajiMuda::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:haji_mudas,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = HajiMuda::find($request->id);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $datas    = HajiMuda::all();
        // $datas->load(['detail_biaya.icon']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
