<?php

namespace App\Http\Controllers\Api\V1\Nasabah;

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

class NasabahController extends Controller{
    public $url = 'http://182.23.49.46:8099';
    public function getToken(Request $request) {
        try{
            $client     = new \GuzzleHttp\Client();
            $response = $client->post('http://182.23.49.46:8099/token/generate-token', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'username' => 'duma',
                    'password' => 'Dum4Pa$$'
                ],
            ])->getBody();
        }catch(GuzzleHttp\Exception\ClientException $e){
            return false;
        }
        $settingBms                         = SettingBms::first();
        if(!$settingBms){
            $settingBms                     = new SettingBms();
            $settingBms->username           = 'duma';
            $settingBms->password           = 'Dum4Pa$$';
            $settingBms->id_perusahaan      = '8046';
        }
        $json   = json_decode($response);
        $settingBms->token  = $json->result->token;
        $settingBms->save();
        return $settingBms;
    }

    public function createVA(Request $request) {
        return VirtualAccount::createVA($request->nama);
    }

    public function create(Request $request){
        $rules = [
            'nama'              => 'required|string',
            'nomor_ktp'         => 'required|string',
            'nomor_hp'          => 'required|string',
            'email'             => 'required|string',
            'alamat'            => 'required|string',
            'nama_ibu'          => 'required|string',
            'tempat_lahir'      => 'required|string',
            'tanggal_lahir'     => 'required|string',
            'jenis_layanan_id'  => 'required|integer|exists:jenis_layanans,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $user                               = User::find(Auth::id());
        $new_data                           = new Nasabah();
        $new_data->user_id                  = $user->id;
        $new_data->nama                     = $request->nama;
        $new_data->nomor_ktp                = $request->nomor_ktp;
        $new_data->nomor_hp                 = $request->nomor_hp;
        $new_data->email                    = $request->email;
        $new_data->alamat                   = $request->alamat;
        $new_data->nama_ibu                 = $request->nama_ibu;
        $new_data->tempat_lahir             = $request->tempat_lahir;
        $new_data->tanggal_lahir            = $request->tanggal_lahir;
        $new_data->jenis_layanan_id         = $request->jenis_layanan_id;
        $createva                           = VirtualAccount::createVA($request->nama);
        if($createva['status'] != 0){
            return $this->failure('('.$createva['va_no'].') '.$createva['msg'].'['.$createva['status'].']');
        }
        $va_no                              = $createva['va_no'];
        if(!$va_no){
            return $this->failure('nomor va gagal digenerate');
        }
        $new_data->nomor_va                 = $va_no;
        $new_data->save();
        $new_data->refresh();
        DB::commit();
        return $this->success('Berhasil',$new_data);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:nasabahs,id',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data                               = Nasabah::find($request->id);
        $payloads                           = $request->all();
        $payloads['last_updated_by_name']   = $user->name;
        unset($payloads["id"]);
        try { 
          $data->update($payloads);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $new_data    = Nasabah::find($request->id);
        return $this->success('Berhasil diupdate.', $new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:nasabahs,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = Nasabah::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:nasabahs,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = Nasabah::find($request->id);
        return $this->success('Berhasil', $data);
    }

    public function getByVa(Request $request){
        $rules = [
            'nomor_va'         => 'required|integer|exists:nasabahs,nomor_va',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = Nasabah::select('id','nama','jenis_layanan_id')->where('nomor_va',$request->nomor_va)->first();
        $data->load(['jenis_layanan']);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $datas    = Nasabah::all();
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }

    
}
