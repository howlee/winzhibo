<?php
/**
 * Created by PhpStorm.
 * User: BJ
 * Date: 2018/3/5
 * Time: 上午11:06
 */

namespace App\Http\Controllers\PC;

use Illuminate\Support\Facades\Storage;

class CommonTool
{
    //比赛类型
    const kSportFootball = 1, kSportBasketball = 2;//1：足球，2：篮球，其他待添加。

    public static function subjectLink($id, $type) {
        $id = $id . '';
        $len = strlen($id);
        if ($len < 4) {
            return "";
        }
        $first = substr($id, 0, 2);
        $second = substr($id, 2, 3);
        $url = '/live/subject/' . $type . '/' . $first . '/' . $second . '/' . $id . '.html';
        return $url;
    }

    public static function newsDetailPath($id) {
        $id = $id . '';
        $tmpId = $id . '';
        while (strlen($tmpId) < 4) {
            $tmpId = "0" . $tmpId;
        }
        $first = substr($tmpId, 0, 2);
        $second = substr($tmpId, 2, 3);

        return "/news/$first/$second/$id.html";
    }

    public static function newsDetailLink($id) {
        return "/news/$id.html";
    }

}