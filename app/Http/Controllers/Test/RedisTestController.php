<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/12/5
 * Time: 16:04
 */

namespace App\Http\Controllers\Test;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redis;

class RedisTestController extends Controller
{

    const REDIS_KEY = "RedisTestController_KEY_";

    public function redisLPush(Request $request) {
        $num = $request->input('num');
        if (!is_numeric($num) || $num < 0) {
            $num = 10;
        }
        $array = [];
        for ($index = 0; $index < $num; $index++) {
            $array[] = $index;
        }
        Redis::lpush(self::REDIS_KEY, $array);
    }

    public function redisRpop(Request $request) {
        $num = Redis::rpop(self::REDIS_KEY);
        $len = Redis::llen(self::REDIS_KEY);
        echo "len = $len ， pop = ". $num;
    }

}