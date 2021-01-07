<?php

namespace App\Http\Controllers\Api;

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
use App\Models\ActivityRecord;

class ActivityRecordController extends Controller{
    public function create(Request $request){
        $rules = [
            'activity'              => 'required|string',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $new_data                       = new ActivityRecord();
        $new_data->activity             = $request->activity;
        $new_data->from_ip              = $request->ip();
        $new_data->device_info          = $request->header('Device-Info');
        $new_data->app_version          = $request->header('Version-Name')."_".$request->header('Version-Code');
        $new_data->user_id              = Auth::id();
        $new_data->save();

        $user                           = User::find(Auth::id());
        if($user!=null){
            $user->last_activity        = $request->activity;
            $user->save();
        }
        
        return $this->success('');
    }
}
