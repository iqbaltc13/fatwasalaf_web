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
use App\Models\InquiryLog;
use App\Traits\PembayaranTrait;
use App\Models\PaymentCallbackLog;
use App\Models\TabunganHaji;
use App\Models\PaketTabunganHaji;

class BMSCallBackController extends Controller{
    use PembayaranTrait;
    public function inquiry(Request $request){
        $rules = [
            'nomor_va'                  => 'required|string',
            'kode_inst'                 => 'required|string',
            'waktu_proses'              => 'required|string',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $new_data                           = new InquiryLog();
        $new_data->provider                 = 'bms';
        $new_data->nomor_va                 = $request->nomor_va;
        $new_data->kode_bank                = $request->kode_inst;
        $new_data->waktu_proses             = $request->waktu_proses;
        $new_data->raw_input                = json_encode($request->all());
        $new_data->save();
        $nasabah                            = Nasabah::where('nomor_va',$request->nomor_va)->first();
        if($nasabah!=null){
            $nama_layanan                   = "Tabungan MyDuma";
            if($nasabah->jenis_layanan_id == 1){
                $tabungan                   = TabunganHaji::where('nasabah_id',$nasabah->id)->first();
                $nama_layanan               = "MyDuma - Tabungan Haji";
                if($tabungan){
                    $paket_tabungan         = PaketTabunganHaji::find($tabungan->paket_tabungan_haji_id);
                    if($paket_tabungan){
                        $nama_layanan       = "MyDuma - ".$paket_tabungan->nama;
                    }
                }
            }else if($nasabah->jenis_layanan_id == 2){
                $tabungan                   = TabunganUmrah::where('nasabah_id',$nasabah->id)->first();
                $nama_layanan               = "MyDuma - Tabungan Umrah";
                if($tabungan){
                    $paket_tabungan         = PaketTabunganUmrah::find($tabungan->paket_tabungan_umrah_id);
                    if($paket_tabungan){
                        $nama_layanan       = "MyDuma - ".$paket_tabungan->nama;
                    }
                }
            }
            $new_data->status_code      = 1;
            $new_data->status_string    = "success";
            $new_data->save();
            return [
                "respon_code"       => "00",
                "mess"              => "OK",
                "nomor_va"          => $request->nomor_va,
                "kode_inst"         => $request->kode_inst,
                "waktu_proses"      => $request->waktu_proses,
                "nama"              => $nasabah->nama,
                "info"              => $nama_layanan,
            ];
        }else{
            $new_data->status_code      = 0;
            $new_data->status_string    = "gagal. No Va/Channel/Institusi tidak di kenali";
            $new_data->save();
            return [
                "respon_code"       => "01",
                "mess"              => "No Va/Channel/Institusi tidak di kenali",
            ];
        }
    }

    public function payment(Request $request){
        $rules = [
            'nomor_va'                  => 'required|string',
            'kode_inst'                 => 'required|string',
            'nominal'                   => 'required|string',
            'admin'                     => 'required|string',
            'refnumber'                 => 'required|string',
            'waktu_proses'              => 'required|string',
            'channel_id'                => 'required|string',
            'hashing'                   => 'required|string', //md5(nomor_va+kode_inst+channel_id+refnumber+nominal+admin+waktu_proses)
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $new_data                           = new PaymentCallbackLog();
        $new_data->provider                 = 'bms';
        $new_data->nomor_va                 = $request->nomor_va;
        $new_data->kode_bank                = $request->kode_inst;
        $new_data->waktu_proses             = $request->waktu_proses;
        $new_data->nominal                  = $request->nominal;
        $new_data->admin                    = $request->admin;
        $new_data->raw_input                = json_encode($request->all());
        $new_data->save();
        // $result                             = $this->newPembayaranTabungan($request->nomor_va,$request->nominal,'BMS',null,'-');
        $nasabah                            = Nasabah::where('nomor_va',$request->nomor_va)->first();
        if($nasabah != null){
            $hashing_plain                  = $request->nomor_va.$request->kode_inst.$request->channel_id.$request->refnumber.$request->nominal.$request->admin.$request->waktu_proses;
            $hashing                        = md5($hashing_plain);
            // return [
            //     'plain'     => $hashing_plain,
            //     'md5'       => $hashing,
            // ];
            if($hashing == $request->hashing){
                $new_data->status_code      = 1;
                $new_data->status_string    = "success";
                $new_data->save();
                return [
                    "respon_code"       => "00",
                    "mess"              => "OK",
                    "nomor_va"          => $request->nomor_va,
                    "kode_inst"         => $request->kode_inst,
                    "waktu_proses"      => $request->waktu_proses,
                    "nominal"           => $request->nominal,
                    "admin"             => $request->admin,
                    "refnumber"         => $request->refnumber,
                    "channel_id"        => $request->channel_id,
                    "hashing"           => $hashing,
                ];
            }else{
                $new_data->status_code      = 0;
                $new_data->status_string    = "gagal. Kode Hashing tidak valid.";
                $new_data->save();
                return [
                    "respon_code"       => "03",
                    "mess"              => "Kode Hashing tidak valid",
                ];
            }
            
        }else{
            $new_data->status_code      = 0;
            $new_data->status_string    = "gagal. No Va/Channel/Institusi tidak di kenali.";
            $new_data->save();
            return [
                "respon_code"       => "01",
                "mess"              => "No Va/Channel/Institusi tidak di kenali",
            ];
        }
    }

    
}