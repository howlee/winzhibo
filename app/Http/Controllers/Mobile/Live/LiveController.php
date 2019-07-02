<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/7
 * Time: 11:40
 */

namespace App\Http\Controllers\Mobile\Live;

use App\Http\Controllers\PC\CommonTool;
use App\Models\Local\PcArticle;
use App\Models\Local\Video;
use App\Models\Match\Odd;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LiveController extends Controller
{

    const SPORT_EN_ARRAY = ['zuqiu'=>1, 'nba'=>2];

    /////////////////////////////////////  静态化列表 开始   /////////////////////////////////////
    /**
     * 静态化wap全部列表文件
     * @param Request $request
     */
    public function staticIndex(Request $request){
        //$this->basketballLivesStatic($request);
        //$this->footballLivesStatic($request);
        $this->livesStatic($request);//静态化首页
        //$this->otherLivesStatic($request);
    }
    /////////////////////////////////////  静态化列表 结束   /////////////////////////////////////


    /////////////////////////////////////  wap列表 开始   /////////////////////////////////////

    /**
     * 比赛列表
     * @param Request $request
     * @param $sportEn
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index(Request $request, $sportEn = '') {
        $cache = Storage::get('/public/static/json/lives.json');
        $json = json_decode($cache, true);
        if (!isset($json) || !isset($json['matches'])) {
            return abort(404);
        }
        if (!empty($sportEn) && !isset(self::SPORT_EN_ARRAY[$sportEn]) ) {
            return abort(404);
        }
        $matchArray = [];
        $sport = isset(self::SPORT_EN_ARRAY[$sportEn]) ? self::SPORT_EN_ARRAY[$sportEn] : 0;
        $array = $json['matches'];
        foreach ($array as $date=>$matches) {
            foreach ($matches as $match) {
                $matchSport = $match['sport'];
                if ($sport > 0) {
                    if ($matchSport == $sport) {
                        $matchArray[$date][] = $match;
                    } else if ($matchSport == $sport){
                        $matchArray[$date][] = $match;
                    }
                } else {
                    $matchArray[$date][] = $match;
                }
            }
        }

        $result['matches'] = $matchArray;
        $result['sport_val'] = \App\Http\Controllers\PC\Live\LiveController::SPORT_VAL_ARRAY;
        $result['m'] = env('TEST_M', '');
        $result['sport'] = $sport;
        $result['bar'] = 'live';
        return view('mobile.live.index', $result);
    }

    public function zuqiu(Request $request) {
        return $this->index($request, 'zuqiu');
    }

    public function nba(Request $request) {
        return $this->index($request, 'nba');
    }

    /**
     * 录像列表
     * @param Request $request
     * @param $page = 1
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function videos(Request $request) {
        $videos = Video::query()->orderByDesc('time')->paginate(20);
        $videoArray = [];
        foreach ($videos as $video) {
            $timestamp = strtotime($video["time"]);
            $date = date("Y-m-d", $timestamp);
            $videoArray[$date][] = $video;
        }
        $result['videos'] = $videoArray;
        $result['m'] = env('TEST_M', '');
        $result['bar'] = 'luxiang';
        return view('mobile.video.index', $result);
    }

    public function videosJson(Request $request, $page) {
        $pageSize = 20;
        $videos = Video::query()->orderByDesc('time')->paginate($pageSize, ['*'], '', $page);
        $videoArray = [];
        foreach ($videos as $video) {
            $timestamp = strtotime($video["time"]);
            $video["time"] = $timestamp;
            $date = date("Y-m-d", $timestamp);
            $videoArray['matches'][$date][] = $video;
        }
        $videoArray['page'] = ['curPage'=>$videos->currentPage(), 'lastPage'=>$videos->lastPage(), 'pageSize'=>$pageSize, 'total'=>$videos->total()];
        return response()->json($videoArray);
    }

    /**
     * 录像终端
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function video(Request $request, $id) {
        $video = Video::query()->find($id);
        if (!isset($video)) return abort(404);
        $result['video'] = $video;
        $result["channels"] = $video->channels;
        $result['aicon'] = '';
        $result['hicon'] = '';
        $result['m'] = env('TEST_M', '');
        return view('mobile.video.detail', $result);
    }


    /**
     * 资讯列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function news(Request $request) {
        $news = PcArticle::query()->orderByDesc('publish_at')->paginate(30);

        $result['news'] = $news;
        $result['m'] = env('TEST_M', '');
        $result['bar'] = 'zixun';
        return view('mobile.news.index', $result);
    }

    public function newsJson(Request $request, $page) {
        $pageSize = 30;
        $news = PcArticle::query()->orderByDesc('publish_at')->paginate($pageSize, ['*'], '', $page);

        $data['news'] = $news->items();
        $data['page'] = ['curPage'=>$news->currentPage(), 'lastPage'=>$news->lastPage(), 'pageSize'=>$pageSize, 'total'=>$news->total()];
        return response()->json($data);
    }

    /////////////////////////////////////  wap列表 结束   /////////////////////////////////////

    /////////////////////////////////////  wap终端 开始   /////////////////////////////////////
    public function detail(Request $request, $sport, $mid) {
        $match = CommonTool::getMatch($sport, $mid);
        if (!isset($match)) {
            return abort(404);
        }
        return $this->detailHtml($match, $sport);
    }

    public function detailBy(Request $request, $sportEn, $mid) {
        $array = \App\Http\Controllers\PC\Live\LiveController::SPORT_EN_ARRAY;
        if (!isset($array[$sportEn])) {
            return abort(404);
        }
        $sport = $array[$sportEn];
        return $this->detail($request, $sport, $mid);
    }

    public function detailHtml($match, $sport) {
        $hicon = !empty($match['host_icon']) ? $match['host_icon'] : '//static.liaogou168.com/img/icon_team_default.png';
        $aicon = !empty($match['away_icon']) ? $match['away_icon'] : '//static.liaogou168.com/img/icon_team_default.png';

        $hicon = str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $hicon);
        $aicon = str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $aicon);
        $sport_val = \App\Http\Controllers\PC\Live\LiveController::SPORT_VAL_ARRAY;


        $result = ["match"=>$match, "hicon"=>$hicon, "aicon"=>$aicon];
        $result['m'] = env('TEST_M', '');
        $result['sport_val'] = $sport_val;
        if ($sport == 1 || $sport == 2) {
            $result['parent']['link'] = '/'.$sport_val[$sport].'/';
            $result['parent']['name'] = $sport == 1 ? '足球' : '篮球';
        }
        return view('mobile.live.detail', $result);
    }

    public function newsDetail(Request $request, $id) {
        $news = PcArticle::query()->find($id);
        if (!isset($news) || $news['status'] != PcArticle::kStatusPublish) {
            return abort(404);
        }

        $result['m'] = env('TEST_M', '');
        $result['news'] = $news;
        return view('mobile.news.detail', $result);
    }

    /////////////////////////////////////  wap终端 结束   /////////////////////////////////////
}