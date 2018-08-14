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
}