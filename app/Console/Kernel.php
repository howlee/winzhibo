<?php

namespace App\Console;

use App\Console\aikq\LiveBreakCommands;
use App\Console\Article\SpiderArticleCommand;
use App\Console\Article\SpiderArticleDetailCommand;
use App\Console\commands\LiveDetailHtmlCommands;
use App\Console\commands\LiveIndexHtmlCommands;
use App\Console\commands\LiveJsonCommands;
use App\Console\commands\LiveJsonWapCommands;
use App\Console\commands\SyncVideoCommand;
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
        SyncVideoCommand::class,//同步爱看球录像

        WapIndexHtmlCommands::class,//手机首页静态化
        WapVideoHtmlCommands::class,//手机录像静态化

        //爱看球直播线路检查
        LiveBreakCommands::class,
        DeleteExpireFileCommand::class,//删除无用过期文件

        SpiderArticleCommand::class,//抓取直播吧足球首页文章列表
        SpiderArticleDetailCommand::class,//抓取直播吧足球文章内容
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
//        $schedule->command('video_json_cache:run')->everyFiveMinutes();//同步录像json
//
//        $schedule->command('wap_live_json_cache:run')->everyMinute();//定时获取wap所有直接json
//
//        $schedule->command('live_index_html:run')->everyMinute();//pc首页html静态化
//        $schedule->command('live_detail_html:run')->everyFiveMinutes();//直播终端页html缓存
//        $schedule->command('video_index_html:run')->everyTenMinutes();//录像页面html静态化
//        $schedule->command('video_detail_html:run')->everyTenMinutes();//录像终端html静态化
//
//        $schedule->command('wap_index_cache:run')->everyMinute();//手机首页静态化
//        $schedule->command('wap_video_cache:run')->everyFiveMinutes();//手机录像静态化

        /**
         * 修改为在linux 服务器crontab 执行定时任务，每30秒执行一次。
         * * * * * * php /data/app/qiutantiyu/artisan check_live_break:run >>/tmp/date.txt
         * * * * * sleep 30; php /data/app/qiutantiyu/artisan check_live_break:run >>/tmp/date.txt
         */
//        $schedule->command('check_live_break:run')->everyMinute();//检查直播流是否中断
//        $schedule->command('delete_cache:run')->dailyAt('07:00');//每天7点删除无用过期文件

        //$schedule->command('spider_article:run')->everyTenMinutes();
        //$schedule->command('spider_article_detail:run')->cron('*/3 * * * *');
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
