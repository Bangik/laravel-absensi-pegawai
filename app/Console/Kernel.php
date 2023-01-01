<?php

namespace App\Console;

use App\Helpers\GetHoliday;
use App\Models\Setting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();
        if (date('l') == 'Saturday' || date('l') == 'Sunday') {
            return;
        }

        $data = GetHoliday::getHoliday(date('Y/m'));
        $libur = $data['libur'];
        if ($libur) {
            return;
        }
        
        $time_in_reminder = Setting::where('name','time_in_reminder')->first()->value;
        $schedule->command('mail:checkin')
            ->weekdays()
            ->timezone('Asia/Jakarta')
            ->dailyAt($time_in_reminder);
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
