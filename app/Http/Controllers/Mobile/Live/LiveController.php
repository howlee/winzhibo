<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/7
 * Time: 11:40
 */

namespace App\Http\Controllers\Mobile\Live;

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
     * 足球列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index(Request $request) {
        $cache = Storage::get('/public/static/json/wap/lives.json');
        $json = json_decode($cache, true);
        if (!isset($json) || !isset($json['matches'])) {
            return "";
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
        return view('mobile.live.index', $json);
    }

    /**
     * 录像列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function videos(Request $request) {
        $cache = Storage::get('/public/static/json/subject/videos/all/1.json');
        $json = json_decode($cache, true);
        if (!isset($json) || !isset($json['matches'])) {
            return "";
        }
        return view('mobile.video.index', $json);
    }
    /////////////////////////////////////  wap列表 结束   /////////////////////////////////////

    /////////////////////////////////////  wap终端 开始   /////////////////////////////////////
    /**
     * 直播终端
     * @param Request $request
     * @param $id
     * @param bool $immediate 是否即时获取数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function footballdetail(Request $request, $id, $immediate = false) {

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