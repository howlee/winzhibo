<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/7/5
 * Time: 12:58
 */

namespace App\Console\commands;


use App\Http\Controllers\PC\Live\LiveController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LiveIndexHtmlCommands  extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live_index_html:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '直播首页html静态化';

    /**
     * Create a new command instance.
     * HotMatchCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $liveController = new LiveController();
        //index html 静态化
        $indexHtml = $liveController->lives(new Request());
        $footballHtml = $liveController->footballLives(new Request());
        $basketballHtml = $liveController->basketballLives(new Request());

        Storage::disk("public")->put("/static/index.html", $indexHtml);
        Storage::disk("public")->put("/static/live/football.html", $footballHtml);
        Storage::disk("public")->put("/static/live/basketball.html", $basketballHtml);
    }

}