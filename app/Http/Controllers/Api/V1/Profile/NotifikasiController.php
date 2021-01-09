<?php

namespace App\Http\Controllers\Api\V1\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

use Auth;
use DB;

use App\Notifications\FirebasePushNotif;
use App\Models\Notifikasi;

use App\Role;

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

   
}