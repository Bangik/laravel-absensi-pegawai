<?php

namespace App\Console\Commands;

use App\Models\Present;
use App\Models\User;
use App\Notifications\AttendanceCheckin as NotificationsAttendanceCheckin;
use Illuminate\Console\Command;

class AttendanceCheckin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:checkin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email pengingat absensi masuk';

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
     * @return int
     */
    public function handle()
    {
        $users = User::where('email_verified_at', '!=', null)->get();
        foreach ($users as $user) {
            $present = Present::whereUserId($user->user_id)->whereDates(date('Y-m-d'))->first();
            if ($present == null) {
                $user->notify(new NotificationsAttendanceCheckin());
            }
        }

        return 0;
    }
}
