<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2019/7/1
 * Time: 15:58
 */

namespace App\Models\Local;


use Illuminate\Database\Eloquent\Model;

class VideoChannel extends Model
{
    public $connection = "qt";

    public static function findByAkqId($id) {
        return self::query()->where('akq_id', $id)->first();
    }

    public static function saveChannels(Video $video, array $channels) {
        if (!isset($video) || empty($channels)) return;
        $video_id = $video["id"];
        foreach ($channels as $channel) {
            $id = $channel["id"];
            $newChannel = self::findByAkqId($id);
            if (!isset($newChannel)) {
                $newChannel = new VideoChannel();
                $newChannel->akq_id = $id;
            }
            $newChannel->video_id = $video_id;
            $newChannel->title = $channel["title"];
            $newChannel->cover = $channel["cover"];
            $newChannel->content = $channel["content"];
            $newChannel->od = $channel["od"];
            $newChannel->type = $channel["type"];

            $newChannel->save();
        }
    }

}