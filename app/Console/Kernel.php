<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Http\Request;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
            
        $schedule->call(function () {
            app('App\Http\Controllers\ContactController')->scheduleMassNotification(new Request([
                'scheduled_datetime' => now(), 
                'message' => 'Your mass notification message',
                'contact_id' => 1,
                'user_id' => 1,
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]));
        })->everyTwoHours();

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
