<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/7/6
 * Time: 12:29
 */

namespace App\Console\commands;


use App\Http\Controllers\Controller;
use App\Http\Controllers\PC\CommonTool;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LiveJsonWapCommands extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wap_live_json_cache:run';

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
            $url = env('API_URL')."/json/m/lives.json";
            $server_output = Controller::execUrl($url, 3);
            if (!empty($server_output)) {
                Storage::disk("public")->put("/static/json/wap/lives.json", $server_output);
                CommonTool::saveChannelsFromMatches($server_output, true);
                CommonTool::saveMobileDetailHtml($server_output);//保存m站终端html页面
            }
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

}