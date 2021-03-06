<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/5/22
 * Time: 12:42
 */

namespace App\Console\commands;


use App\Http\Controllers\PC\Live\LiveController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoJsonCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video_json_cache:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '录像json缓存';

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
            $prefix = env('AKQ');
            $array = LiveController::VIDEO_ID_ARRAY;

            foreach ($array as $t=>$id) {
                $index = 1;
                $lastPage = 1;
                while($index <= $lastPage) {
                    $url = $prefix . "/m/live/subject/videos/" . $id . "/$index.json?time=".time();
                    dump($url);
                    $server_output = self::execUrl($url);
                    if (!empty($server_output)) {
                        $json = json_decode($server_output, true);
//                        $matches = isset($json['matches']) ? $json['matches'] : [];
//                        foreach ($matches as $time=>$array) {
//                            foreach ($array as $match) {
//                                $hicon = isset($match['hicon']) ? $match['hicon'] : '';
//                                $aicon = isset($match['aicon']) ? $match['aicon'] : '';
//
//                                $match['hicon'] = empty($hicon) ? '' : str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $hicon);
//                                $match['aicon'] = empty($aicon) ? '' : str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $aicon);
//                            }
//                        }
                        Storage::disk("public")->put("/static/json/subject/videos/$id/$index.json", json_encode($json));
                        if (isset($json['page']['lastPage'])) {
                            $lastPage = $json['page']['lastPage'];
                        }
                    }
                    $index++;
                }
            }
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

    /**
     * 执行url返回内容
     * @param $url
     * @param $timeout
     * @return mixed|string
     */
    public static function execUrl($url, $timeout = 5) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $server_output = curl_exec ($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        if ($code >= 400 || empty($server_output)) {
            return "";
        }
        return $server_output;
    }
}