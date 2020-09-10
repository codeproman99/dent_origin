<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;

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
        $schedule->call(function () {
            $current_date = date('Y-m-d');
            $users = User::where('role', '!=', 1)->get();
            foreach ($users as $user) {
                if(!$user->active_due_date && $user->active_due_date < $current_date){
                    $user->status = 0;
                    $user->save();
                }
            }
        })->daily();
    }
}
