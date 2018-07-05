<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/7/5
 * Time: 13:07
 */

namespace App\Console\commands;


use App\Http\Controllers\PC\Live\LiveController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoIndexHtmlCommands  extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video_index_html:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '录像列表html静态化';

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
        $cache = Storage::get('/public/static/json/subject/videos/all/1.json');
        $json = json_decode($cache, true);
        if (!isset($json)) {
            dump('数据不存在');
            return;
        }
        $page = $json['page'];//获取分页信息
        if (!isset($page)) {
            dump('分页数据不存在');
            return;
        }
        $lastPage = $page['lastPage'];
        $liveController = new LiveController();
        for ($pageIndex = 1; $pageIndex <= $lastPage; $pageIndex++) {
            $videoHtml = $liveController->videos(new Request(), $pageIndex);
            usleep(100);
            if ($pageIndex == 1) {
                Storage::disk("public")->put("/static/live/videos.html", $videoHtml);
            }
            Storage::disk("public")->put("/static/live/videos/index" . $pageIndex . ".html", $videoHtml);
        }
    }

}