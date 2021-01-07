<?php

namespace App\Http\Controllers\Api\V1\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use App\Models\DumaCash;
use App\Models\DumaPoint;
use Auth;
use App\Models\Nasabah;
use App\Helpers\VirtualAccount;
use Mail;
use Illuminate\Support\Str;
use App\Models\ActivityRecord;
use App\ThirdParties\Sms\ChuangLanSMSConnection;
use DB;
use App\Models\ConfirmationUser;
use Carbon\Carbon;
use App\Http\Controllers\Helpers\EmailHelperController;
use stdClass;
use DateTime;
use DateInterval;

class ProfileController extends Controller{
    public function __construct(){
        $this->email_helper   = new EmailHelperController();
    }
    public function saldo(Request $request){
        $user                   = User::find(Auth::id());
        $point_total_in         = DumaPoint::where('user_id',$user->id)->whereNotNull('in')->sum('in');
        $point_total_out        = DumaPoint::where('user_id',$user->id)->whereNotNull('out')->sum('out');
        $point_saldo            = $point_total_in - $point_total_out;
        $info_point             = [
            'total_in'      => $point_total_in,
            'total_out'     => $point_total_out,
            'saldo'         => $point_saldo
        ];

        $nasabah_ids            = Nasabah::where('user_id',$user->id)->pluck('id');
        $cash_total_in          = DumaCash::whereIn('nasabah_id',$nasabah_ids)->whereNotNull('in')->sum('in');
        $cash_total_out         = DumaCash::whereIn('nasabah_id',$nasabah_ids)->whereNotNull('out')->sum('out');
        $cash_saldo             = $cash_total_in - $cash_total_out;
        $info_cash              = [
            'total_in'      => $cash_total_in,
            'total_out'     => $cash_total_out,
            'saldo'         => $cash_saldo
        ];
        $saldo                  = $point_saldo + $cash_saldo;

        $result                 = [
            'info_point'    => $info_point,
            'info_cash'     => $info_cash,
            'saldo'         => $saldo,
        ];
        return $this->success('Berhasil',$result);
    }

    public function generateNumberId(Request $request){
        $users  = User::whereNull('number_id')->orWhere('number_id','')->get();
        foreach($users as $user){
            $update     = User::find($user->id);
            $update->number_id  = VirtualAccount::generateMyDumaNumberId();
            $update->save();
        }
        return $this->success(@count($users).' user berhasil digeneratekan number id.');
    }

    public function get(Request $request){
        $user = User::find(Auth::id());
        $user->load(['file']);
        return $this->success('Berhasil',$user);
    }

    public function update(Request $request){
    	$user 			= $request->user();
        $data_update 	= $request->all();
        if (isset($request->email)) {
        	if (User::where('email', $request->email)->where('id','!=',$user->id)->count() > 0) {
        		return $this->failure('Email has already been taken');
        	}
        }
        if (isset($request->phone_number)) {
        	if (User::where('phone_number', $request->phone_number)->where('id','!=',$user->id)->count() > 0) {
        		return $this->failure('Phone number has already been taken');
        	}
        }
        try { 
          	User::where('id', $user->id)->update($data_update);
        } catch(\Illuminate\Database\QueryException $ex){ 
          	return $this->failure($ex->errorInfo);
        }
        $user = User::find($user->id);
        $user->file;
        $user->jamaah;
        return $this->success('Update successful',$user);
    }

    public function changePassword(Request $request){
        $validator = $this->customValidation($request, [
            'old_password' =>  'required|string',
            'new_password' => 'required|string',
            'new_password_confirmation' => 'required|string|same:new_password',
        ]);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user       = User::find(Auth::id());       
        if($user){
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = $request->new_password;
                $user->save();
                return $this->success('Kata sandi berhasil berhasil diperbarui.');
            } else {
                return $this->failure('Kata sandi lama tidak sesuai.');
            }
        }
        else{
            return $this->failure('User tidak ditemukan');
        }
    }

    public function changeUsername(Request $request){
        $validator = $this->customValidation($request, [
            'type'      =>  'required|string|in:phone,email',
            'username'  => 'required|string',
        ]);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user                   = User::find(Auth::id());
        $type                   = $request->type;
        $username               = $request->username;
        $confirmation_type_id   = 0;
        
        if($type == 'phone'){
            if($username == $user->phone){
                return $this->failure('Nomor hp sama');
            }
            if(User::where('phone',$username)->where('id','!=',$user->id)->count()>0){
                return $this->failure('Nomor hp sudah digunakan');
            }
            $confirmation_type_id   = 3;
        }else if($type == 'email'){
            if($username == $user->username){
                return $this->failure('Email sama');
            }
            if(User::where('email',$username)->where('id','!=',$user->id)->count()>0){
                return $this->failure('Email sudah digunakan');
            }
            $confirmation_type_id   = 4;
        }else{
            return $this->failure('username tidak ditemukan');
        }
        $digit_code     = 5;
        ConfirmationUser::where('user_id',$user->id)->where('confirmation_type_id',$confirmation_type_id)->delete();
        $code   = str_pad(rand(0, pow(10, $digit_code)-1), $digit_code, '0', STR_PAD_LEFT);
        while (ConfirmationUser::where('code',$code)->count()>0) {
            $code   = str_pad(rand(0, pow(10, $digit_code)-1), $digit_code, '0', STR_PAD_LEFT);
        }
        $expired_at                                 = Carbon::now()->addHour()->toDateTimeString();
        $kodeKonfirmasiUser                         = new ConfirmationUser();
        $kodeKonfirmasiUser->code                   = $code;
        $kodeKonfirmasiUser->user_id                = $user->id;
        $kodeKonfirmasiUser->expired_at             = $expired_at;
        $kodeKonfirmasiUser->confirmation_type_id   = $confirmation_type_id;
        $kodeKonfirmasiUser->save();
        if($type == 'phone'){
            // $user->notify($kodeOtpAktivasiAkun);
            if($username[0] == '0') $username = '+62'.substr($username, 1);
            $connection     = new ChuangLanSMSConnection();
            $connection->setMessage($username, 'your verification code is '.$code);
            $result         = strtoupper(env('APP_ENV')) !== 'STANDALONE_TESTING' ? $connection->send() : ['result' => 'hold due to testing environment'];
            return $this->success('Kode verifikasi telah dikirim ke '.$username,$kodeKonfirmasiUser);
        }else if ($type == 'email'){
            $data = array('email'=>$username);
            $x = [
                'code'          => $code,
                'expired_at'    => $expired_at,
                'email'         => $username
            ];
            Mail::send([], $data, function($message) use ($x) {
                $message->to($x['email'], 'MyDuma')->subject('MyDuma - Verifikasi Perubahan Email')->setBody('Kode verifikasi anda adalah : <h2>'.$x['code'].'</h2> Verifikasi perubahan anda sebelum '.$x['expired_at'],'text/html');
            });
            return $this->success('Kode verifikasi telah dikirim ke '.$username,$kodeKonfirmasiUser);
        }
        return $this->failure('username tidak ditemukan');
    }

    public function changeUsernameConfirmation(Request $request){
        $validator = $this->customValidation($request, [
            'type'          =>  'required|string|in:phone,email',
            'username'      => 'required|string',
            'code'          => 'required|string',
        ]);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user                   = User::find(Auth::id());
        $type                   = $request->type;
        $username               = $request->username;
        $confirmation_type_id   = 0;
        $code                   = $request->code;

        if($type == 'phone'){
            if($username == $user->phone){
                return $this->failure('Nomor hp sama');
            }
            if(User::where('phone',$username)->where('id','!=',$user->id)->count()>0){
                return $this->failure('Nomor hp sudah digunakan');
            }
            $confirmation_type_id   = 3;
        }else if($type == 'email'){
            if($username == $user->username){
                return $this->failure('Email sama');
            }
            if(User::where('email',$username)->where('id','!=',$user->id)->count()>0){
                return $this->failure('Email sudah digunakan');
            }
            $confirmation_type_id   = 4;
        }

        $kodeKonfirmasiUser         = ConfirmationUser::where('code', $code)->where('user_id',$user->id)->where('confirmation_type_id',$confirmation_type_id)->first();
        if (!$kodeKonfirmasiUser) {
            return $this->failure('Kode verifikasi salah.');
        }
        if ($kodeKonfirmasiUser->expired_at < Carbon::now()->toDateTimeString()) {
            ConfirmationUser::where('code',$code)->delete();
            return $this->failure('Kode verifikasi expired.');
        }
        ConfirmationUser::where('user_id',$user->id)->where('confirmation_type_id',$confirmation_type_id)->delete();
        if($type == 'phone'){
            $user->phone                = $username;
            $user->phone_verified_at    = Carbon::now();
            $user->save();
            return $this->success('Nomor hp anda berhasil diubah');
        }else if($type == 'email'){
            $user->email                = $username;
            $user->email_verified_at    = Carbon::now();
            $user->save();
            return $this->success('Email anda berhasil diubah');
        }
        return $this->failure('Gagal');
    }

    public function sendEmail(Request $request){
        $validator = $this->customValidation($request, [
            'email'         =>  'required|email',
        ]);
        if ($validator !== TRUE) {
            return $validator;
        }
        

        if($request->tipe != null && $request->tipe == 'setoran_awal'){
            $notifEmail                   =  new stdClass;
            $notifEmail->view             = 'setoran_awal';
            $notifEmail->nama_nasabah     = $request->name;
            $notifEmail->receiver_email   = $request->email;
            $notifEmail->content          = 'Verifikasi Pembayaran Setoran Awal MyDuma Sukses';
            $notifEmail->subject          = 'Verifikasi Pembayaran Setoran Awal MyDuma Sukses';
            $notifEmail->sender_email     = 'noreply@myduma.id';
            $notifEmail->sender_name      = 'noreply MyDuma';
            $sendEmail                    = $this->email_helper->sendMail('setoran_awal',$notifEmail);
            return $sendEmail;
        }else{
            $data = array('email'=>$request->email);
            $x = [
                'email'         => $request->email
            ];
            return Mail::send([], $data, function($message) use ($x) {
                $message->to($x['email'], 'MyDuma')->subject('MyDuma - Say Hello')->setBody('Ignore this email. Its just a test.','text/html');
            });
        }
        
    }

    public function sendSms(Request $request){
        $validator = $this->customValidation($request, [
            // 'user_id'         =>  'required|integer|exists:users,phone',
            'phone'             =>  'required|string',
            'message'           =>  'required|string',
        ]);
        if ($validator !== TRUE) {
            return $validator;
        }
        $connection     = new ChuangLanSMSConnection();
        $connection->setMessage($request->phone, $request->message);
        $result         = strtoupper(env('APP_ENV')) !== 'STANDALONE_TESTING' ? $connection->send() : ['result' => 'hold due to testing environment'];
        return $result;
    }

    public function activityRecords(Request $request){
        $datas      = ActivityRecord::whereNotNull('id');
        $groupby    = 'device_info';
        $limit      = 100;
        if($request->limit){
            $limit  = $request->limit;
        }
        if($request->where_column){
            $datas  = $datas->where($request->where_column,$request->where_value);
        }else{
            $datas  = $datas->select(DB::raw('MAX(user_id) user_id'),DB::raw('MAX(created_at) created_at'),DB::raw('count(*) as total'),'id','activity', 'from_ip', 'device_info', 'app_version')->groupBy($groupby);
        }
        $datas      = $datas->orderBy('created_at','desc')->take($limit)->get();
        $datas->load(['user.file']);
        if (!$request->where_column){
            foreach ($datas as $data){
                $row                    = ActivityRecord::where($groupby,$data->device_info)->where('created_at', $data->created_at)->orderBy('id','desc')->first();
                if($row!=null){
                    $data->id           = $row->id;
                    $data->activity     = $row->activity;
                    $data->from_ip      = $row->from_ip;
                    $data->app_version  = $row->app_version;
                }
                
            }
        }
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }
}
