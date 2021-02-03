<?php

namespace App\Console;

use App\Jobs\AddBooksJob;
use App\Jobs\Min10TotalCulculatingJob;
use App\Jobs\Min3TotalCulculatingJob;
use App\Jobs\Min5TotalCulculatingJob;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new AddBooksJob)->everyMinute();
        $schedule->job(new Min3TotalCulculatingJob)->everyMinute();
        $schedule->job(new Min5TotalCulculatingJob)->everyMinute();
        $schedule->job(new Min10TotalCulculatingJob)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
