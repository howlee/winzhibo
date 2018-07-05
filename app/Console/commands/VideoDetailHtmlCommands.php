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

class VideoDetailHtmlCommands  extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video_detail_html:run';

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
        //静态化第一页
        $matchArray = $json['matches'];
        $videoArray = [];
        foreach ($matchArray as $time=>$videos) {
            foreach ($videos as $video) {
                $videoArray[] = $video;
            }
        }
        $this->detail2html($videoArray);//静态化终端页面

        $lastPage = $page['lastPage'];
        for ($pageIndex = 1; $pageIndex <= $lastPage; $pageIndex++) {
            $vArray = $this->videoArrayFromAll($pageIndex);
            $this->detail2html($vArray);
        }
    }

    /**
     * 获取分页录像列表
     * @param $page
     * @return array
     */
    protected function videoArrayFromAll($page) {
        $videoArray = [];
        $cache = Storage::get('/public/static/json/subject/videos/all/' . $page . '.json');
        $json = json_decode($cache, true);
        if (!isset($json) || !isset($json['matches'])) {
            return $videoArray;
        }
        $matchArray = $json['matches'];
        $videoArray = [];
        foreach ($matchArray as $time=>$videos) {
            foreach ($videos as $video) {
                $videoArray[] = $video;
            }
        }
        return $videoArray;
    }

    /**
     * 静态化录像终端页面
     * @param array $videos
     */
    protected function detail2html(array $videos) {
        $liveController = new LiveController();
        foreach ($videos as $video) {
            $id = $video['id'];
            $html = $liveController->videoDetailHtml($video);
            usleep(100);
            Storage::disk("public")->put("/static/live/videos/detail/" . $id . ".html", $html);
        }
    }

}