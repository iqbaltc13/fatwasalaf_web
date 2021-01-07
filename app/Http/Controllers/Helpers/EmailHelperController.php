<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use stdClass;
use App\Models\LogEmailNotifications;
use Snowfire\Beautymail\Beautymail;


class EmailHelperController extends Controller
{
    public function sendMail($view,$dataParse){
        $data = [
            'dataParse'=>$dataParse,
        ];
        $mail = 1;
          
        try {
            $mail = Mail::send(['text'=>'mail.'.$dataParse->view], $data, function($message) use ($dataParse) {
                $message->to($dataParse->receiver_email, $dataParse->content)->subject($dataParse->subject);
                $message->from($dataParse->sender_email,$dataParse->sender_name);
            });
            
        }
        catch(Exception $e) {
      
        }
        $this->addToLogEmailNotifications($dataParse);
        return $mail;
    }
    public function sendBeautyMail($view,$dataParse){
        $data = [
            'dataParse'=>$dataParse,
        ];
        $mail = 1;
          
       
        //$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail = app(Beautymail::class);
        try {
            $beautymail->send('mail.'.$dataParse->view, $data, function($message) use ($dataParse)
            {
                $message->to($dataParse->receiver_email, $dataParse->content)->subject($dataParse->subject);
                $message->from($dataParse->sender_email,$dataParse->sender_name);
            });
        }
        catch(Exception $e) {
             
        }
       
       
        $this->addToLogEmailNotifications($dataParse);
        return $mail;
    }
    public function testMail(){
        $account = new stdClass;
        
        $account->view             = 'add_saldo';
        $account->nama_nasabah     = 'Andrew Marlisa';
        $account->receiver_email   = 'rifqimaulaiqbal@gmail.com';
        $account->content          = 'Akun Baru Sisprohaj Mobile';
        $account->subject          = 'Akun Baru Sisprohaj Mobile';
        $account->sender_email     = 'noreply@sisprohaj.id';
        $account->sender_name      = 'Admin Sisprohaj';
        // $this->sendMail('test_beautymail_sunny',$account);
        $this->sendMail('test_beautymail_ark',$account);
        $this->sendBeautyMail('test_beautymail_sunny',$account);
        // $this->sendMail('test_beautymail_widgets',$account);
    }

    public function testMailRegistrasi(){
        $notifEmail                   =  new stdClass;
        $notifEmail->view             = 'new_account';
        $notifEmail->nama_nasabah     = 'Andrew Marlisa';
        $notifEmail->receiver_email   = 'rifqibarcelonista@gmail.com';
        $notifEmail->content          = 'Registrasi Nasabah MyDuma Sukses';
        $notifEmail->subject          = 'Registrasi Nasabah MyDuma Sukses';
        $notifEmail->sender_email     = 'noreply@myduma.id';
        $notifEmail->sender_name      = 'noreply MyDuma';
        $sendEmail                    = $this->sendBeautyMail('new_account',$notifEmail);

    }
    public function testMailSetoranAwal(){
        $notifEmail                   =  new stdClass;
        $notifEmail->view             = 'setoran_awal';
        $notifEmail->nama_nasabah     = 'Andrew Marlisa';
        $notifEmail->receiver_email   = 'rifqibarcelonista@gmail.com';
        $notifEmail->content          = 'Verifikasi Pembayaran Setoran Awal MyDuma Sukses';
        $notifEmail->subject          = 'Verifikasi Pembayaran Setoran Awal MyDuma Sukses';
        $notifEmail->sender_email     = 'noreply@myduma.id';
        $notifEmail->sender_name      = 'noreply MyDuma';
        $sendEmail                    = $this->sendBeautyMail('setoran_awal',$notifEmail);

    }
    public function testMailAddSaldo(){
        $notifEmail                         =  new stdClass;
        $notifEmail->view                   = 'add_saldo';
        $notifEmail->nama_nasabah           = 'Andrew Marlisa';
        $notifEmail->nominal_baku_transaksi = 'Rp 5.000.000,00 -';
        $notifEmail->tanggal_transaksi      = '19-12-2020';
        $notifEmail->receiver_email         = 'rifqibarcelonista@gmail.com';
        $notifEmail->content                = 'Penambahan Saldo MyDuma Sukses';
        $notifEmail->subject                = 'Penambahan Saldo MyDuma Sukses';
        $notifEmail->sender_email           = 'noreply@myduma.id';
        $notifEmail->sender_name            = 'noreply MyDuma';
        $sendEmail                          = $this->sendBeautyMail('add_saldo',$notifEmail);
    }

    public function addToLogEmailNotifications($dataParse){
        $arrCreate = [
           
            'data'              => json_encode($dataParse),
            'receiver_email'    => $dataParse->receiver_email,
            'sender_email'      => $dataParse->sender_email,
            'subject'           => $dataParse->subject,
        ];
        $createLog = LogEmailNotifications::create($arrCreate);
        return $createLog;
    }

        
		

}
