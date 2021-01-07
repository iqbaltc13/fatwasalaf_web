<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Nasabah;
use Carbon\Carbon;
use App\Models\SettingBms;
use Config;
use App\User;

class VirtualAccount {
    public static function getUrl(){
        return 'http://182.23.49.46:8099';
    }

    public static function generateMyDumaNumberId() {
        $finding        = true;
        $number         = "";
        while ($finding) {
            $randomSuffix   = rand(0,99999999);
            $number         = str_pad($randomSuffix, 8, '0', STR_PAD_LEFT);
            if(User::where('number_id', $number)->count() == 0){
                $finding = false;
                break;
            }
        }
        return $number;
    }

    public static function generateNumber($nama) {
    	$prefix 		= '904601';
    	// $prefix 		= '';
    	$finding 		= true;
    	$number 		= "";
        while ($finding) {
            $randomSuffix 	= rand(0,9999999);
            $number 		= $prefix.str_pad($randomSuffix, 7, '0', STR_PAD_LEFT);
            if(Nasabah::where('nomor_va', $number)->count() == 0){
            	$finding = false;
                break;
            }
        }
        return $number;
    }

    public static function getToken() {
        try{
            $client     = new \GuzzleHttp\Client();
            $response = $client->post(VirtualAccount::getUrl().'/token/generate-token', [
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

    public static function createVA($nama) {
        $uniqueNumber       = VirtualAccount::generateNumber($nama);
        $result = [
            'va_no'     => $uniqueNumber,
            'status'    => 0,
            'msg'       => 'Berhasil'
        ];
        return $result;
        $va_mode            = config('values.va_mode');
        $uniqueNumber       = null;
        if($va_mode == 'dev'){
            $uniqueNumber       = VirtualAccount::generateNumber($nama);
            $result = [
                'va_no'     => $uniqueNumber,
                'status'    => 0,
                'msg'       => 'Berhasil'
            ];
            return $result;
        }
        $response_code      = 97;
        while($response_code == 97){
            $uniqueNumber       = VirtualAccount::generateNumber($nama);
            $settingBms         = SettingBms::first();
            if(!$settingBms){
                VirtualAccount::getToken();
                $settingBms         = SettingBms::first();
            }
            try{
                $response = VirtualAccount::callCreateVa($settingBms->id_perusahaan,$uniqueNumber,$nama,$settingBms->token);
            }catch(\GuzzleHttp\Exception\ClientException $e){
                VirtualAccount::getToken();
                $settingBms         = SettingBms::first();
                $response           = VirtualAccount::callCreateVa($settingBms->id_perusahaan,$uniqueNumber,$nama,$settingBms->token);
            }
            $json           = json_decode($response);
            $response_code  = $json->status;
        }  
        try{
            $result = [
                'va_no'     => $json->va_no,
                'status'    => $json->status,
                'msg'       => "msg: ".$json->msg,
            ];
            return $result;
        }catch(ErrorException $e){
            return [
                'va_no'     => $uniqueNumber,
                'msg'       => "error: ".$e." | json: ".$json,
                'status'    => $json->status,
            ];
        }
    }

    public static function callCreateVa($id_perusahaan,$uniqueNumber,$nama,$token){
        $client             = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$token]]);
        $response           = $client->post(VirtualAccount::getUrl().'/va', [
            \GuzzleHttp\RequestOptions::JSON => [
                'id_perusahaan' => $id_perusahaan,
                'jenis_va'      => '01',
                'id_nasabah_va' => $uniqueNumber,
                'nama_lengkap'  => $nama,
            ],
        ])->getBody();
        return $response;
    }
}