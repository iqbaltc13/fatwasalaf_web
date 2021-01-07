<?php

namespace App\Http\Controllers\Api\V1\Haji;

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

class DaftarHajiController extends Controller{
    public function create(Request $request){
        $rules = [
            'jamaah_json'         => 'required|json',
            'kbih_id'           => 'required|integer|exists:kbihs,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $kbih           = Kbih::find($request->kbih_id);
        $jamaah_json    = json_decode($request->jamaah_json, TRUE);
        $user           = User::find(Auth::id());
        unset($jamaah_json["id"]);
        unset($jamaah_json["user"]);
        unset($jamaah_json["pendaftar"]);
        unset($jamaah_json["provinsi"]);
        unset($jamaah_json["kota"]);
        unset($jamaah_json["kecamatan"]);
        unset($jamaah_json["kelurahan"]);
        $jamaah         = Jamaah::where('nomor_ktp',$jamaah_json["nomor_ktp"])->first();
        if(!$jamaah){
            $jamaah     = Jamaah::create($jamaah_json);
        }
        if(DaftarHaji::where('jamaah_id',$jamaah->id)->count()>0){
            return $this->failure('Jamaah sudah terdaftar');
        }
        $daftar_haji                            = new DaftarHaji();
        $daftar_haji->jamaah_id                 = $jamaah->id;
        $daftar_haji->kbih_id                   = $kbih->id;
        $daftar_haji->status_daftar_haji_id     = 1;
        $daftar_haji->save();

        $daftar_haji_log                                = new DaftarHajiLog();
        $daftar_haji_log->daftar_haji_id                = $daftar_haji->id;
        $daftar_haji_log->updated_by_id                 = $user->id;
        $daftar_haji_log->updated_by_name               = '[customer] '.$user->name;
        $daftar_haji_log->status_daftar_haji_id_after   = 1;
        $daftar_haji_log->save();
        return $this->success('Berhasil',$daftar_haji);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:daftar_hajis,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $daftar_haji    = DaftarHaji::find($request->id);
        $data_update    = $request->all();
        unset($data_update["id"]);
        try { 
          $daftar_haji->update($data_update);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $daftar_haji    = DaftarHaji::find($request->id);
        $daftar_haji->jamaah;
        $daftar_haji->kbih;
        return $this->success('Berhasil diupdate.', $daftar_haji);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:daftar_hajis,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $daftar_haji    = DaftarHaji::find($request->id);
        $daftar_haji->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:daftar_hajis,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $daftar_haji    = DaftarHaji::find($request->id);
        $daftar_haji->jamaah->provinsi;
        $daftar_haji->jamaah->kota;
        $daftar_haji->jamaah->kelurahan;
        $daftar_haji->jamaah->kecamatan;
        $daftar_haji->kbih->kota;
        $daftar_haji->status_daftar_haji;
        $daftar_haji->verified_by;

        $pembayaran_administrasi    = PembayaranHaji::where('daftar_haji_id', $daftar_haji->id)->where('jenis_pembayaran_haji_id',1)->first();
        if($pembayaran_administrasi!=null){
            $daftar_haji->tanggal_administrasi_terbayar     = $pembayaran_administrasi->created_at->format('Y-m-d H:i:s');
        }
        $pembayaran_talangans                       = PembayaranHaji::where('daftar_haji_id', $daftar_haji->id)->where('jenis_pembayaran_haji_id',2)->get();
        $daftar_haji->pembayaran_talangans          = $pembayaran_talangans;
        $nominal_talangan_terbayar                  = 0;
        foreach ($pembayaran_talangans as $pembayaran_talangan) {
            $nominal_talangan_terbayar              += $pembayaran_talangan->nominal;
        }
        $daftar_haji->nominal_talangan_terbayar     = $nominal_talangan_terbayar;
        $logs                                       = DaftarHajiLog::where('daftar_haji_id',$daftar_haji->id)->orderBy('created_at','desc')->get();
        $logs->load(['status_daftar_haji_before','status_daftar_haji_after']);
        $daftar_haji->logs                          = $logs;
        return $this->success('Berhasil', $daftar_haji);
    }

    public function gets(Request $request){
        $rules = [
            'role'         => 'required|string',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $role           = $request->role;
        $user           = User::find(Auth::id());
        $daftar_hajis   = [];
        if($role == 'customer'){
            $jamaah_ids     = Jamaah::where('pendaftar_id', $user->id)->pluck('id');
            $daftar_hajis   = DaftarHaji::whereIn('jamaah_id',$jamaah_ids)->get();
            $daftar_hajis->load(['jamaah','kbih','status_daftar_haji']);
        }else if($role == 'kbih'){
            $jamaah_ids     = Jamaah::where('pendaftar_id', $user->id)->pluck('id');
            $daftar_hajis   = DaftarHaji::whereIn('jamaah_id',$jamaah_ids)->get();
            $daftar_hajis->load(['jamaah','kbih','status_daftar_haji']);
        }
        return $this->success(@count($daftar_hajis).' data daftar haji berhasil ditampilkan', $daftar_hajis);
    }

    public function all(Request $request){
        $daftar_hajis    = DaftarHaji::all();
        return $this->success(@count($daftar_hajis).' data daftar haji berhasil ditampilkan', $daftar_hajis);
    }

    public function uploadLampiran(Request $request){
        return $this->success('Berhasil');
    }
}
