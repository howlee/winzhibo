<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/5/22
 * Time: 12:42
 */

namespace App\Console\commands;


use Illuminate\Console\Command;

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
        $url = '/m/live/subject/videos/all/1.json';
        try {
            $ch = curl_init();
            $url = env('AKQ')."/json/lives.json";
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $server_output = curl_exec ($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);
            if ($code >= 400 || empty($server_output)) {
                return;
            }
            Storage::disk("public")->put("/static/json/lives.json", $server_output);
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }
}