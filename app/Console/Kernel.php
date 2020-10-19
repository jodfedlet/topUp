<?php

namespace App\Console;

use App\Console\Commands\SendMailForLowBalance;
use App\Console\Commands\SyncCountries;
use App\Console\Commands\SyncOperators;
use App\Console\Commands\SyncToken;
use App\Jobs\RemoveOldLogs;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands providphp artisan make:event Accueil
    ed by your application.
     *
     * @var array
     */
    protected $commands = [
        SendMailForLowBalance::class,
        SyncToken::class,
        SyncCountries::class,
        SyncOperators::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sync:countries')->daily()->runInBackground();
        $schedule->command('sync:operators')->daily()->runInBackground();
        $schedule->command('sync:tokens')->daily()->runInBackground();
        $schedule->command('send:lowBalanceEmail')->daily()->runInBackground();
        $schedule->job(RemoveOldLogs::class)->daily()->runInBackground();
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
