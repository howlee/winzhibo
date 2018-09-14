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
        $document = $query->get("https://news.zhibo8.cc/zuqiu/2018-09-14/5b9b2bac87c6f.htm")->encoding('UTF-8');
        $content = $document->find("div.content");

    }

}