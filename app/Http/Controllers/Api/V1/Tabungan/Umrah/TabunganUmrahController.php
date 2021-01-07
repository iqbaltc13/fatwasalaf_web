<?php

namespace App\Http\Controllers\Api\V1\Tabungan\Umrah;

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
use App\Models\StatusTabunganUmrah;
use App\Helpers\VirtualAccount;
use App\Models\Nasabah;
use DB;

class TabunganUmrahController extends Controller{
    public function create(Request $request){
        $rules = [
            'nasabah_json'                  => 'required|json',
            'tahun_rencana_berangkat'       => 'required|integer',
            'paket_tabungan_umrah_id'       => 'required|integer|exists:paket_tabungan_umrahs,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $jenis_layanan_id                   = 2;
        $user                               = User::find(Auth::id());
        $paket                              = PaketTabunganUmrah::find($request->paket_tabungan_umrah_id);
        $nasabah_json                       = json_decode($request->nasabah_json, TRUE);
        unset($nasabah_json["id"]);
        $nasabah_json["user_id"]            = $user->id;
        $nasabah_json["jenis_layanan_id"]   = $jenis_layanan_id;
        $nasabah                            = Nasabah::create($nasabah_json);

        $new_data                           = new TabunganUmrah();
        $new_data->nasabah_id               = $nasabah->id;
        $new_data->paket_tabungan_umrah_id  = $paket->id;
        $new_data->tahun_rencana_berangkat  = $request->tahun_rencana_berangkat;
        $new_data->biaya_administrasi       = $paket->biaya_administrasi;
        $new_data->nominal_tabungan         = $paket->nominal_tabungan;
        $new_data->catatan_customer         = $request->catatan_customer;
        $new_data->status_tabungan_umrah_id = 1;
        $new_data->save();
        $new_data->refresh();
        $new_data->load(['pembayarans','nasabah','status_tabungan_umrah','paket_tabungan_umrah']);
        DB::commit();
        return $this->success('Berhasil',$new_data);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:tabungan_umrahs,id',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data                               = TabunganUmrah::find($request->id);
        $payloads                           = $request->all();
        $payloads['last_updated_by_name']   = $user->name;
        unset($payloads["id"]);
        try { 
          $data->update($payloads);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $new_data    = TabunganUmrah::find($request->id);
        return $this->success('Berhasil diupdate.', $new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:tabungan_umrahs,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = TabunganUmrah::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:tabungan_umrahs,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = TabunganUmrah::find($request->id);
        $data->load(['pembayarans.nasabah','pembayarans.jenis_layanan','pembayarans.jenis_pembayaran','nasabah.foto_ktp','nasabah.foto_ktp_selfie',
            'nasabah.provinsi','nasabah.kota','nasabah.kecamatan','nasabah.kelurahan',
            'status_tabungan_umrah','paket_tabungan_umrah']);
        foreach ($data->pembayarans as $key => $value){
            $value->file;
        }
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        if($request->status_tabungan_umrah_id && $request->status_tabungan_umrah_id!= 0){
            $datas      = TabunganUmrah::where('status_tabungan_umrah_id',$request->status_tabungan_umrah_id)->orderBy('created_at','desc')->get();
        }else{
            $datas      = TabunganUmrah::orderBy('created_at','desc')->get();
        }
        $datas->load(['nasabah','status_tabungan_umrah','paket_tabungan_umrah']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }

    public function riwayat(Request $request){
        $user           = User::find(Auth::id());
        $nasabah_ids    = Nasabah::where('user_id',$user->id)->pluck('id');
        $datas          = TabunganUmrah::whereIn('nasabah_id',$nasabah_ids)->orderBy('created_at','desc')->get();
        $datas->load(['status_tabungan_umrah','nasabah','pembayarans','paket_tabungan_umrah']);
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }

    public function infoTotal(Request $request){
        $results        = [];
        $semua          = [
            'id'                => 0,
            'display_name'      => 'Semua',
            'total'             => TabunganUmrah::whereNotNull('id')->count(),
        ];
        array_push($results, $semua);
        $datas    = StatusTabunganUmrah::select('id','display_name')->get();
        foreach ($datas as $value) {
            $value->total   = TabunganUmrah::where('status_tabungan_umrah_id',$value->id)->count();
            array_push($results, $value);
        }
        return $this->success(@count($results).' data berhasil ditampilkan', $results);
    }

    public function dummy(Request $request){
        $rules = [
            'total'       => 'required|integer',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $jenis_layanan_id                   = 2;
        $user                               = User::find(Auth::id());
        $paket                              = PaketTabunganUmrah::first();
        $total                              = $request->total;
        $new_nasabah_ids                    = [];
        $new_tabungan_ids                   = [];
        for ($i=0; $i < $total; $i++) {
            $nama                               = 'Nasabah '.$i;
            $new_nasabah                           = new Nasabah();
            $new_nasabah->user_id                  = $user->id;
            $new_nasabah->nama                     = $nama;
            $new_nasabah->nomor_ktp                = '123456789';
            $new_nasabah->nomor_hp                 = '082245947379';
            $new_nasabah->email                    = 'nasabah'.$i.'@gmail.com';
            $new_nasabah->alamat                   = 'dummy';
            $new_nasabah->nama_ibu                 = '-';
            $new_nasabah->tempat_lahir             = '-';
            $new_nasabah->tanggal_lahir            = '1994-03-12';
            $new_nasabah->jenis_layanan_id         = $jenis_layanan_id;
            $createva                           = VirtualAccount::createVA($nama);
            if($createva['status'] != 0){
                return $this->failure('('.$createva['va_no'].') '.$createva['msg'].'['.$createva['status'].']');
            }
            $va_no                              = $createva['va_no'];
            if(!$va_no){
                return $this->failure('nomor va gagal digenerate');
            }
            $new_nasabah->nomor_va                 = $va_no;
            $new_nasabah->save();
            $new_nasabah->refresh();
            array_push($new_nasabah_ids,$new_nasabah->id);

            $new_tabungan                           = new TabunganUmrah();
            $new_tabungan->nasabah_id               = $new_nasabah->id;
            $new_tabungan->paket_tabungan_umrah_id  = $paket->id;
            $new_tabungan->tahun_rencana_berangkat  = '2025';
            $new_tabungan->biaya_administrasi       = $paket->biaya_administrasi;
            $new_tabungan->nominal_tabungan         = $paket->nominal_tabungan;
            $new_tabungan->catatan_customer         = 'dummy data';
            $new_tabungan->status_tabungan_umrah_id = 1;
            $new_tabungan->save();
            $new_tabungan->refresh();
            array_push($new_tabungan_ids,$new_tabungan->id);
            
        }
        DB::commit();
        $nomor_va_nasabahs  = Nasabah::select('nama','nomor_va')->whereIn('id',$new_nasabah_ids)->get();
        return $this->success('Berhasil',$nomor_va_nasabahs);
    }
}
