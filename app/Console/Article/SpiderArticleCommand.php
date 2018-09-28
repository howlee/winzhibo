<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/9/14
 * Time: 12:08
 */

namespace App\Console\Article;


use App\Models\Local\SpiderArticle;
use Illuminate\Console\Command;
use QL\QueryList;

class SpiderArticleCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider_article:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取直播吧足球新闻首页的链接、标题';

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
        $this->spiderZB8("https://news.zhibo8.cc/zuqiu/");
        $this->spiderZB8("https://news.zhibo8.cc/nba/");
    }

    protected function spiderZB8($url) {
        $query = QueryList::getInstance();
        $document = $query->get($url)->encoding('UTF-8');
        $c_change = $document->find("div.v_change");
        $items = $c_change->find("div.content li a")->map(function ($item) {
            return $item;
        });

        $today = date('Y-m-d');
        foreach ($items as $item) {
            $href = $item->href;
            $title = $item->html();
            if (preg_match("/\/$today\//", $href)) {
                SpiderArticle::saveSpiderArticle($href, $title);
            }
        }
    }

}