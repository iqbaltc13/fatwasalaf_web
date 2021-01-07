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
use App\Http\Controllers\Helpers\EmailHelperController;
use stdClass;
use DateTime;
use DateInterval;


class PembayaranController extends Controller{

   
    public function __construct(){
        $this->email_helper   = new EmailHelperController();
    }


    public function uploadBuktiTransfer(Request $request){
        $rules = [
            'nasabah_id'            => 'required|integer|exists:nasabahs,id',
            'file_id'               => 'required|integer|exists:files,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $nasabah                    = Nasabah::find($request->nasabah_id);
        $user                       = User::find(Auth::id());
        $nominal_seharusnya         = 0;
        $deskripsi                  = '-';
        $nama_layanan               = "";
        $jenis_pembayaran           = JenisPembayaran::find(1);
        if($nasabah->user_id != $user->id){
            return $this->failure('anda bukan user['.$user->id.'] nasabah['.$nasabah->id.']');
        }
        $pembayaran_type                    = '';
        $pembayaran_id                      = null;
        if($nasabah->jenis_layanan_id == 1){
            $tabunganHaji                   = TabunganHaji::where('nasabah_id',$nasabah->id)->first();
            if(!$tabunganHaji){
                return $this->failure('Tabungan haji tidak ditemukan ['.$nasabah->id.'].');
            }
            $nominal_seharusnya             = $tabunganHaji->biaya_administrasi;
            $pembayaran_type                = get_class($tabunganHaji);
            if($tabunganHaji->paket_tabungan_haji){
                $deskripsi                  = $tabunganHaji->paket_tabungan_haji->nama;
            }
            $nama_layanan                   = "Haji";
            $pembayaran_id                  = $tabunganHaji->id;
        }else if($nasabah->jenis_layanan_id == 2){
            $tabunganUmrah                  = TabunganUmrah::where('nasabah_id',$nasabah->id)->first();
            if(!$tabunganUmrah){
                return $this->failure('Tabungan umrah tidak ditemukan ['.$nasabah->id.'].');
            }
            $nominal_seharusnya             = $tabunganUmrah->biaya_administrasi;
            $pembayaran_type                = get_class($tabunganUmrah);
            if($tabunganUmrah->paket_tabungan_umrah){
                $deskripsi                  = $tabunganUmrah->paket_tabungan_umrah->nama;
            }
            $nama_layanan                   = "Umrah";
            $pembayaran_id                  = $tabunganUmrah->id;
        }else{
            return $this->failure('jenis layanan belum diakomodasi');
        }
        if(Pembayaran::whereNull('verified_at')->where('jenis_pembayaran_id',1)->where('nasabah_id',$nasabah->id)->count() > 0){
            Pembayaran::whereNull('verified_at')->where('nasabah_id',$nasabah->id)->delete();
        }
        if(Pembayaran::where('nasabah_id',$nasabah->id)->where('jenis_pembayaran_id',1)->whereNotNull('verified_at')->count()>0){
            return $this->failure('Setoran awal sudah diverifikasi');
        }
        
        DB::beginTransaction();
        $user                               = User::find(Auth::id());
        $new_data                           = new Pembayaran();
        $new_data->deskripsi                = $jenis_pembayaran->display_name." ".$nama_layanan." | Paket ".$deskripsi;
        $new_data->nasabah_id               = $nasabah->id;
        $new_data->jenis_pembayaran_id      = 1;
        $new_data->jenis_layanan_id         = $nasabah->jenis_layanan_id;
        $new_data->pembayaran_type          = $pembayaran_type;
        $new_data->pembayaran_id            = $pembayaran_id;
        $new_data->file_id                  = $request->file_id;
        $new_data->catatan_customer         = $request->catatan_customer;
        $new_data->nominal_seharusnya       = $nominal_seharusnya;
        $new_data->save();
        $new_data->refresh();
        DB::commit();
        return $this->success('Berhasil',$new_data);
    }

    public function verify(Request $request){
        $rules = [
            'id'                => 'required|integer|exists:pembayarans,id',
            'verified_result'   => 'required|string|in:accepted,rejected',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $role_ids                   = DB::table('role_user')->where('user_id',$user->id)->pluck('role_id');
        $available_role             = Role::whereIn('id',$role_ids)->whereIn('name',['admin','admin-pembayaran','admin-all'])->count();
        if($available_role==0){
            return $this->failure('Anda bukan admin');
        }
        $data                               = Pembayaran::find($request->id);
        if($data->jenis_pembayaran_id != 1){
            return $this->failure('Bukan setoran awal');
        }
        if($data->verified_result!=null){
            if(!($data->verified_result == 'rejected' && $request->verified_result == 'accepted')){
                return $this->failure('Pembayaran ini sudah '.$data->verified_result.' oleh '.$data->verified_by_name);
            }
        }
        $data->verified_by_id               = $user->id;
        $data->verified_by_name             = $user->name;
        $data->verified_at                  = Carbon::now();
        $data->verified_result              = $request->verified_result;
        $data->catatan_verifikator          = $request->catatan_verifikator;
        $nasabah                            = Nasabah::find($data->nasabah_id);
        $customer                           = User::find($nasabah->user_id);
        $title                              = "";
        $subtitle                           = "";
        $layanan                            = "";
        $action                             = "main";
        if($data->jenis_layanan_id == 1){
            $layanan                        = "Haji";
            $action                         = "detail_riwayat_tabungan_haji";
        }else if($data->jenis_layanan_id == 2){
            $layanan                        = "Umrah";
            $action                         = "detail_riwayat_tabungan_umrah";
        }
        if($request->verified_result == 'accepted'){
            $data->nominal                  = $data->nominal_seharusnya;
            $duma_point                     = new DumaPoint();
            $duma_point->in                 = $data->nominal_seharusnya;
            $duma_point->user_id            = $customer->id;
            $duma_point->save();
            $data->duma_point_id            = $duma_point->id;

            if($data->jenis_layanan_id == 1){
                $tabunganHaji                               = TabunganHaji::find($data->pembayaran_id);
                if($tabunganHaji){
                    $tabunganHaji->status_tabungan_haji_id      = 2;
                    $tabunganHaji->save();
                }
                
            }else if($data->jenis_layanan_id == 2){
                $tabunganUmrah                              = TabunganUmrah::find($data->pembayaran_id);
                if($tabunganUmrah){
                    $tabunganUmrah->status_tabungan_umrah_id    = 2;
                    $tabunganUmrah->save();
                }
                
            }

            $createva                           = VirtualAccount::createVA($nasabah->nama);
            if($createva['status'] != 0){
                return $this->failure('Gagal Create VA - ('.$createva['va_no'].') '.$createva['msg'].'['.$createva['status'].']');
            }
            $va_no                              = $createva['va_no'];
            if(!$va_no){
                return $this->failure('nomor va gagal digenerate');
            }
            $nasabah->nomor_va                  = $va_no;
            $nasabah->save();
            $title                              = "Saldo awal ".$data->nominal_seharusnya." ditambahkan";
            $subtitle                           = "Ayo mulai menabung ".$layanan." di MyDuma";
        }else{
            $title                              = "Pembayaran Anda Ditolak";
            $subtitle                           = "Admin menolak pembayaran anda karena ".$request->catatan_verifikator;
        }
        $data->save();
        $new_data                           = Pembayaran::find($request->id);

        //Kirim Notifikasi
        $penerima                           = User::find($nasabah->user_id);
        if($penerima){
            $new_notifikasi                 = new Notifikasi();
            $new_notifikasi->sender_id      = Auth::id();
            $new_notifikasi->receiver_id    = $penerima->id;
            $new_notifikasi->title          = $title;
            $new_notifikasi->subtitle       = $subtitle;
            $new_notifikasi->action         = $action;
            $new_notifikasi->value          = $new_data->pembayaran_id;
            $new_notifikasi->save();
            $penerima->notify(new FirebasePushNotif($new_notifikasi->title, $new_notifikasi->subtitle, $new_notifikasi->action, $new_notifikasi->value));
            //Kirim Email
            $notifEmail                   =  new stdClass;
            $notifEmail->view             = 'setoran_awal';
            $notifEmail->nama_nasabah     = $penerima->name;
            $notifEmail->receiver_email   = $penerima->email;
            $notifEmail->content          = 'Verifikasi Pembayaran Setoran Awal MyDuma Sukses';
            $notifEmail->subject          = 'Verifikasi Pembayaran Setoran Awal MyDuma Sukses';
            $notifEmail->sender_email     = 'noreply@myduma.id';
            $notifEmail->sender_name      = 'noreply MyDuma';
            $sendEmail                    = $this->email_helper->sendBeautyMail('setoran_awal',$notifEmail);

        }
        
        DB::commit();
        return $this->success('Berhasil diverifikasi.', $new_data);
    }

    public function inputTabungan(Request $request){
        $dateTime = new DateTime();
        $rules = [
            'nomor_va'                => 'required|string|exists:nasabahs,nomor_va',
            'nominal'                 => 'required|integer|'
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $role_ids                   = DB::table('role_user')->where('user_id',$user->id)->pluck('role_id');
        $available_role             = Role::whereIn('id',$role_ids)->whereIn('name',['admin','admin-pembayaran','admin-all'])->count();
        if($available_role==0){
            return $this->failure('Anda bukan admin');
        }
        $nasabah                    = Nasabah::where('nomor_va',$request->nomor_va)->first();
        $nama_layanan               = "-";
        if($nasabah->jenis_layanan_id == 1){
            $tabungan       = TabunganHaji::where('nasabah_id',$nasabah->id)->first();
            if($tabungan->status_tabungan_haji_id == 1){
                return $this->failure('Setoran awal belum diselesaikan');
            }
            $nama_layanan   = "Haji";
        }else if($nasabah->jenis_layanan_id == 2){
            $tabungan = TabunganUmrah::where('nasabah_id',$nasabah->id)->first();
            if($tabungan->status_tabungan_umrah_id == 1){
                return $this->failure('Setoran awal belum diselesaikan');
            }
            $nama_layanan   = "Umrah";
        }
        if(!$tabungan){
            return $this->failure('Nasabah tidak memiliki tabungan.');
        }

        $pembayaran_type                    = get_class($tabungan);
        DB::beginTransaction();
        $duma_cash                          = new DumaCash();
        $duma_cash->in                      = $request->nominal;
        $duma_cash->nasabah_id              = $nasabah->id;
        $duma_cash->description             = 'diinput oleh '.$user->name.', sebesar '.$request->nominal;
        $duma_cash->save();

        $jenis_pembayaran                   = JenisPembayaran::find(2);
        $new_data                           = new Pembayaran();
        $new_data->nasabah_id               = $nasabah->id;
        $new_data->deskripsi                = $jenis_pembayaran->display_name." ".$nama_layanan;
        $new_data->jenis_pembayaran_id      = 2;
        $new_data->jenis_layanan_id         = $nasabah->jenis_layanan_id;
        $new_data->pembayaran_type          = $pembayaran_type;
        $new_data->pembayaran_id            = $tabungan->id;
        $new_data->nominal                  = $request->nominal;
        $new_data->nominal_seharusnya       = $request->nominal;
        $new_data->verified_at              = Carbon::now();
        $new_data->verified_by_id           = $user->id;
        $new_data->verified_by_name         = $user->name;
        $new_data->verified_result          = 'accepted';
        $new_data->catatan_verifikator      = $request->catatan_verifikator;
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
            $new_notifikasi->title          = "Saldomu bertambah ".$request->nominal;
            $new_notifikasi->subtitle       = "Tabunganmu sejumlah ".$request->nominal." sudah tersimpan di MyDuma";
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

            $notifEmail                         =  new stdClass;
            $notifEmail->view                   = 'add_saldo';
            $notifEmail->nama_nasabah           = $penerima->name;
            $notifEmail->nominal_baku_transaksi = $request->nominal ? 'Rp '.$request->nominal.',00 -' : '';
            $notifEmail->tanggal_transaksi      = $dateTime->format('d-m-Y');
            $notifEmail->receiver_email         = $penerima->email;
            $notifEmail->content                = 'Penambahan Saldo MyDuma Sukses';
            $notifEmail->subject                = 'Penambahan Saldo MyDuma Sukses';
            $notifEmail->sender_email           = 'noreply@myduma.id';
            $notifEmail->sender_name            = 'noreply MyDuma';
            $sendEmail                          = $this->email_helper->sendBeautyMail('add_saldo',$notifEmail);
        }
        
        return $this->success('Berhasil diverifikasi.', $new_data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:pembayarans,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data       = Pembayaran::find($request->id);
        $nasabah    = Nasabah::find($data->nasabah_id);
        if($nasabah->user_id != Auth::id()){
            return $this->failure('Anda tidak dapat menghapus pembayaran ini');
        }
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:pembayarans,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = Pembayaran::find($request->id);
        $data->load(['jenis_layanan','file']);
        $nasabah_full   = Nasabah::find($data->nasabah_id);
        $nasabah_full->load(['user','foto_ktp','foto_ktp_selfie','provinsi','kecamatan','kelurahan','kota','jenis_layanan']);
        $data->nasabah  = $nasabah_full;
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $rules = [
            'status_verifikasi'   => 'required|integer|in:3,2,1,0',
        ];
        $user           = User::find(Auth::id());
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        if($request->status_verifikasi == 3){
            $datas      = Pembayaran::whereNotNull('id');
        }else if($request->status_verifikasi == 2){
            $datas      = Pembayaran::whereNull('verified_result');
        }else if($request->status_verifikasi == 1){
            $datas      = Pembayaran::where('verified_result','accepted');
        }else if($request->status_verifikasi == 0){
            $datas      = Pembayaran::where('verified_result','rejected');
        }
        if($request->jenis_pembayaran_id && $request->jenis_pembayaran_id != 0){
            $datas      = $datas->where('jenis_pembayaran_id',$request->jenis_pembayaran_id);
        }
        if($request->jenis_layanan_id && $request->jenis_layanan_id != 0){
            $datas      = $datas->where('jenis_layanan_id',$request->jenis_layanan_id);
        }
        $datas          = $datas->orderBy('created_at','desc')->get();
        $datas->load(['nasabah.user','nasabah.foto_ktp','nasabah.foto_ktp_selfie','jenis_layanan','file','jenis_pembayaran']);

        if(isset($request->with_total) && $request->with_total == 1){
            $total          = 0;
            foreach($datas as $data){
                $total      += $data->nominal_seharusnya;
            }
            $result         = [
                'pembayarans'   => $datas,
                'total'         => $total,
            ];
            return $this->success('Berhasil', $result);
        }else{
            return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
        }
        
    }

    public function infoTotal(Request $request){
        $rules = [
            'jenis_layanan_id'   => 'required|integer|exists:jenis_layanans,id',
            'jenis_pembayaran_id'   => 'required|integer|exists:jenis_pembayarans,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $result         = [
            [
                'status_verifikasi_id'  => 3,
                'status_verifikasi_nama'=> 'Semua',
                'total'                 => Pembayaran::where('jenis_layanan_id',$request->jenis_layanan_id)->where('jenis_pembayaran_id',$request->jenis_pembayaran_id)->count(),
            ],
            [
                'status_verifikasi_id'  => 2,
                'status_verifikasi_nama'=> 'Belum Diverifikasi',
                'total'                 => Pembayaran::whereNull('verified_result')->where('jenis_layanan_id',$request->jenis_layanan_id)->where('jenis_pembayaran_id',$request->jenis_pembayaran_id)->count(),
            ],
            [
                'status_verifikasi_id'  => 1,
                'status_verifikasi_nama'=> 'Disetujui',
                'total'                 => Pembayaran::where('verified_result','accepted')->where('jenis_layanan_id',$request->jenis_layanan_id)->where('jenis_pembayaran_id',$request->jenis_pembayaran_id)->count(),
            ],
            [
                'status_verifikasi_id'  => 0,
                'status_verifikasi_nama'=> 'Ditolak',
                'total'                 => Pembayaran::where('verified_result','rejected')->where('jenis_layanan_id',$request->jenis_layanan_id)->where('jenis_pembayaran_id',$request->jenis_pembayaran_id)->count(),
            ],
        ];
        return $this->success('Berhasil', $result);
    }

    public function infoTotalAll(Request $request){
        $rules = [
            'tipe'                  => 'required|string|in:status_verifikasi,jenis_pembayaran,jenis_layanan',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $tipe           = $request->tipe;
        $results        = [];
        if($tipe == "status_verifikasi"){
            if(!isset($request->jenis_layanan_id)){
                return $this->failure('jenis layanan id tidak ditemukan');
            }
            if(!isset($request->jenis_pembayaran_id)){
                return $this->failure('jenis pembayaran id tidak ditemukan');
            }
            //Semua
            $status_verifikasis     = [
                [
                    'id'                    => 3,
                    'display_name'          => 'Semua',
                ],
                [
                    'id'                    => 2,
                    'display_name'          => 'Belum Diverifikasi',
                ],
                [
                    'id'                    => 1,
                    'display_name'          => 'Disetujui',
                ],
                [
                    'id'                    => 0,
                    'display_name'          => 'Ditolak',
                ],
            ];
            foreach($status_verifikasis as $status_verifikasi){
                $total  = Pembayaran::whereNotNull('id');
                if($request->jenis_layanan_id != 0){
                    $total  = $total->where('jenis_layanan_id',$request->jenis_layanan_id);
                }
                if($request->jenis_pembayaran_id != 0){
                    $total  = $total->where('jenis_pembayaran_id',$request->jenis_pembayaran_id);
                }
                if($status_verifikasi['id'] == 2){
                    $total  = $total->whereNull('verified_result');
                }else if($status_verifikasi['id'] == 1){
                    $total  = $total->where('verified_result','accepted');
                }else if($status_verifikasi['id'] == 0){
                    $total  = $total->where('verified_result','rejected');
                }
                $total  = $total->count();
                $data   = [
                    'id'            => $status_verifikasi['id'],
                    'display_name'  =>$status_verifikasi['display_name'],
                    'total'         => $total,
                ];
                array_push($results,$data);
            }
        }else if($tipe == 'jenis_pembayaran'){
            if(!isset($request->jenis_layanan_id)){
                return $this->failure('jenis layanan id tidak ditemukan');
            }
            if(!isset($request->status_verifikasi_id)){
                return $this->failure('status verifikasi id tidak ditemukan');
            }
            array_push($results,[
                'id'                => 0,
                'display_name'      => "Semua",
                'total'             => 0,
            ]);
            $jenis_pembayarans              = JenisPembayaran::all();
            $total_semua                    = 0;
            foreach($jenis_pembayarans as $jenis_pembayaran){
                $total  = Pembayaran::whereNotNull('id');
                if($request->jenis_layanan_id != 0){
                    $total  = $total->where('jenis_layanan_id',$request->jenis_layanan_id);
                }
                if($request->status_verifikasi_id == 2){
                    $total  = $total->whereNull('verified_result');
                }else if($request->status_verifikasi_id == 1){
                    $total  = $total->where('verified_result','accepted');
                }else if($request->status_verifikasi_id == 0){
                    $total  = $total->whereNull('verified_result','rejected');
                }
                $total  = $total->where('jenis_pembayaran_id',$jenis_pembayaran->id)->count();
                $data   = [
                    'id'            => $jenis_pembayaran->id,
                    'display_name'  => $jenis_pembayaran->display_name,
                    'total'         => $total,
                ];
                array_push($results,$data);
                $total_semua        += $total;
            }
            $results[0]['total']    = $total_semua;
        }else if($tipe == 'jenis_layanan'){
            if(!isset($request->jenis_pembayaran_id)){
                return $this->failure('jenis pembayaran id tidak ditemukan');
            }
            if(!isset($request->status_verifikasi_id)){
                return $this->failure('status verifikasi id tidak ditemukan');
            }

            array_push($results,[
                'id'                => 0,
                'display_name'      => "Semua",
                'total'             => 0,
            ]);
            $jenis_layanans             = JenisLayanan::all();
            $total_semua                = 0;
            foreach($jenis_layanans as $jenis_layanan){
                $total  = Pembayaran::whereNotNull('id');
                if($request->jenis_pembayaran_id != 0){
                    $total  = $total->where('jenis_pembayaran_id',$request->jenis_pembayaran_id);
                }
                if($request->status_verifikasi_id == 2){
                    $total  = $total->whereNull('verified_result');
                }else if($request->status_verifikasi_id == 1){
                    $total  = $total->where('verified_result','accepted');
                }else if($request->status_verifikasi_id == 0){
                    $total  = $total->where('verified_result','rejected');
                }
                $total  = $total->where('jenis_layanan_id',$jenis_layanan->id)->count();
                $data   = [
                    'id'            => $jenis_layanan->id,
                    'display_name'  => $jenis_layanan->display_name,
                    'total'         => $total,
                ];
                array_push($results,$data);
                $total_semua        += $total;
            }
            $results[0]['total']    = $total_semua;
        }
        return $this->success(@count($results).' berhasil ditampilkan.', $results);
    }

    public function loginBms(Request $request){
        $settingBms         = VirtualAccount::getToken();
        return $this->success('Berhasil',$settingBms);
    }
}
