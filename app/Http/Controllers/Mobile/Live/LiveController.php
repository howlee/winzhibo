<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/7
 * Time: 11:40
 */

namespace App\Http\Controllers\Mobile\Live;

use App\Http\Controllers\PC\CommonTool;
use App\Models\Local\Video;
use App\Models\Match\Odd;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LiveController extends Controller
{

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index(Request $request) {
        $cache = Storage::get('/public/static/json/lives.json');
        $json = json_decode($cache, true);
        if (!isset($json) || !isset($json['matches'])) {
            return abort(404);
        }
        $array = $json['matches'];
        $footballArray = [];
        $basketArray = [];
        foreach ($array as $date=>$matches) {
            foreach ($matches as $match) {
                $sport = $match['sport'];
                if ($sport == 1) {
                    $footballArray[$date][] = $match;
                } else if ($sport == 2){
                    $basketArray[$date][] = $match;
                }
            }
        }

        $json['footballs'] = $footballArray;
        $json['basketballs'] = $basketArray;
        $json['sport_val'] = \App\Http\Controllers\PC\Live\LiveController::SPORT_VAL_ARRAY;
        $json['m'] = env('TEST_M', '/');
        return view('mobile.live.index', $json);
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
        $result['m'] = env('TEST_M', '/');
        return view('mobile.video.index', $result);
    }

    public function videosJson(Request $request) {
        $videos = Video::query()->orderByDesc('time')->paginate(20);
        $videoArray = [];
        foreach ($videos as $video) {
            $timestamp = strtotime($video["time"]);
            $date = date("Y-m-d", $timestamp);
            $videoArray[$date][] = $video;
        }
        return response()->json(['data'=>$videoArray]);
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
        $result['m'] = env('TEST_M', '/');
        return view('mobile.video.detail', $result);
    }



    /////////////////////////////////////  wap列表 结束   /////////////////////////////////////

    /////////////////////////////////////  wap终端 开始   /////////////////////////////////////
    public function detail(Request $request, $sport, $mid) {
        $match = CommonTool::getMatch($sport, $mid);
        if (!isset($match)) {
            return abort(404);
        }
        return $this->detailHtml($match);
    }

    public function detailBy(Request $request, $sportEn, $mid) {
        $array = \App\Http\Controllers\PC\Live\LiveController::SPORT_EN_ARRAY;
        if (!isset($array[$sportEn])) {
            return abort(404);
        }
        $sport = $array[$sportEn];
        return $this->detail($request, $sport, $mid);
    }

    public function detailHtml($match) {
        $hicon = !empty($match['host_icon']) ? $match['host_icon'] : '//static.liaogou168.com/img/icon_team_default.png';
        $aicon = !empty($match['away_icon']) ? $match['away_icon'] : '//static.liaogou168.com/img/icon_team_default.png';

        $hicon = str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $hicon);
        $aicon = str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $aicon);

        $result = ["match"=>$match, "hicon"=>$hicon, "aicon"=>$aicon];
        $result['m'] = env('TEST_M', '/');
        $result['sport_val'] = \App\Http\Controllers\PC\Live\LiveController::SPORT_VAL_ARRAY;
        $result[''] = \App\Http\Controllers\PC\Live\LiveController::SPORT_VAL_ARRAY;
        return view('mobile.live.detail', $result);
    }

    /**
     * 直播终端
     * @param Request $request
     * @param $id
     * @param bool $immediate 是否即时获取数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function footballDetail(Request $request, $id, $immediate = false) {

        return view('mobile.live.detail');
    }

    /**
     * 直播终端
     * @param Request $request
     * @param $id
     * @param bool $immediate 是否即时获取数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function basketballDetail(Request $request, $id, $immediate = false) {

        return view('mobile.live.detail');
    }

    /**
     * 自建赛事直播终端
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function otherDetail(Request $request, $id) {

        return view('mobile.live.detail');
    }

    /////////////////////////////////////  wap终端 结束   /////////////////////////////////////
}