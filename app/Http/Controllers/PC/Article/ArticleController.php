<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/9/20
 * Time: 16:12
 */

namespace App\Http\Controllers\PC\Article;


use App\Http\Controllers\Controller;
use App\Http\Controllers\PC\CommonTool;
use App\Http\Controllers\PC\Live\LiveController;
use App\Models\Local\PcArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    const PAGE_SIZE = 23;


    public function news(Request $request, $page = 1) {
        $query = PcArticle::query()->where('status', PcArticle::kStatusPublish)->orderByDesc('publish_at');
        $articles = $query->paginate(self::PAGE_SIZE, ['*'], '', $page);

        $result["articles"] = $articles;
        $result['matches'] = LiveController::getLiveMatches();
        $result['check'] = "news";
        return view('pc.article.articles', $result);
    }


    public function detail(Request $request, $id) {
        $article = PcArticle::query()->find($id);
        if (!isset($article)) {
            return abort(404);
        }
        return $this->detailHtml($article);
    }

    public function detailHtml(PcArticle $article) {
        $result['article'] = $article;
        return view('pc.article.detail', $result);
    }

    public function generateHtml($id) {
        $article = PcArticle::query()->find($id);
        if (!isset($article)) {
            return;
        }
        $html = $this->detailHtml($article);
        if (!empty($html)) {
            $path = CommonTool::newsDetailPath($id);
            Storage::disk('public')->put($path, $html);

            $url = CommonTool::newsDetailLink($id);
            $article->path = $path;
            $article->url = $url;
            $article->disks = "public";
            $article->save();
        }
    }

}