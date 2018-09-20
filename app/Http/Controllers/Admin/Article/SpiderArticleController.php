<?php
/**
 * Created by PhpStorm.
 * User: bj
 * Date: 2018/9/3
 * Time: 22:42
 */

namespace App\Http\Controllers\Admin\Article;


use App\Http\Controllers\Admin\UploadTrait;
use App\Models\Local\PcArticle;
use App\Models\Local\PcArticleType;
use App\Models\Local\SpiderArticle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SpiderArticleController extends Controller
{

    use UploadTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articles(Request $request)
    {
        $query = SpiderArticle::query();
        $query->where('status','<>',SpiderArticle::kStatusInvalid);
        $query->orderBy('created_at', 'desc');
        $from = $request->input('from');
        $sport = $request->input('sport');
        if (!empty($from)){
            $query->where('from','=',$from);
        }
        if (!empty($sport)){
            $query->where('sport','=',$sport);
        }
        $articles = $query->paginate(40);
        $result['articles'] = $articles;
        return view('admin.article_spider.articles', $result);
    }

    /**
     * 文章编辑页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $id = $request->input("fid");
        $query = SpiderArticle::query();
        $query->find($id);
        $article = $query->get();
        if (count($article) > 0)
            $result['f_article'] = $article[0];
        else
            $result['f_article'] = null;
        if (isset($result['f_article']['aid'])) {
            $article = PcArticle::query()->find($result['f_article']['aid']);
            $result['article'] = $article;
        }
        $types = PcArticleType::allTypes();
        $result['types'] = $types;
        $result['authors'] = [];//$authors;
        return view('admin.article_spider.edit', $result);
    }

    /**
     * 修改文章
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $id = $request->input("id");
        if (!is_numeric($id)) {
            return response()->json(array('code'=>-1,'msg'=>'参数错误'));
        }
        $article = SpiderArticle::query()->find($id);
        if (!isset($article)) {
            return response()->json(array('code'=>-1,'msg'=>'无效的文章'));
        }
        $article->status = $request->input('status');
        if ($article->save()) {
            return response()->json(array('code'=>0,'msg'=>'成功'));
        }
    }
}