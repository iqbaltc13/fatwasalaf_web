<?php

namespace App\Http\Controllers\Api\V1\Pembayaran;

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
use App\Models\Pembayaran;
use DB;
use Carbon\Carbon;
use App\Models\DumaCash;

class DumaCashController extends Controller{
    public function create(Request $request){
        $rules = [
            'nominal'                       => 'required',
            'nomor_va'                      => 'required|string|exists:nasabahs,nomor_va',
            'tipe'                          => 'required|in:in,out',
            'description'                   => 'required|string'
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $nasabah                            = Nasabah::where('nomor_va',$request->nomor_va)->first();
        if(!$nasabah){
            return $this->failure('Nasabah dengan no_va '.$request->nomor_va.' tidak ditemukan');
        }
        DB::beginTransaction();
        $new_data                           = new DumaCash();
        if($request->tipe == 'in'){
            $new_data->in                   = $request->nominal;
        }else if($request->tipe == 'out'){
            $new_data->out                  = $request->nominal;
        }
        $new_data->description              = $request->description;
        $new_data->nasabah_id               = $nasabah->id;
        $new_data->save();
        $new_data->refresh();
        DB::commit();
        return $this->success('Berhasil',$new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:duma_cashes,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = DumaCash::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function riwayat(Request $request){
        $rules = [
            'nasabah_id'         => 'required|integer|exists:nasabahs,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $nasabah        = Nasabah::find($request->nasabah_id);
        $datas          = DumaCash::where('nasabah_id',$nasabah->id)->get();
        return $this->success(@count($datas).' data berhasil ditampilkan.', $datas);
    }

    public function info(Request $request){
        $rules = [
            'nasabah_id'         => 'required|integer|exists:nasabahs,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $nasabah        = Nasabah::find($request->nasabah_id);
        $total_in       = DumaCash::where('nasabah_id',$nasabah->id)->whereNotNull('in')->groupBy('nasabah_id')->sum('in');
        $total_out      = DumaCash::where('nasabah_id',$nasabah->id)->whereNotNull('out')->groupBy('nasabah_id')->sum('out');
        $saldo          = $total_in - $total_out;
        return $this->success('Berhasil', [
            'total_in'      => $total_in,
            'total_out'     => $total_out,
            'saldo'         => $saldo
        ]);
    }
}
