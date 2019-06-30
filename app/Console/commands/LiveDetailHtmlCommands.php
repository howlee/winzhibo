<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/7/5
 * Time: 12:07
 */

namespace App\Console\commands;


use App\Http\Controllers\PC\Live\LiveController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class LiveDetailHtmlCommands extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live_detail_html:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '直播赛事终端页html';

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
        //获取json
        $file = Storage::get('public/static/json/lives.json');
        $json = json_decode($file, true);
        if (!isset($json) || !isset($json['matches'])) {
            dump('暂无数据');
            return;
        }
        $matchArray = $json['matches'];

        $liveController = new LiveController();
        $mController = new \App\Http\Controllers\Mobile\Live\LiveController();
        foreach ($matchArray as $time=>$matches) {
            foreach ($matches as $key=>$match) {
                $sport = $match['sport'];
                $mid = $match['mid'];
                if ($sport == 1) {
                    $type = 'football';
                } else if ($sport == 2) {
                    $type = 'basketball';
                } else {
                    $type = 'other';
                }
                $html = $liveController->detailMatchHtml($sport, $match);
                if (!empty($html)) {
                    Storage::disk("public")->put("/static/live/" . $type . "/" . $mid . ".html", $html);
                }
                //'football'=>1, 'basketball'=>2, 'other'=>3
                $mHtml = $mController->detailHtml($match);
                if (!empty($mHtml)) {
                    Storage::disk("public")->put("/static/m/live/" . $type . "/" . $mid . ".html", $html);
                }
            }
        }

    }

}