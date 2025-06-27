<?php

namespace App\Console;

use App\Console\Commands\SyncValidatedIncidentsFromSheet;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

     protected $commands = [
        SyncValidatedIncidentsFromSheet::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('incidents:auto-import')->everyMinute(); 
        // $schedule->command('inspire')->hourly();
{
    $schedule->command('sync:validated-incidents')->everyMinute();
    // $schedule->command('test:planification')->everySecond();
}

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
