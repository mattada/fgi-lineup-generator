<?php

namespace App\Console;

use App\Console\Commands\CheckUsersSubscriptionStatus;
use App\Console\Commands\ContentMigration;
use App\Console\Commands\ImportUsersFromCointentCSV;
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
        CheckUsersSubscriptionStatus::class,
        ContentMigration::class,
        ImportUsersFromCointentCSV::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('user:check-status')->dailyAt('23:00');
    }
}
