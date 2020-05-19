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
        // \App\Console\Commands\LogCommand::class, //コマンドの登録
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule
        //     ->command('command:logcommand')
        //     ->timezone('Asia/Tokyo')
        //     // テスト用
        //     ->unlessBetween('01:00', '8:00')
        //     ->everyMinutes();
        // スケジュールの登録（毎日5回実行）
        // ->daily()
        // ->at('09:00', '12:00', '15:00', '18:00', '21:00'); 
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
