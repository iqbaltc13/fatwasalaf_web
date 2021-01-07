<?php

namespace App\Http\Controllers\Api\V1\Haji;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use App\Models\Jamaah;
use App\Models\DaftarHaji;
use App\Models\Kbih;
use App\Models\SettingNominalHajiMuda;
use Auth;

class DaftarHajiKbihController extends Controller{
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
        $daftar_haji->jamaah;
        $daftar_haji->kbih;
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
            $daftar_hajis->load(['jamaah','kbih','statusDaftarHaji']);
        }else if($role == 'kbih'){
            $jamaah_ids     = Jamaah::where('pendaftar_id', $user->id)->pluck('id');
            $daftar_hajis   = DaftarHaji::whereIn('jamaah_id',$jamaah_ids)->get();
            $daftar_hajis->load(['jamaah','kbih','statusDaftarHaji']);
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
