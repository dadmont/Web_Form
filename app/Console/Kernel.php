<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Регулярное расписание команд
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('report:daily')->dailyAt('20:00');
    }

    /**
     * Регистрация команд
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}