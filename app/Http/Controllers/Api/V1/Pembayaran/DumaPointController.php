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
use App\Models\DumaPoint;

class DumaPointController extends Controller{
    public function create(Request $request){
        $rules = [
            'nominal'                   => 'required',
            'user_id'                   => 'required|integer|exists:users,id',
            'tipe'                      => 'required|in:in,out',
            'description'               => 'required|string'
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $new_data                           = new DumaPoint();
        $new_data->user_id                  = $request->user_id;
        if($request->tipe == 'in'){
            $new_data->in                   = $request->nominal;
        }else if($request->tipe == 'out'){
            $new_data->out                  = $request->nominal;
        }
        $new_data->description              = $request->description;
        $new_data->save();
        $new_data->refresh();
        DB::commit();
        return $this->success('Berhasil',$new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:duma_points,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data       = DumaPoint::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function riwayat(Request $request){
        $rules = [
            'user_id'         => 'required|integer|exists:users,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user           = User::find($request->user_id);
        $datas          = DumaPoint::where('user_id',$user->id)->get();
        return $this->success(@count($datas).' data berhasil ditampilkan.', $datas);
    }

    public function info(Request $request){
        $rules = [
            'user_id'         => 'required|integer|exists:users,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user           = User::find($request->user_id);
        $total_in       = DumaPoint::where('user_id',$user->id)->whereNotNull('in')->groupBy('user_id')->sum('in');
        $total_out      = DumaPoint::where('user_id',$user->id)->whereNotNull('out')->groupBy('user_id')->sum('out');
        $saldo          = $total_in - $total_out;
        return $this->success('Berhasil', [
            'total_in'      => $total_in,
            'total_out'     => $total_out,
            'saldo'         => $saldo
        ]);
    }
}
