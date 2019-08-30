<?php
/**
 * Created by PhpStorm.
 * User: BJ
 * Date: 2018/3/5
 * Time: 上午11:06
 */

namespace App\Http\Controllers\PC;

use App\Http\Controllers\PC\Live\LiveController;
use App\Models\Local\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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
        $key = "Match_" . $sport . "_" . $mid;
        $cache = Redis::get($key);
        $match = null;
        if (!empty($cache)) {
            $match = json_decode($cache, true);
        }
        if (!isset($match)) {
            $match = Match::findBy($sport, $mid);
        }
        return $match;
    }

    /**
     *
     * @param $sport
     * @param $mid
     * @return mixed
     */
    public static function getMatchBak($sport, $mid) {
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


    public static function addLiveSEO($sport, array  &$result) {
        if ($sport == 1) {
            $result['title'] = '足球直播_英超免费看';
            $result['keywords'] = '英超直播,中超直播,免费直播,西甲直播,中超直播';
            $result['description'] = '免费的体育直播网站。高清足球直播、英超、中超、西甲、欧冠、意甲等直播全部免费看。';
        } else if ($sport == 2) {
            $result['title'] = '篮球直播_NBA直播免费看';
            $result['keywords'] = 'NBA直播,CBA直播,篮世杯直播,WNBA直播,免费直播';
            $result['description'] = '免费的体育直播网站。高清篮球直播、NBA、CBA、篮球世界杯等直播全部免费看。';
        }
    }

    public static function addVideoSEO(array &$result) {
        $result['title'] = 'NBA录像_综合视频';
        $result['keywords'] = 'NBA录像,英超录像,西甲录像,中超录像,意甲录像';
        $result['description'] = '红单体育为您提供最新最快的NBA录像、英超录像、欧冠录像。';
    }

    public static function addNewsSEO(array &$result) {
        $result['title'] = "体育新闻_热点资讯";
        $result['keywords'] = 'NBA新闻,英超新闻,中超新闻,体育新闻';
        $result['description'] = '红单体育为您提供最新最快的NBA新闻、英超新闻、西甲新闻、中超新闻，体育新闻应有尽有。';
    }

    public static function addTuiJianSEO(array &$result) {
        $result['title'] = "红单推荐";
        $result['keywords'] = 'NBA新闻,英超新闻,中超新闻,体育新闻';
        $result['description'] = '红单体育为您提供最新最快的NBA新闻、英超新闻、西甲新闻、中超新闻，体育新闻应有尽有。';
    }


    /**
     * 直播终端title、keywords、description
     * @param $league
     * @param $match
     * @param array $result
     */
    public static function addLiveDetailSEO($league, $match, array &$result) {
        $info = $league . ' ' . $match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) ) ;
        $result['title'] = $info;
        $result['keywords'] = $league.','.$match['hname'].(empty($match['aname']) ? '' : (',' . $match['aname']) );
        $result['description'] = $match['time'] . ' ' . $info;
    }

    /**
     * 录像终端title、keywords、description
     * @param $video
     * @param array $result
     */
    public static function addVideoDetailSEO($video, array &$result) {
        $lname = $video['lname'];
        $vs = $video['hname'] . ' vs ' . $video['aname'];
        $result['title'] = $lname . ' ' . $vs;
        $result['keywords'] = $lname.','.$video['hname']. ',' . $video['aname'];
        $result['description'] = $video['time'] . ' ' . $video['season'] . ' ' . $lname . ' ' . $video['stage_cn'] . ' ' . $vs;
    }

    /**
     * 录像终端title、keywords、description
     * @param $news
     * @param array $result
     */
    public static function addNewsDetailSEO($news, array &$result) {
        $result['title'] = $news->title.'_热点资讯';
        $result['description'] = $news->digest;
        $result['keywords'] = $news->labels;
    }


}