<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2019/7/1
 * Time: 18:24
 */

namespace App\Console\commands;


use App\Http\Controllers\Controller;
use App\Services\VideoService;
use Illuminate\Console\Command;

class SyncVideoCommand extends Command
{

    protected $signature = "sync_video:run {--page=}";

    protected $description = "同步爱看球录像到数据库";

    public function handle() {
        $page = $this->option("page");
        $page = empty($page) ? 1 : $page;

        $apiHost = env("API_URL", "http://cms.aikanqiu.com");

        $url = $apiHost . "/record/".$page.".json";
        $out = Controller::execUrl($url, 2);
        $data = json_decode($out, true);
        if (empty($data["data"])) {
            return;
        }
        $videos = $data["data"];

        foreach ($videos as $video) {
            VideoService::saveVideoAndChannels($video);
        }
    }

}