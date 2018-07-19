<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/7
 * Time: 11:40
 */

namespace App\Http\Controllers\PC\Live;

use App\Console\LiveDetailCommand;
use App\Console\NoStartPlayerJsonCommand;
use App\Models\Match\MatchLiveChannel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Cookie;

class LiveController extends Controller
{
    const BET_MATCH = 1;
    const LIVE_HD_CODE_KEY = 'LIVE_HD_CODE_KEY';
    const TypeArray = ['football'=>1, 'basketball'=>2, 'other'=>3];

    const VIDEO_ID_ARRAY = ['all'=>'all', 'other'=>'999', 'nba'=>1009, 'cba'=>1010, 'yingchao'=>1000, 'xijia'=>1003, 'dejia'=>1006, 'fajia'=>1005, 'yijia'=>1004, 'zhongchao'=>1002];
    //const VIDEO_CN_ARRAY = ['all'=>'全部', 999=>'其他', 1009=>'NBA', 1010=>'CBA', 1000=>'英超', 1003=>'西甲', 1006=>'德甲', 1005=>'法甲', 1004=>'意甲', 1002=>'中超'];
    const VIDEO_CN_ARRAY = ['all'=>'all', 'other'=>'其他', 'nba'=>'NBA', 'cba'=>'CBA', 'yingchao'=>'英超', 'xijia'=>'西甲', 'dejia'=>'德甲', 'fajia'=>'法甲', 'yijia'=>'意甲', 'zhongchao'=>'中超'];
    const SPORT_FOOTBALL = 1, SPORT_BASKETBALL = 2, SPORT_OTHER = 3;

    //===============================================================================//


    /**
     * 首页直播列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function lives(Request $request) {
        $cache = Storage::get('/public/static/json/lives.json');
        $json = json_decode($cache, true);
        if (is_null($json)){
            $json = [];
        }

        $imArray = [];

        if (isset($json['matches'])) {
            $matches = $json['matches'];
            foreach ($matches as $time=>$array) {
                foreach ($array as $key=>$match) {
                    $isIm = false;
                    $channels = $match['channels'];
                    foreach ($channels as $channel) {
                        if ($channel['impt'] == 2){
                            $isIm = true;
                        }
                        break;
                    }
                    if ($isIm) {
                        $imArray[] = $match;
                    }
                }
            }
        }

        $json['week_array'] = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $json['check'] = 'index';
        $json['imArray'] = $imArray;
        $json['videos'] = $this->getVideos(['nba', 'yingchao', 'xijia', 'yijia', 'dejia']);
        $json['type_cn'] = self::VIDEO_CN_ARRAY;
        return view('pc.index', $json);
    }

    /**
     * 足球直播
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function footballLives(Request $request) {
        $footArray = $this->getLivesBySport(self::SPORT_FOOTBALL);
        $json['matches'] = $footArray;
        $json['week_array'] = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $json['check'] = 'football';
        $json['type_cn'] = self::VIDEO_CN_ARRAY;
        $json['videos'] = $this->getVideos(['yingchao', 'zhongchao', 'xijia', 'yijia', 'dejia']);
        $json['title'] = '足球直播_英超直播_意甲直播_德甲直播_法甲直播_中超直播_亚洲直播_免费足球直播';
        return view('pc.index', $json);
    }

    /**
     * 篮球比赛
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function basketballLives(Request $request) {
        $matches = $this->getLivesBySport(self::SPORT_BASKETBALL);
        $json['matches'] = $matches;
        $json['week_array'] = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $json['check'] = 'basketball';
        $json['title'] = '篮球直播_篮球免费直播_NBA直播_CBA直播_NBA决赛直播_欧锦赛直播';
        $json['videos'] = $this->getVideos(['nba', 'cba']);
        $json['type_cn'] = self::VIDEO_CN_ARRAY;
        return view('pc.index', $json);
    }

    /**
     * 直播终端
     * @param Request $request
     * @param $type
     * @param $id
     * @param bool $immediate  是否即时获取数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $type, $id) {
        $typeArray = self::TypeArray;
        if (!isset($typeArray[$type])) {
            return abort(404);
        }

        $cache = Storage::get('/public/static/json/lives.json');
        $json = json_decode($cache, true);
        if (is_null($json) || !isset($json['matches'])) {
            return abort(404);
        }
        $matches = $json['matches'];
        //获取比赛信息

        $sport = $typeArray[$type];

        foreach ($matches as $time=>$matchArray) {
            if (isset($matchArray[$sport . '_' . $id])) {
                $match = $matchArray[$sport . '_' . $id];
                break;
            }
        }
        if (!isset($match)) {
            return abort(404);
        }
        return $this->detailMatchHtml($sport, $match);
//        if ($sport == 3) {
//            $league = $match['lname'];
//            if (empty($league)) {
//                $league = $match['project'];
//            }
//        } else {
//            $league = $match['lname'];
//            if (empty($league)) {
//                $league = $match['win_lname'];
//            }
//        }
//        $info = $league . ' ' . $match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) ) ;
//
//        $result['match'] = $match;
//        $result['info'] = $info;
//        $result['league'] = $league;
//
//        $result['title'] = $info;
//        $result['keywords'] = '';
//        $result['description'] = '';
//
//        return view('pc.live.detail', $result);
    }


    /**
     * 直播终端
     * @param $sport
     * @param $match
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailMatchHtml($sport, $match) {
        if ($sport == 3) {
            $league = $match['lname'];
            if (empty($league)) {
                $league = $match['project'];
            }
        } else {
            $league = $match['lname'];
            if (empty($league)) {
                $league = $match['win_lname'];
            }
        }
        $info = $league . ' ' . $match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) ) ;
        $result['match'] = $match;
        $result['info'] = $info;
        $result['league'] = $league;

        $result['title'] = $info;
        $result['keywords'] = '';
        $result['description'] = '';
        return view('pc.live.detail', $result);
    }


    /**
     * 综合录像页面
     * @param Request $request
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function videos(Request $request, $page = 1) {
        $videos = $this->getVideoTypeByPage('all', $page);

        $cache = Storage::get('/public/static/json/lives.json');
        $json = json_decode($cache, true);
        $liveMatches = [];
        if (isset($json['matches'])) {
            $matches = $json['matches'];
            foreach ($matches as $time=>$matchArray) {
                foreach ($matchArray as $match) {
                    $liveMatches[] = $match;
                    if (count($liveMatches) >= 30) break;
                }
                if (count($liveMatches) >= 30) break;
            }
        }

        $videoArray = [];
        if (isset($videos['matches'])) {
            $vms = $videos['matches'];
            foreach ($vms as $vt=>$vs) {
                foreach ($vs as $video) {
                    $videoArray[] = $video;
                }
            }
        }
        $result['page'] = $videos['page'];
        $result['videos'] = $videoArray;
        $result['matches'] = $liveMatches;
        $result['week_array'] = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $result['check'] = 'video';
        return view('pc.video.videos', $result);
    }


    public function videoDetailHtml(array $video) {
        $league = $video['lname'];
        $info = $league . ' ' . $video['hname'] . (empty($video['aname']) ? '' : (' VS ' . $video['aname']) ) ;
        $video['time'] = date('Y-m-d H:i:s', $video['time']);
        $result['match'] = $video;
        $result['info'] = $info;
        $result['league'] = $league;

        $result['title'] = $info;
        $result['keywords'] = '';
        $result['description'] = '';
        return view('pc.live.detail', $result);
    }

    //=========================================================  获取数据 =========================================================//

    /**
     * 获取第一页得录像数据
     * @param $type
     * @param $page
     * @return array
     */
    private function getVideoTypeByPage($type, $page = 1) {
        $array = self::VIDEO_ID_ARRAY;
        if (!isset($array[$type])) {
            return [];
        }

        try {
            $id = $array[$type];
            $cache = Storage::get('/public/static/json/subject/videos/' . $id . '/' . $page . '.json');
            $json = json_decode($cache, true);
        } catch (\Exception $exception) {
            return [];
        }
        return $json;
    }

    /**
     * 根据类型获取指定录像数组
     * @param array $types
     * @return array
     */
    private function getVideos(array $types) {
        $array = [];

        foreach ($types as $type) {
            $videos = $this->getVideoTypeByPage($type);
            if (!isset($videos['matches'])) continue;

            $matches = $videos['matches'];
            foreach ($matches as $time => $videoArray) {
                foreach ($videoArray as $video) {
                    $array[$type][] = $video;
                }
            }
        }

        return $array;
    }

    /**
     * 冲缓存中获取比赛
     * @param $sport
     * @return array
     */
    private function getLivesBySport($sport) {
        $cache = Storage::get('/public/static/json/lives.json');
        $json = json_decode($cache, true);
        if (is_null($json)){
            $json = ['matches'=>[]];
        }
        $matches = $json['matches'];
        $matchArray = [];
        foreach ($matches as $time=>$array) {
            foreach ($array as $id=>$match) {
                $m_sport = $match['sport'];
                if ($m_sport != $sport) {
                    unset($array[$id]);
                }
            }
            if (count($array) > 0) {
                $matchArray[$time] = $array;
            }
        }
        return $matchArray;
    }

}