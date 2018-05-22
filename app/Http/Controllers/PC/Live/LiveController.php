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

    const VIDEO_ID_ARRAY = ['nba'=>1009, 'cba'=>1010, 'yingchao'=>1000, 'xijia'=>1003, 'dejia'=>1006, 'fajia'=>1005, 'yijia'=>1004, 'zhongchao'=>1002];
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

        $json['week_array'] = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $json['check'] = 'index';
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