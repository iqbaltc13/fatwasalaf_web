<?php
namespace App\Traits;

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
use App\Models\JenisPembayaran;
use App\Models\JenisLayanan;
use App\Notifications\FirebasePushNotif;
use App\Models\Notifikasi;
use App\User;

trait PembayaranTrait{
    public function newPembayaranTabungan($nomor_va, $nominal, $admin_name, $admin_id, $catatan_verifikator){
        $nasabah                    = Nasabah::where('nomor_va',$nomor_va)->first();
        if($nasabah == null){
            return [
                "code"      => 404,
                "message"   => "Nomor VA tidak terdaftar",
            ];
        }
        $nama_layanan               = "-";
        if($nasabah->jenis_layanan_id == 1){
            $tabungan       = TabunganHaji::where('nasabah_id',$nasabah->id)->first();
            if($tabungan->status_tabungan_haji_id == 1){
                return [
                    "code"      => 301,
                    "message"   => "Setoran awal belum diselesaikan",
                ];
            }
            $nama_layanan   = "Haji";
        }else if($nasabah->jenis_layanan_id == 2){
            $tabungan = TabunganUmrah::where('nasabah_id',$nasabah->id)->first();
            if($tabungan->status_tabungan_umrah_id == 1){
                return [
                    "code"      => 301,
                    "message"   => "Setoran awal belum diselesaikan",
                ];
            }
            $nama_layanan   = "Umrah";
        }
        if(!$tabungan){
            return [
                "code"      => 302,
                "message"   => "Nasabah tidak memiliki tabungan.",
            ];
        }

        $pembayaran_type                    = get_class($tabungan);
        DB::beginTransaction();
        $duma_cash                          = new DumaCash();
        $duma_cash->in                      = $nominal;
        $duma_cash->nasabah_id              = $nasabah->id;
        $duma_cash->description             = 'diinput oleh '.$admin_name.', sebesar '.$nominal;
        $duma_cash->save();

        $jenis_pembayaran                   = JenisPembayaran::find(2);
        $new_data                           = new Pembayaran();
        $new_data->nasabah_id               = $nasabah->id;
        $new_data->deskripsi                = $jenis_pembayaran->display_name." ".$nama_layanan;
        $new_data->jenis_pembayaran_id      = 2;
        $new_data->jenis_layanan_id         = $nasabah->jenis_layanan_id;
        $new_data->pembayaran_type          = $pembayaran_type;
        $new_data->pembayaran_id            = $tabungan->id;
        $new_data->nominal                  = $nominal;
        $new_data->nominal_seharusnya       = $nominal;
        $new_data->verified_at              = Carbon::now();
        $new_data->verified_by_id           = $admin_id;
        $new_data->verified_by_name         = $admin_id;
        $new_data->verified_result          = 'accepted';
        $new_data->catatan_verifikator      = $catatan_verifikator;
        $new_data->duma_cash_id             = $duma_cash->id;
        $new_data->save();

        if($nasabah->jenis_layanan_id == 1){
            if($tabungan->status_tabungan_haji_id == 2){
                $tabungan->status_tabungan_haji_id  = 3;
                $tabungan->save();
            }
        }else if($nasabah->jenis_layanan_id == 2){
            if($tabungan->status_tabungan_umrah_id == 2){
                $tabungan->status_tabungan_umrah_id = 3;
                $tabungan->save();
            }
        }
        DB::commit();
        //Kirim Notifikasi
        $penerima                           = User::find($nasabah->user_id);
        if($penerima){
            $new_notifikasi                 = new Notifikasi();
            $new_notifikasi->sender_id      = Auth::id();
            $new_notifikasi->receiver_id    = $penerima->id;
            $new_notifikasi->title          = "Saldomu bertambah ".$nominal;
            $new_notifikasi->subtitle       = "Tabunganmu sejumlah ".$nominal." sudah tersimpan di MyDuma";
            if($new_data->jenis_layanan_id == 1){
                $new_notifikasi->action     = 'detail_riwayat_tabungan_haji';
            }else if($new_data->jenis_layanan_id == 2){
                $new_notifikasi->action     = 'detail_riwayat_tabungan_umrah';
            }else{
                $new_notifikasi->action     = 'main';
            }
            $new_notifikasi->value          = $tabungan->id;
            $new_notifikasi->save();
            $penerima->notify(new FirebasePushNotif($new_notifikasi->title, $new_notifikasi->subtitle, $new_notifikasi->action, $new_notifikasi->value));
        }
        return [
            "code"      => 200,
            "message"   => "Berhasil.",
        ];
    }
}