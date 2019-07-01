<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2019/7/1
 * Time: 18:38
 */

namespace App\Services;


use App\Models\Local\Video;
use App\Models\Local\VideoChannel;
use Illuminate\Support\Facades\DB;

class VideoService
{

    public static function saveVideoAndChannels(array $video) {
        DB::transaction(function () use ($video) {
            $newVideo = Video::saveVideo($video);
            VideoChannel::saveChannels($newVideo, $video["channels"]);
        });
    }

}