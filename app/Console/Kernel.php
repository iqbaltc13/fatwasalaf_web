<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\NotifNasabahBaru::class,
        Commands\NotifNasabahMenabung::class,
        Commands\NotifUpdateApp::class,
        Commands\ChangeFullPathToHttpsOnFile::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notif:nasabah_baru')->hourly();
        $schedule->command('notif:nasabah_menabung')->monthlyOn(3,'12:00');
        $schedule->command('notif:notif:updateapp')->weeklyOn(1, '8:00');	;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        
        require base_path('routes/console.php');
    }
}
