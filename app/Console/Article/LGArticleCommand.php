<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2019/8/30
 * Time: 11:47
 */

namespace App\Console\Article;


use App\Http\Controllers\Controller;
use App\Models\Local\PcArticle;
use App\Models\Local\PcArticleDetail;
use http\Url;
use Illuminate\Console\Command;
use QL\QueryList;

class LGArticleCommand extends Command
{

    protected $signature = "spider_tuijian:run {--page=}";
    protected $description = "抓取料狗推荐文章";

    public function handle() {
        //https://www.liaogou168.com/news/lottery_recommend/   分页：index2.html
        $page = $this->option("page");
        $page = empty($page) ? 1 : $page;
        $url = "http://cms.liaogou168.com/api/article/page?key=8uikmOP0__$$&name_en=lottery_recommend&page=" . $page;
        $u = parse_url($url);
        $host = isset($u['host']) ? $u['host'] : "";
        $json = Controller::execUrl($url);
        $articles = json_decode($json, true);
        if (!isset($articles)) {
            echo "没有数据";
            return;
        }
        PcArticle::query()->where("id", 100)->first();
        $data = $articles["data"];
        foreach ($data as $item) {
            $this->saveArticle($item, $host);
        }
    }

    protected function saveArticle(array $item, $host) {
        $id = $item["id"];
        $author = $item["author"];
        $title = $item["title"];
        $cover = $item["cover"];
        $digest = $item["digest"];
        $content = $item["content"];
        $labels = $item["labels"];
        $resource = $item["resource"];
        $publish_at = $item["publish_at"];

        $article = PcArticle::query()->where("spider", "=", $host)->where("spider_id", $id)->first();
        if (!isset($article)) {
            $article = new PcArticle();
            $article->spider = $host;
            $article->spider_id = $id;
        }
        $article->type = PcArticle::JC_TYPE;
        $article->status = PcArticle::kStatusPublish;
        $article->author = $author;
        $article->title = $title;
        $article->cover = $cover;
        $article->resource = $resource;
        $article->digest = $digest;
        $article->labels = $labels;
        $article->publish_at = $publish_at;

        $article->save();

        $aid = $article->id;
        $detail = PcArticleDetail::query()->find($aid);
        if (!isset($detail)) {
            $detail = new PcArticleDetail();
            $detail->id = $aid;
        }
        $detail->content = $content;
        $detail->save();
    }

}