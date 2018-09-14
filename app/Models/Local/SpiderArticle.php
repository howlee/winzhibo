<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/9/14
 * Time: 11:38
 */

namespace App\Models\Local;


use Illuminate\Database\Eloquent\Model;

class SpiderArticle extends Model
{
    public $connection = "qt";

    public static function saveSpiderArticle($url, $title) {
        if (empty($url) || empty($title)) {
            return;
        }
        $query = self::query();
        $query->where('from_url', $url);
        $sa = $query->first();
        if (isset($sa)) {
            return;
        }
        $sa = new SpiderArticle();
        $sa->title = $title;
        $sa->from_url = $url;
        $sa->save();
    }

}