<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/7/6
 * Time: 12:29
 */

namespace App\Console\commands;


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
            $ch = curl_init();
            $url = env('AKQ')."/json/m/lives.json";
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $server_output = curl_exec ($ch);
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
            curl_close ($ch);
            if ($http_code >= 400) {
                dump("获取数据失败");
                return;
            }
            if (empty($server_output)) {
                dump("获取数据失败");
                return;
            }
            Storage::disk("public")->put("/static/json/wap/lives.json", $server_output);
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

}