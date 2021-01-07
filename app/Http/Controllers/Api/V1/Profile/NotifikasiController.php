<?php

namespace App\Http\Controllers\Api\V1\Profile;

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
use App\Helpers\VirtualAccount;
use App\Models\Nasabah;
use DB;
use App\Models\SettingBms;
use App\Notifications\FirebasePushNotif;
use App\Models\Notifikasi;
use App\Models\TabunganHaji;
use App\Models\TabunganUmrah;
use App\Role;
use App\Models\DumaPoint;
use App\Models\NotifikasiBroadcastEvent;

class NotifikasiController extends Controller{
    public function all(Request $request){
        $rules = [
            'receiver_id'       => 'required|exists:users,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $notifikasis        = Notifikasi::where('receiver_id',$request->receiver_id)->get();
        return $this->success(@count($notifikasis)." data ditampilkan.",$notifikasis);
    }

    public function create(Request $request){
        $rules = [
            'title'             => 'required|string',
            'subtitle'          => 'required|string',
            'action'            => 'required|string',
            'value'             => 'required|string',
            'receiver_id'       => 'required|exists:users,id',
            'save_notification' => 'required|integer|in:0,1',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $penerima                       = User::find($request->receiver_id);
        if($request->save_notification == 1){
            $new_notifikasi                 = new Notifikasi();
            $new_notifikasi->sender_id      = Auth::id();
            $new_notifikasi->receiver_id    = $request->receiver_id;
            $new_notifikasi->title          = $request->title;
            $new_notifikasi->subtitle       = $request->subtitle;
            $new_notifikasi->action         = $request->action;
            $new_notifikasi->value          = $request->value;
            $new_notifikasi->save();
        }else{
            $new_notifikasi                 = null;
        }
        $penerima->notify(new FirebasePushNotif($request->title, $request->subtitle, $request->action, $request->value));
        $result                         = [
            'notifikasi'                => $new_notifikasi,
            'penerima'                  => $penerima,
        ];
        return $this->success("Berhasil.",$result);
    }

    public function sendToAll(Request $request){
        $rules = [
            'title'             => 'required|string',
            'subtitle'          => 'required|string',
            'action'            => 'required|string',
            'value'             => 'required|string',
            'save_notification' => 'required|integer|in:0,1',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $filter                         = $request->filter;
        $group                          = $request->group;
        $users                          = User::whereNotNull('token_firebase')->get();
        if($filter != null){ //DEPRECATED SOON
            if($filter == 'nasabah baru daftar' || $filter == 'nasabah belum menabung' || $filter == 'nasabah proses menabung'){
                $status_id                      = 2;
                if($filter == 'nasabah baru daftar'){
                    $status_id                  = 1;
                }else if($filter == 'nasabah proses menabung'){
                    $status_id                  = 3;
                }
                $tabungan_haji_nasabah_ids      = TabunganHaji::where('status_tabungan_haji_id',$status_id)->pluck('nasabah_id')->toArray();
                $tabungan_umrah_nasabah_ids     = TabunganUmrah::where('status_tabungan_umrah_id',$status_id)->pluck('nasabah_id')->toArray();
                $nasabah_ids                    = $tabungan_haji_nasabah_ids + $tabungan_umrah_nasabah_ids;
                $user_ids                       = Nasabah::whereIn('id',$nasabah_ids)->pluck('user_id');
                $users                          = User::whereIn('id',$user_ids)->get();
            }else if($filter == 'nasabah bisa menabung'){
                $tabungan_haji_nasabah_ids      = TabunganHaji::where('status_tabungan_haji_id','>',1)->pluck('nasabah_id')->toArray();
                $tabungan_umrah_nasabah_ids     = TabunganUmrah::where('status_tabungan_umrah_id','>',1)->pluck('nasabah_id')->toArray();
                $nasabah_ids                    = $tabungan_haji_nasabah_ids + $tabungan_umrah_nasabah_ids;
                $user_ids                       = Nasabah::whereIn('id',$nasabah_ids)->pluck('user_id');
                $users                          = User::whereIn('id',$user_ids)->get();
                return $users;
            }else if($filter == 'user belum daftar tabungan'){
                $role_customer                  = Role::where('name','customer')->first();
                $nasabah_user_ids               = Nasabah::whereNotNull('id')->pluck('user_id');
                $customer_user_ids              = DB::table('role_user')->where('role_id',$role_customer->id)->pluck('user_id');
                $users                          = User::whereNotIn('id',$nasabah_user_ids)->whereIn('id',$customer_user_ids)->get();
            }
        }
        if($group != null){
            if($group == 'calon_nasabah'){
                $role_customer                  = Role::where('name','customer')->first();
                $nasabah_user_ids               = Nasabah::whereNotNull('id')->pluck('user_id');
                $customer_user_ids              = DB::table('role_user')->where('role_id',$role_customer->id)->pluck('user_id');
                $users                          = User::whereNotIn('id',$nasabah_user_ids)->whereIn('id',$customer_user_ids)->get();
            }else if($group == 'nasabah_pasif'){
                $nasabah_user_ids               = Nasabah::pluck('user_id');
                $duma_point_user_ids            = DumaPoint::whereNotNull('user_id')->pluck('user_id');
                $users                          = User::whereNotIn('id',$duma_point_user_ids)->whereIn('id',$nasabah_user_ids)->get();
            }else if($group == 'nasabah_aktif'){
                $nasabah_user_ids               = Nasabah::pluck('user_id');
                $duma_point_user_ids            = DumaPoint::whereNotNull('user_id')->pluck('user_id');
                $users                          = User::whereIn('id',$duma_point_user_ids)->whereIn('id',$nasabah_user_ids)->get();
            }
        }
        $new_event                      = new NotifikasiBroadcastEvent();
        $new_event->sender_id           = Auth::id();
        $new_event->title               = $request->title;
        $new_event->subtitle            = $request->subtitle;
        $new_event->action              = $request->action;
        $new_event->group               = $group;
        $new_event->value               = $request->value;
        $new_event->save_notification   = $request->save_notification;
        $new_event->total_target        = @count($users);
        $new_event->save();
        foreach($users as $user){
            $penerima                       = User::find($user->id);
            if($request->save_notification == 1){
                $new_notifikasi                 = new Notifikasi();
                $new_notifikasi->sender_id      = Auth::id();
                $new_notifikasi->receiver_id    = $user->id;
                $new_notifikasi->title          = $request->title;
                $new_notifikasi->subtitle       = $request->subtitle;
                $new_notifikasi->action         = $request->action;
                $new_notifikasi->value          = $request->value;
                $new_notifikasi->save();
            }else{
                $new_notifikasi                 = null;
            }
            $penerima->notify(new FirebasePushNotif($request->title, $request->subtitle, $request->action, $request->value));
        }
        return $this->success("Pesan berhasil dikirim ke ".@count($users)." pengguna aktif");
    }
}