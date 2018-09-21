<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/9/13
 * Time: 18:53
 */

namespace App\Models\Local;


use Illuminate\Database\Eloquent\Model;

class PcArticle extends Model
{
    public $connection = "qt";

    const kStatusPublish = 1;

    public function detail() {
        return $this->hasOne(PcArticleDetail::class, 'id', 'id');
    }

    public function getContent() {
        if (isset($this->detail)) {
            return $this->detail->content;
        }
        return "";
    }

    public function statusCN()
    {
        switch ($this->status) {
            case 0: {
                return "未发布";
            }
            case 1: {
                return "已发布";
            }
        }
    }

    public function getUrl() {
        return $this->url;
    }

    public static function publishArticles($count = 15) {
        $query = self::query();
        $query->where('status', self::kStatusPublish);
        $query->orderByDesc('publish_at');
        $query->take($count);
        return $query->get();
    }

}