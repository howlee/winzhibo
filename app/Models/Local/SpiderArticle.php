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
    const kStatusValid = 1, kStatusInvalid = -1;

    public function detail() {
        return $this->hasOne(SpiderArticleDetail::class, 'id', 'id');
    }

    public function getContent() {
        if (isset($this->detail)) {
            return $this->detail->content;
        }
        return "";
    }

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