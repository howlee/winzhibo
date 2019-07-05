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
use App\Models\Local\Match;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
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
                $data = json_decode($server_output, true);
                if (!isset($data["matches"])) {
                    return;
                }
                $matches = $data["matches"];
                foreach ($matches as $date=>$matchArray) {
                    foreach ($matchArray as $key=>$match) {
                        $status = $match["status"];
                        $time = strtotime($match["time"]);
                        if ($status == -1) {
                            $cache = Redis::get($key);
                            if (empty($cache)) {
                                Match::saveMatch($match);
                                Redis::setEx($key, 60 * 60 * 4, 1);
                            }
                        } else {
                            $newKey = "Match_" . $key;
                            Redis::setEx($newKey, $time - time() + (60 * 60 * 4), json_encode($match));
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            Log::error($exception);
        }
    }

}