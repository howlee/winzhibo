<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/9/13
 * Time: 17:03
 */

namespace App\Http\Controllers\Socket;


use App\Http\Controllers\Controller;
use App\Models\Local\SpiderArticle;
use Illuminate\Http\Request;
use QL\QueryList;

class TestController extends Controller
{

    public function index(Request $request) {

        $query = QueryList::getInstance();
        $document = $query->get("https://news.zhibo8.cc/zuqiu/")->encoding('UTF-8');
        $c_change = $document->find("div.v_change");
        $items = $c_change->find("div.content li a")->map(function ($item) {
            return $item;
        });
//        $srcs = $as->attrs("href");
        $today = date('Y-m-d');
        foreach ($items as $item) {
            $href = $item->href;
            $title = $item->html();
            if (preg_match("/\/$today\//", $href)) {
                dump($title . ' ' . $href);
                SpiderArticle::saveSpiderArticle($href, $title);
            }
        }
    }

}