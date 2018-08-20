<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/8/10
 * Time: 12:45
 */

namespace App\Console\aikq;


use App\Http\Controllers\Vendor\Weixin\WeixinTampleMessage;
use App\Models\Aikq\LiveAccountSign;
use App\Models\Aikq\BasketMatch;
use App\Models\Aikq\LiveChannelLog;
use App\Models\Aikq\LiveDuty;
use App\Models\Aikq\Match;
use App\Models\Aikq\MatchLive;
use App\Models\Aikq\MatchLiveChannel;
use EasyWeChat\Foundation\Application;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class LiveBreakCommands extends Command
{
    protected $app;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_live_break:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查正在直播的流是否中断';

    /**
     * Create a new command instance.
     * HotMatchCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $now = date('Y-m-d H:i');
        //$query = LiveDuty::query()->where('start_date', '<=', $now);
        //$duties = $query->where('end_date', '>=', $now)->get();
        $openidArray = LiveAccountSign::getOnOpenidArray();
        $admins = LiveAccountSign::getSignAccounts();//当前值班人员

        $footballLives = $this->getLiveChannels(MatchLive::kSportFootball);
        foreach ($footballLives as $football) {
            $this->saveLiveLog($football, MatchLive::kSportFootball, $openidArray, $admins);
        }

        $basketLives = $this->getLiveChannels(MatchLive::kSportBasketball);
        foreach ($basketLives as $basketLive) {
            $this->saveLiveLog($basketLive, MatchLive::kSportBasketball, $openidArray, $admins);
        }
    }

    /**
     * 保存日志
     * @param $match
     * @param $sport
     * @param $openidArray
     * @param $admins
     */
    protected function saveLiveLog($match, $sport, $openidArray, $admins) {
        //以线路id作为参考
        //id,ch_id,match_id,sport,match_status,hname,aname,match_time,ch_name,show,platform,is_private,content,live_status,created_at,updated_at
        //leqiuba.cc
        $ch_id = $match->ch_id;
        $content = $match->content;
        $show = $match->show;
        if (strstr($content,"leqiuba.cc")) {
            dump("乐球吧的外链 不记录");
            return;
        }

        //判断线路是否可以播放
        if ($show == MatchLiveChannel::kShow) {
            $flg = false;
            if (strlen($content) < 20) {
                $this->sendWxTip("电脑端直播未填写推流地址", $match, $openidArray);
            } else {
                $outPath = storage_path('app/public/cover/channel/' . $ch_id . '.jpg');
                self::spiderRtmpKeyFrame($content, $outPath);//取直播流的关键帧
            }
            if (isset($outPath)) {
                $key = "check_" . $ch_id;
                try {
                    $m = @filemtime($outPath);
                    $flg = $m + 30 > time();
                    if (!$flg) {
                        $this->sendWxTip("电脑端直播推流中断", $match, $openidArray);
                    } else {
                        Redis::del($key);
                    }
                } catch (\Exception $exception) {
                    //dump($exception);2次没有文件则发送消息
                    $times = Redis::get($key);
                    $times = empty($times) ? 0 : intval($times);
                    Redis::setEx($key, 120 * 60, $times + 1);
                    if ($times >= 2) {
                        $this->sendWxTip("电脑端直播推流中断", $match, $openidArray);
                    }
                }
            }
            try {
                $offKey = "check_off_key_" . $ch_id;
                $times = Redis::get($offKey);
                $times = empty($times) ? 0 : intval($times);
                if (!$flg) {
                    Redis::setEx($offKey, 59, $times + 1);
                    LiveChannelLog::saveLog($match, $sport, $times, false, $admins);
                } else {
                    Redis::del($offKey);
                    if ($times > 0) {
                        LiveChannelLog::saveLog($match, $sport, $times, true, $admins);
                    }
                }
            } catch (\Exception $exception) {
                dump($exception);
            }
        }
    }

    /**
     * 发送微信提醒
     * @param $first
     * @param $match
     * @param $openidArray
     */
    protected function sendWxTip($first, $match, array $openidArray) {
        $show = $match['show'];
        if ($show != MatchLiveChannel::kShow) {
            return;//不显示的线路不提醒
        }
        foreach ($openidArray as $openid) {
            $keyword1 = $match['hname']." VS ".$match['aname'];
            $keyword2 = "线路名称《" . $match['ch_name'] ."》";
            WeixinTampleMessage::liveTip($this->getWxApp(), $openid, $first, $keyword1, $keyword2);
        }
    }

    /**
     * 获取足球直播线路
     * @param $sport
     * @return array
     */
    protected function getLiveChannels($sport) {
        $liveTable = 'match_lives';
        $channelTable = 'match_live_channels';

        if ($sport == MatchLive::kSportBasketball) {
            $query = BasketMatch::query();
            $matchTable = "basket_matches";
        } else {
            $query = Match::query();
            $matchTable = "matches";
        }

        $channelSelect = "$channelTable.id as ch_id, $channelTable.name as ch_name, $channelTable.show,";
        $channelSelect .= "$channelTable.isPrivate, $channelTable.content, $channelTable.platform";

        $matchSelect = "$matchTable.id as match_id, $matchTable.hname, $matchTable.aname, $matchTable.time as match_time, $matchTable.status as match_status";
        $matchSelect .= ",$matchTable.win_lname";

        $query->join($liveTable, $liveTable .'.match_id', '=', $matchTable.'.id');//有直播线路的比赛
        $query->join($channelTable, $channelTable.'.live_id', '=', $liveTable.'.id');
        $query->where("$liveTable.sport", "=", $sport);
        $query->where($matchTable.".status",  ">", 0);//正在进行的比赛
        $query->where("$matchTable.time", '>', date('Y-m-d H:i', strtotime('-5 hours')));
        $query->where("$channelTable.isPrivate", "=", MatchLive::kIsPrivate);
        $query->where("$channelTable.platform", MatchLiveChannel::kPlatformPC);

        $query->select(DB::raw($matchSelect));
        $query->addSelect(DB::raw($channelSelect));

        return $query->get();
    }

    /**
     * 获取微信配置
     * @return Application
     */
    protected function getWxApp() {
        $app = $this->app;
        if (!isset($app)) {
            $app = new Application(config('wechat_lg'));
            $this->app = $app;
        }
        return $app;
    }


    public static function spiderRtmpKeyFrame($stream, $outPath) {
        $cmd = env("FFMPEG_PATH", "/usr/bin/") . "ffmpeg -i \"$stream\" -f image2 -y -vframes 1 -s 220*135 $outPath &";
        shell_exec($cmd);
    }

}