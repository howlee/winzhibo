<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/8/10
 * Time: 16:44
 */

namespace App\Models\Aikq;


use Illuminate\Database\Eloquent\Model;

class LiveChannelLog extends Model
{
    public $connection = "akq";
    const kLiveStatusValid = 1, kLiveStatusInvalid = 0;
    //爱看球直播比赛线路日志记录


    /**
     * 断流开始时间，断流次数，恢复时间。
     * @param $match
     * @param $sport
     * @param $times
     * @param $resume
     * @param $admins
     */
    public static function saveLog($match, $sport, $times, $resume, $admins) {
        $ch_id = $match->ch_id;
        $sign = '';
        foreach ($admins as $admin) {
            $sign .= empty($sign) ? $admin->name : (','.$admin->name);
        }
        if ($times == 1 || $resume) {//第一次断流 或者 恢复流则新建一个
            $log = new LiveChannelLog();//恢复时新建一个记录
            $log->ch_id = $ch_id;
            $log->match_id = $match->match_id;
            $log->sport = $sport;
            $log->match_status = $match->match_status;
            $log->lname = $match->win_lname;
            $log->hname = $match->hname;
            $log->aname = $match->aname;
            $log->match_time = $match->match_time;
            $log->ch_name = $match->ch_name;
            $log->times = $times;
            $log->platform = $match->platform;
            $log->content = $match->content;
            $log->live_status = $resume ? self::kLiveStatusValid : self::kLiveStatusInvalid;
        } else {//增加断流时间
            $query = self::query()->where('ch_id', $ch_id)->where('status', self::kLiveStatusInvalid);
            $query->orderByDesc('created_at');
            $log = $query->first();
            $log->times = $times;
        }
        $log->signs = $sign;
        $log->save();
    }

}