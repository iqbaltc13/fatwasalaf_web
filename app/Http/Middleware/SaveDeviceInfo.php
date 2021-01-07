<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Auth;
use App\Models\ActivityRecord;

class SaveDeviceInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $user                           = Auth::user();
        $activity_record                = new ActivityRecord();
        $activity_record->activity      = $request->path();
        $activity_record->from_ip       = $request->ip();
        if($request->header('Device-Info')){
            $activity_record->device_info       = $request->header('Device-Info');
            $activity_record->app_version       = $request->header('Version-Name')."_".$request->header('Version-Code');
        }
        if (!$user) {
            $user   = auth('api')->user();
        }else{
            $activity_record->user_id           = $user->id;
            if ($request->header('Token-Firebase') && $user!=null) {
                $user->token_firebase           = $request->header('Token-Firebase');
                $user->device_info              = $request->header('Device-Info');
                $user->current_apk_version_code = $request->header('Version-Code');
                $user->current_apk_version_name = $request->header('Version-Name');
            }
            $user->last_access                  = Carbon::now();
            $user->last_activity                = $request->path();
            $user->save();
        }
        $activity_record->save();
        return $next($request);
    }
}
