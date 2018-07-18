<?php

namespace App\Console;

use App\Console\commands\LiveDetailHtmlCommands;
use App\Console\commands\LiveIndexHtmlCommands;
use App\Console\commands\LiveJsonCommands;
use App\Console\commands\LiveJsonWapCommands;
use App\Console\commands\VideoDetailHtmlCommands;
use App\Console\commands\VideoIndexHtmlCommands;
use App\Console\commands\VideoJsonCommands;
use App\Console\commands\WapIndexHtmlCommands;
use App\Console\commands\WapVideoHtmlCommands;
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
        LiveJsonCommands::class,//定时获取所有直播json
        LiveJsonWapCommands::class,//定时获取wap所有直接json
        VideoJsonCommands::class,//同步录像json

        LiveDetailHtmlCommands::class,//直播终端页html缓存
        LiveIndexHtmlCommands::class,//pc首页html静态化
        VideoIndexHtmlCommands::class,//录像页面html静态化
        VideoDetailHtmlCommands::class,//录像终端html静态化

        WapIndexHtmlCommands::class,//手机首页静态化
        WapVideoHtmlCommands::class,//手机录像静态化
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('live_json_cache:run')->everyMinute();//定时获取所有直播json
        $schedule->command('video_json_cache:run')->everyFiveMinutes();//同步录像json

        $schedule->command('wap_live_json_cache:run')->everyMinute();//定时获取wap所有直接json

        $schedule->command('live_index_html:run')->everyFiveMinutes();//pc首页html静态化
        $schedule->command('live_detail_html:run')->everyMinute();//直播终端页html缓存
        $schedule->command('video_index_html:run')->everyTenMinutes();//录像页面html静态化
        $schedule->command('video_detail_html:run')->everyTenMinutes();//录像终端html静态化

        $schedule->command('wap_index_cache:run')->everyMinute();//手机首页静态化
        $schedule->command('wap_video_cache:run')->everyFiveMinutes();//手机录像静态化
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
