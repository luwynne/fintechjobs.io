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
        Commands\AlertDaily::class,
        Commands\AlertWeekly::class,
        Commands\AlertMonthly::class,
        Commands\AddCompanyDescription::class,
        Commands\EventAlertWeekly::class,
        Commands\FillEducationInstitutesTable::class,
        Commands\FillExternalEventsTable::class,
        Commands\FillExternalEventsTable::class,
        Commands\SendUnregiteredMail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('alert:daily')->daily();
        $schedule->command('alert:weekly')->weekly();
        $schedule->command('alert:monthly')->monthly();
        $schedule->command('event_alert:weekly')->weekly();
        $schedule->command('unregistered:send_mail')->daily();
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
