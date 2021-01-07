<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Nasabah;
use App\Notifications\FirebasePushNotif;
use App\Models\Notifikasi;
use App\User;
use Auth;
use Carbon\Carbon;
use App\Models\ActivityRecord;

class NotifUpdateApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:updateapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi ke user yang belum update aplikasi';

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
    public function handle()
    {
        $save_notification              = 0;
        $title                          = "Ada yang baru loh";
        $subtitle                       = "Yuk update aplikasinya";
        $action                         = "play_store";
        $value                          = "0";

        $last_apk_version_code          = 41;
        $users                          = User::where('current_apk_version_code', '<',$last_apk_version_code)->whereNotNull('token_firebase')->get();
        $activity_record                = new ActivityRecord();
        $activity_record->activity      = "notif:nasabah_updateapp ke ".@count($users)." user";
        $activity_record->from_ip       = "localhost";
        $activity_record->device_info   = "Server Prod";
        $activity_record->save();
        foreach($users as $user){
            $penerima                           = User::find($user->id);
            if($save_notification == 1){
                $new_notifikasi                 = new Notifikasi();
                $new_notifikasi->sender_id      = null;
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
