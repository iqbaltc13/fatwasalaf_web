<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Nasabah;
use App\Notifications\FirebasePushNotif;
use App\Models\Notifikasi;
use App\User;
use Auth;
use Carbon\Carbon;
use App\Models\TabunganHaji;
use App\Models\TabunganUmrah;
use App\Models\ActivityRecord;

class NotifNasabahBaru extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:nasabah_baru';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi ke nasabah baru yang belum membayar setoran awal 8 jam setelah mendaftar tabungan umrah/haji';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $save_notification              = 0;
        $title                          = "Tuntaskan niatmu";
        $subtitle                       = "Yuk selesaikan setoran awalmu untuk wujudkan ibadah ke tanah suci";
        $action                         = "dashboard";
        $value                          = "0";

        $time_start                     = Carbon::now()->addHours(-8)->toDateTimeString();
        $time_end                       = Carbon::now()->addHours(-7)->toDateTimeString();
        $tabungan_haji_nasabah_ids      = TabunganHaji::where('status_tabungan_haji_id',1)->pluck('nasabah_id')->toArray();
        $tabungan_umrah_nasabah_ids     = TabunganUmrah::where('status_tabungan_umrah_id',1)->pluck('nasabah_id')->toArray();
        $nasabah_ids                    = $tabungan_haji_nasabah_ids + $tabungan_umrah_nasabah_ids;
        
        $nasabah_user_ids               = Nasabah::whereBetween('created_at',[$time_start,$time_end])->whereIn('id',$nasabah_ids)->pluck('user_id');
        echo "time_start: ".$time_start." | time_end: ".$time_end." | total nasabah: ".@count($nasabah_user_ids)."| nasabah_ids: ".json_encode($nasabah_ids);
        $users                          = User::whereIn('id',$nasabah_user_ids)->get();
        $activity_record                = new ActivityRecord();
        $activity_record->activity      = "notif:nasabah_baru ke ".@count($users)." user di rentang [".$time_start." , ".$time_end."]";
        $activity_record->from_ip       = "localhost";
        $activity_record->device_info   = "Server Prod";
        $activity_record->save();
        foreach($users as $user){
            $penerima                           = User::find($user->id);
            if($save_notification == 1){
                $new_notifikasi                 = new Notifikasi();
                $new_notifikasi->sender_id      = Auth::id();
                $new_notifikasi->receiver_id    = $user->id;
                $new_notifikasi->title          = $title;
                $new_notifikasi->subtitle       = $subtitle;
                $new_notifikasi->action         = $action;
                $new_notifikasi->value          = $value;
                $new_notifikasi->save();
            }else{
                $new_notifikasi                 = null;
            }
            $penerima->notify(new FirebasePushNotif($title, $subtitle, $action, $value));
        }
    }
}
