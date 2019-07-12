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
use App\Http\Controllers\PC\CommonTool;
use App\Models\Local\PcArticle;
use App\Models\Local\Video;
use App\Models\Local\VideoRight;
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
    const SPORT_EN_ARRAY = ['zuqiu'=>1, 'nba'=>2, 'qita'=>3];
    const SPORT_VAL_ARRAY = [1=>'zuqiu', 2=>'nba', 3=>'qita'];
    const SPORT_CN_ARRAY = [1=>'足球', 2=>'nba', 3=>'其他'];

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

        $articles = PcArticle::publishArticles();

        $json['week_array'] = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $json['check'] = 'index';
        $json['imArray'] = $imArray;
        $json['videos'] = $this->getVideos(['nba', 'yingchao', 'xijia', 'yijia', 'dejia']);
        $json['type_cn'] = self::VIDEO_CN_ARRAY;
        $json['articles'] = $articles;
        $json['sport_val'] = self::SPORT_VAL_ARRAY;

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
        $json['sport_val'] = self::SPORT_VAL_ARRAY;

        CommonTool::addLiveSEO(1, $json);
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
        $json['videos'] = $this->getVideos(['nba', 'cba']);
        $json['type_cn'] = self::VIDEO_CN_ARRAY;
        $json['sport_val'] = self::SPORT_VAL_ARRAY;

        CommonTool::addLiveSEO(2, $json);
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
        $sport = $typeArray[$type];
        $match = CommonTool::getMatch($sport, $id);
        if (!isset($match)) {
            return abort(404);
        }
        return $this->detailMatchHtml($sport, $match);
    }

    public function detailBy(Request $request, $sportCn, $id) {
        $sportEnArray = self::SPORT_EN_ARRAY;
        if (!isset($sportEnArray[$sportCn])) {
            return abort(404);
        }

        $sport = $sportEnArray[$sportCn];
        $match = CommonTool::getMatch($sport, $id);
        if (!isset($match)) {
            return abort(404);
        }
        return $this->detailMatchHtml($sport, $match);
    }


    /**
     * 直播终端
     * @param $sport
     * @param $match
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailMatchHtml($sport, $match) {
        $league = $match['league_name'];
        if ($sport == 3) {
            if (empty($league) && !empty($match['project'])) {
                $league = $match['project'];
            }
        } else {
            if (empty($league) && !empty($match['win_lname'])) {
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
        if ($sport == 1 || $sport == 2) {
            $result['parent']['link'] = $sport == 1 ? '/zuqiu/' : '/nba/';
            $result['parent']['name'] = $sport == 1 ? '足球' : '篮球';
        }
        CommonTool::addLiveDetailSEO($league, $match, $result);
        return view('pc.live.detail', $result);
    }


    /**
     * 综合录像页面
     * @param Request $request
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function videos(Request $request, $page = 1) {
        $videos = Video::query()->orderByDesc("time")->paginate(25, ['*'], '', $page);
        $page = ['curPage'=>$videos->currentPage(), 'lastPage'=>$videos->lastPage(), 'total'=>$videos->total()];
        $result['page'] = $page;
        $result['videos'] = $videos->items();
        $result['matches'] = self::getLiveMatches();
        $result['week_array'] = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $result['check'] = 'video';

        CommonTool::addVideoSEO($result);
        return view('pc.video.videos', $result);
    }

    public function videoDetail(Request $request, $id) {
        $video = Video::query()->find(intval($id));
        if (!isset($video)) {
            return abort(404);
        }

        return $this->videoDetailHtml($video);
    }


    public function videoDetailHtml($video) {
        $league = $video['lname'];
        $info = $league . ' ' . $video['hname'] . (empty($video['aname']) ? '' : (' VS ' . $video['aname']) ) ;
        $result['match'] = $video;
        $result['info'] = $info;
        $result['league'] = $league;
        $result['channels'] = $video['channels'];
        CommonTool::addVideoDetailSEO($video, $result);
        return view('pc.video.detail', $result);
    }

    //=========================================================  获取数据 =========================================================//

    /**
     * 根据类型获取指定录像数组
     * @param $lids
     * @return array
     */
    private function getVideos(array $lids = []) {
        $rights = VideoRight::rights();
        $array = [];
        foreach ($rights as $right) {
            $sport = $right['sport'];
            $lid = $right['lid'];
            $lname = $right['lname'];

            $videos = Video::findVideos(['sport'=>$sport, 'lname'=>$lname]);
            $array[] = ['league'=>$right, 'videos'=>$videos];
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

    public static function getLiveMatches() {
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
        return $liveMatches;
    }

}