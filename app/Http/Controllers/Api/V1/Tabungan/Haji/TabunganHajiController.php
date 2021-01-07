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
use App\Models\TabunganHaji;
use App\Models\StatusTabunganHaji;
use App\Helpers\VirtualAccount;
use App\Models\Nasabah;
use DB;
use DateTime;

class TabunganHajiController extends Controller{
    public function create(Request $request){
        $rules = [
            'nasabah_json'                  => 'required|json',
            'paket_tabungan_haji_id'        => 'required|integer|exists:paket_tabungan_hajis,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $jenis_layanan_id                   = 1;
        $user                               = User::find(Auth::id());
        $paket                              = PaketTabunganHaji::find($request->paket_tabungan_haji_id);
        $nasabah_json                       = json_decode($request->nasabah_json, TRUE);
        unset($nasabah_json["id"]);
        $nasabah_json["user_id"]            = $user->id;
        $nasabah_json["jenis_layanan_id"]   = $jenis_layanan_id;
        $dateTimeTanggalLahir               = new DateTime($nasabah_json["tanggal_lahir"]);
        $nasabah_json["tanggal_lahir"]      = $dateTimeTanggalLahir->format('Y-m-d H:i:s');
        $nasabah                            = Nasabah::create($nasabah_json);

        $new_data                           = new TabunganHaji();
        $new_data->nasabah_id               = $nasabah->id;
        $new_data->tahun_rencana_berangkat  = $request->tahun_rencana_berangkat;
        $new_data->paket_tabungan_haji_id   = $paket->id;
        $new_data->biaya_administrasi       = $paket->biaya_administrasi;
        $new_data->nominal_tabungan         = $paket->nominal_tabungan;
        $new_data->catatan_customer         = $request->catatan_customer;
        $new_data->status_tabungan_haji_id = 1;
        $new_data->save();
        $new_data->refresh();
        $new_data->load(['pembayarans','nasabah','status_tabungan_haji','paket_tabungan_haji']);
        DB::commit();
        return $this->success('Berhasil',$new_data);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:tabungan_hajis,id',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data                               = TabunganHaji::find($request->id);
        $payloads                           = $request->all();
        $payloads['last_updated_by_name']   = $user->name;
        unset($payloads["id"]);
        try { 
          $data->update($payloads);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $new_data    = TabunganHaji::find($request->id);
        return $this->success('Berhasil diupdate.', $new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:tabungan_hajis,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = TabunganHaji::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:tabungan_hajis,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data                   = TabunganHaji::find($request->id);
        $data->load(['pembayarans.nasabah','pembayarans.jenis_layanan','pembayarans.jenis_pembayaran','nasabah.foto_ktp','nasabah.foto_ktp_selfie',
            'nasabah.provinsi','nasabah.kota','nasabah.kecamatan','nasabah.kelurahan','status_tabungan_haji','paket_tabungan_haji']);
        foreach ($data->pembayarans as $key => $value){
            $value->file;
        }
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        if($request->status_tabungan_haji_id && $request->status_tabungan_haji_id!= 0){
            $datas      = TabunganHaji::where('status_tabungan_haji_id',$request->status_tabungan_haji_id)->orderBy('created_at','desc')->get();
        }else{
            $datas      = TabunganHaji::orderBy('created_at','desc')->get();
        }
        $datas->load(['nasabah','status_tabungan_haji','paket_tabungan_haji']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }

    public function riwayat(Request $request){
        $user           = User::find(Auth::id());
        $nasabah_ids    = Nasabah::where('user_id',$user->id)->pluck('id');
        $datas          = TabunganHaji::whereIn('nasabah_id',$nasabah_ids)->orderBy('created_at','desc')->get();
        $datas->load(['pembayarans','paket_tabungan_haji','status_tabungan_haji','nasabah']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }

    public function infoTotal(Request $request){
        $results        = [];
        $semua          = [
            'id'        => 0,
            'display_name'      => 'Semua',
            'total'     => TabunganHaji::whereNotNull('id')->count(),
        ];
        array_push($results, $semua);
        $datas    = StatusTabunganHaji::select('id','display_name')->get();
        foreach ($datas as $value) {
            $value->total   = TabunganHaji::where('status_tabungan_haji_id',$value->id)->count();
            array_push($results, $value);
        }
        return $this->success(@count($results).' data berhasil ditampilkan', $results);
    }
}
