<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/7/9
 * Time: 11:28
 */

namespace App\Console\commands;


use App\Http\Controllers\Mobile\Live\LiveController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WapVideoHtmlCommands extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wap_video_cache:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'wap录像页面静态化';

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

        $wapController = new LiveController();
        $videoHtml = $wapController->videos(new Request());
        if (!empty($videoHtml)) {
            Storage::disk("public")->put("/static/m/videos.html", $videoHtml);
        }

    }

}