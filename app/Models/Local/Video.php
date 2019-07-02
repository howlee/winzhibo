<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2019/7/1
 * Time: 15:49
 */

namespace App\Models\Local;


use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public $connection = "qt";

    public function channels() {
        return $this->hasMany(VideoChannel::class, 'video_id', 'id');
    }

    public static function findByAkqId($id) {
        return self::query()->where('akq_id', $id)->first();
    }


    public static function findVideos(array $param) {
        $count = isset($param["pageSize"]) ? $param["pageSize"] : 25;
        $orderBy = isset($param["orderBy"]) ? $param["orderBy"] : "time";
        $desc = isset($param["desc"]) ? $param["desc"] : 1;
        $query = self::query();
        $fieldArray = ["sport", "mid", "lid", "hid", "aid", "season", "lname"];
        foreach ($fieldArray as $field) {
            if (isset($param[$field])) {
                $query->where($field, $param[$field]);
            }
        }

        $query->orderBy($orderBy, $desc);
        return $query->take($count)->get();
    }

    public static function saveVideo(array $video) {
        $id = $video["id"];
        $localVideo = self::findByAkqId($id);
        if (!isset($localVideo)) {
            $localVideo = new Video();
            $localVideo->akq_id = $id;
        }

        $localVideo->sport = $video["sport"];
        $localVideo->stage_cn = $video["stage_cn"];
        $localVideo->round = $video["round"];
        $localVideo->season = $video["season"];
        $localVideo->mid = $video["mid"];
        $localVideo->lname = $video["lname"];
        $localVideo->hname = $video["hname"];
        $localVideo->aname = $video["aname"];
        $localVideo->hid = $video["hid"];
        $localVideo->aid = $video["aid"];
        $localVideo->hscore = $video["hscore"];
        $localVideo->ascore = $video["ascore"];
        $localVideo->hicon = isset($video["hicon"]) ? $video["hicon"] : null;
        $localVideo->aicon = isset($video["aicon"]) ? $video["aicon"] : null;
        $localVideo->time = $video["time"];

        $localVideo->save();
        return $localVideo;
    }


}