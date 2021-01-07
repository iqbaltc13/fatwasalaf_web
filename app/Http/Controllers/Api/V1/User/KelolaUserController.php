<?php

namespace App\Http\Controllers\Api\V1\User;

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
use App\Models\TabunganHaji;
use App\Helpers\VirtualAccount;
use App\Models\Nasabah;
use App\Models\Pembayaran;
use DB;
use Carbon\Carbon;
use App\Models\PaketTabunganHaji;
use App\Models\DumaPoint;
use App\Models\DumaCash;
use App\Role;
USE Config;
use App\Models\RoleUser;

class KelolaUserController extends Controller{
    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:users,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user           = User::find($request->id);
        $user->load(['file','user_devices']);

        //saldo
        $point_total_in         = DumaPoint::where('user_id',$user->id)->whereNotNull('in')->groupBy('user_id')->sum('in');
        $point_total_out        = DumaPoint::where('user_id',$user->id)->whereNotNull('out')->groupBy('user_id')->sum('out');
        $point_saldo            = $point_total_in - $point_total_out;
        $user->point_saldo      = $point_saldo;

        $nasabah_ids            = Nasabah::where('user_id',$user->id)->pluck('id');
        $cash_total_in          = DumaCash::whereIn('nasabah_id',$nasabah_ids)->whereNotNull('in')->sum('in');
        $cash_total_out         = DumaCash::whereIn('nasabah_id',$nasabah_ids)->whereNotNull('out')->sum('out');
        $cash_saldo             = $cash_total_in - $cash_total_out;
        $user->cash_saldo       = $cash_saldo;

        $nasabah_ids            = Nasabah::where('user_id',$user->id)->pluck('id');
        $tabungan_hajis         = TabunganHaji::whereIn('nasabah_id',$nasabah_ids)->get();
        $tabungan_hajis->load(['status_tabungan_haji','paket_tabungan_haji','nasabah']);
        $user->tabungan_hajis   = $tabungan_hajis;

        $tabungan_umrahs         = TabunganUmrah::whereIn('nasabah_id',$nasabah_ids)->get();
        $tabungan_umrahs->load(['status_tabungan_umrah','paket_tabungan_umrah','nasabah']);
        $user->tabungan_umrahs   = $tabungan_umrahs;

        $role_ids                   = DB::table('role_user')->where('user_id',$user->id)->pluck('role_id');
        $roles                      = Role::whereIn('id',$role_ids)->pluck('name')->toArray();
        $user->roles                = implode(",",$roles);
        return $this->success('Berhasil', $user);
    }

    public function all(Request $request){
        $rules = [
            'role_name'   => 'required|string|exists:roles,name',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $role           = Role::where('name',$request->role_name)->first();
        if($role==null){
            return $this->failure('role '.$request->role_name.' tidak ditemukan');
        }
        $user_ids       = DB::table('role_user')->where('role_id',$role->id)->pluck('user_id');
        $datas          = User::whereIn('id',$user_ids)->orderBy('last_access','desc')->get();
        $datas->load(['file']);
        foreach ($datas as $value) {
            $user                   = User::find(Auth::id());
            $point_total_in         = DumaPoint::where('user_id',$user->id)->whereNotNull('in')->groupBy('user_id')->sum('in');
            $point_total_out        = DumaPoint::where('user_id',$user->id)->whereNotNull('out')->groupBy('user_id')->sum('out');
            $point_saldo            = $point_total_in - $point_total_out;
            $value->point_saldo     = $point_saldo;

            $nasabah_ids            = Nasabah::where('user_id',$user->id)->pluck('id');
            $cash_total_in          = DumaCash::whereIn('nasabah_id',$nasabah_ids)->whereNotNull('in')->groupBy('nasabah_id')->sum('in');
            $cash_total_out         = DumaCash::whereIn('nasabah_id',$nasabah_ids)->whereNotNull('out')->groupBy('nasabah_id')->sum('out');
            $cash_saldo             = $cash_total_in - $cash_total_out;
            $value->cash_saldo      = $cash_saldo;
        }
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }

    public function create(Request $request){
        $rules = [
            'name'          => 'required|string',
            'email'         => 'required|string|email',
            'phone'         => 'required|string',
            'password'      => 'required|string|confirmed',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'role_names'    => 'required|string',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $user               = User::where('email',$request->email)->first();
        if (!$user) {
            $user           = new User();
            if (User::where('phone',$request->phone)->count()>0) {
                return $this->failure(['Nomor telepon yang anda inputkan sudah terdaftar.']);
            }
        }else{
            if ($user->is_active==1) {
                return $this->failure(['Email yang anda inputkan sudah terdaftar.']);
            }
            if (User::where('phone',$request->phone)->where('id','!=',$user->id)->count()>0 && $user->is_active == 0) {
                return $this->failure(['Nomor telepon yang anda inputkan sudah terdaftar.']);
            }
        }
        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->phone                = $request->phone;
        $user->password             = $request->password;
        $user->jenis_kelamin        = $request->jenis_kelamin;
        $user->number_id            = VirtualAccount::generateMyDumaNumberId();
        $user->is_active            = 1;
        $user->email_verified_at    = Carbon::now();
        $user->phone_verified_at    = Carbon::now();
        $user->save();
        $role_names_json    = json_decode($request->role_names, TRUE);
        $role_ids           = Role::whereIn('name',$role_names_json)->pluck('id');
        $user->roles()->sync($role_ids);
        DB::commit();
        return $this->success('Berhasil', $user);
    }

    public function setRole(Request $request){
        $rules = [
            'id'            => 'required|integer|exists:users,id',
            'role_names'    => 'required|string',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user                       = User::find($request->id);
        $role_names_json            = json_decode($request->role_names, TRUE);
        $role_ids                   = Role::whereIn('name',$role_names_json)->pluck('id');
        $user->roles()->sync($role_ids);
        $role_ids                   = DB::table('role_user')->where('user_id',$user->id)->pluck('role_id');
        $roles                      = Role::whereIn('id',$role_ids)->pluck('name')->toArray();
        $user->roles                = implode(",",$roles);
        return $this->success('Berhasil', $user);
    }
}
