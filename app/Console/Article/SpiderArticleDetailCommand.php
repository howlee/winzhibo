<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/9/14
 * Time: 12:08
 */

namespace App\Console\Article;


use App\Models\Local\SpiderArticle;
use App\Models\Local\SpiderArticleDetail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use QL\QueryList;

class SpiderArticleDetailCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider_article_detail:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取文章内容';

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
    public function handle()
    {
        $this->zb8Detail();
    }

    protected function zb8Detail() {
        $query = SpiderArticle::query();
        $query->leftJoin('spider_article_details', 'spider_articles.id', '=', 'spider_article_details.id');
        $query->whereNull('spider_article_details.id');
        $query->where('spider_articles.spider_count', '<', 3);
        $query->take(15);
        $query->selectRaw('spider_articles.id, spider_articles.from_url, spider_articles.spider_count');
        $query->orderByDesc('id');
        $articles = $query->get();


        foreach ($articles as $article) {
            $id = $article->id;
            $url = $article->from_url;
            echo $url . "\n";
            if (!preg_match("/^http/", $url)) {
                $url = 'https:' .$url;
            }
            $article->spider_count = $article->spider_count + 1;
            $article->save();

            try {
                $query = QueryList::getInstance();
                $document = $query->get($url)->encoding('UTF-8');
                $content = $document->find("div.content");
                $detail = new SpiderArticleDetail();
                $detail->id = $id;
                $detail->content = $content->html();
                $detail->save();
            } catch (\Exception $exception) {
                Log::error($exception);
            }
        }
    }

}