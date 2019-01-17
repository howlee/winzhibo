<?php
/**
 * Created by PhpStorm.
 * User: BJ
 * Date: 2018/3/5
 * Time: 上午11:06
 */

namespace App\Http\Controllers\PC;

use App\Http\Controllers\PC\Live\LiveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommonTool
{
    //比赛类型
    const kSportFootball = 1, kSportBasketball = 2;//1：足球，2：篮球，其他待添加。

    public static function subjectLink($id, $type) {
        $id = $id . '';
        $len = strlen($id);
        if ($len < 4) {
            return "";
        }
        $first = substr($id, 0, 2);
        $second = substr($id, 2, 3);
        $url = '/live/subject/' . $type . '/' . $first . '/' . $second . '/' . $id . '.html';
        return $url;
    }

    public static function newsDetailPath($id) {
        $id = $id . '';
        $tmpId = $id . '';
        while (strlen($tmpId) < 4) {
            $tmpId = "0" . $tmpId;
        }
        $first = substr($tmpId, 0, 2);
        $second = substr($tmpId, 2, 3);

        return "/news/$first/$second/$id.html";
    }

    public static function newsDetailLink($id) {
        return "/news/$id.html";
    }


    /**
     * 保存线路json
     * @param $out
     * @param $isMobile
     */
    public static function saveChannelsFromMatches($out, $isMobile) {
        $array = json_decode($out, true);
        if (is_null($array) || !isset($array["matches"])) {
            return;
        }
        $matches = $array["matches"];
        foreach ($matches as $time=>$matchArray) {
            foreach ($matchArray as $key=>$match) {
                $sport = $match["sport"];
                $mid = $match["mid"];

                $tmpId = $mid . '';
                while (strlen($tmpId) < 4) {
                    $tmpId = "0" . $tmpId;
                }
                $first = substr($tmpId, 0, 2);
                $second = substr($tmpId, 2, 2);

                $channels = $match["channels"];
                $json = json_encode($channels);

                $path = $sport."/".$first."/".$second."/".$mid.".json";

                if ($isMobile) {
                    Storage::disk("public")->put("/static/json/channels/m/$path", $json);
                } else {
                    Storage::disk("public")->put("/static/json/channels/pc/$path", $json);
                }
            }
        }
    }

    public static function saveMatchJson($out) {
        $array = json_decode($out, true);
        if (is_null($array) || !isset($array["matches"])) {
            return;
        }
        $matches = $array["matches"];
        foreach ($matches as $time=>$matchArray) {
            foreach ($matchArray as $key => $match) {
                $sport = $match["sport"];
                $mid = $match["mid"];

                $tmpId = $mid . '';
                while (strlen($tmpId) < 4) {
                    $tmpId = "0" . $tmpId;
                }
                $first = substr($tmpId, 0, 2);
                $second = substr($tmpId, 2, 2);
                $json = json_encode($match);

                $path = "/static/json/match/".$sport."/".$first."/".$second."/".$mid.".json";
                Storage::disk("public")->put($path, $json);
            }
        }
    }

    /**
     * 保存player的html
     * @param $out
     */
    public static function savePlayerHtml($out) {
        $array = json_decode($out, true);
        if (is_null($array) || !isset($array["matches"])) {
            return;
        }
        $matches = $array["matches"];
        $con = new LiveController();
        $request = new Request();
        foreach ($matches as $time=>$matchArray) {
            foreach ($matchArray as $key => $match) {
                $sport = $match["sport"];
                $mid = $match["mid"];
                $playerHtml = $con->player($request, $sport, $mid);
                if (empty($playerHtml)) continue;

                $tmpId = $mid . '';
                while (strlen($tmpId) < 4) {
                    $tmpId = "0" . $tmpId;
                }
                $first = substr($tmpId, 0, 2);
                $second = substr($tmpId, 2, 2);

                $path = "/static/live/player/".$sport."/".$first."/".$second."/".$mid.".html";
                Storage::disk("public")->put($path, $playerHtml);
            }
        }
    }

    public static function saveMobileDetailHtml($out) {
        $array = json_decode($out, true);
        if (is_null($array) || !isset($array["matches"])) {
            return;
        }
        $matches = $array["matches"];
        $con = new \App\Http\Controllers\Mobile\Live\LiveController();
        $request = new Request();
        foreach ($matches as $time=>$matchArray) {
            foreach ($matchArray as $key => $match) {
                $sport = $match["sport"];
                $mid = $match["mid"];
                $playerHtml = $con->detail($request, $sport, $mid);
                if (empty($playerHtml)) continue;

                $tmpId = $mid . '';
                while (strlen($tmpId) < 4) {
                    $tmpId = "0" . $tmpId;
                }
                $first = substr($tmpId, 0, 2);
                $second = substr($tmpId, 2, 2);

                $path = "/static/m/detail/".$sport."/".$first."/".$second."/".$mid.".html";
                Storage::disk("public")->put($path, $playerHtml);
            }
        }
    }

    /**
     *
     * @param $sport
     * @param $mid
     * @return mixed
     */
    public static function getMatch($sport, $mid) {
        $tmpId = $mid . '';
        while (strlen($tmpId) < 4) {
            $tmpId = "0" . $tmpId;
        }
        $first = substr($tmpId, 0, 2);
        $second = substr($tmpId, 2, 2);

        $path = "/static/json/match/".$sport."/".$first."/".$second."/".$mid.".json";

        $matchString = Storage::get("/public".$path);
        $match = json_decode($matchString, true);
        return $match;
    }

    /**
     * 获取线路内容
     * @param $sport
     * @param $mid
     * @param $isMobile
     * @return mixed
     */
    public static function getChannels($sport, $mid, $isMobile) {
        $tmpId = $mid . '';
        while (strlen($tmpId) < 4) {
            $tmpId = "0" . $tmpId;
        }
        $first = substr($tmpId, 0, 2);
        $second = substr($tmpId, 2, 2);

        $path = "/".$sport."/".$first."/".$second."/".$mid.".json";
        if ($isMobile) {
            $path = "/static/json/channels/m".$path;
        } else {
            $path = "/static/json/channels/pc".$path;
        }

        $channelsString = Storage::get("/public".$path);
        $channels = json_decode($channelsString, true);
        return $channels;
    }

}