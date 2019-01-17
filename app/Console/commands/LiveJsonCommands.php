<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/5/18
 * Time: 18:51
 */

namespace App\Console\commands;


use App\Http\Controllers\Controller;
use App\Http\Controllers\PC\CommonTool;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LiveJsonCommands extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live_json_cache:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '直播赛事json缓存';

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
        try {
            $url = env('API_URL')."/json/pc/lives.json";
            $server_output = Controller::execUrl($url, 3);
            if (!empty($server_output)) {
                Storage::disk("public")->put("/static/json/lives.json", $server_output);
                CommonTool::saveChannelsFromMatches($server_output, false);//保存 channels.json
                CommonTool::saveMatchJson($server_output);//保存 比赛信息 PC
                CommonTool::savePlayerHtml($server_output);//保存player播放终端HTML
            }
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

}