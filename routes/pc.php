<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//直播相关
Route::group(["namespace" => 'Live'], function () {
    Route::any("/", "LiveController@lives");

    Route::get('/zuqiu/',"LiveController@footballLives");//足球比赛直播
    Route::get('/nba/',"LiveController@basketballLives");//篮球比赛直播
//    Route::get('/live/player/{sport}_{mid}.html', 'LiveController@player');//播放器终端

    Route::get('/video/', 'LiveController@videos');
    Route::get('/video/index{page}.html', 'LiveController@videos');
    Route::get('/video/{id}.html', 'LiveController@videoDetail');

    //Route::get('/live/{type}/{mid}.html',"LiveController@detail");//足球直播页

    //============================================================================================================================//
    //直播相关静态化
//    Route::get('/live/player-json/{id}', 'LiveController@staticLiveUrl');//静态化 线路json
//    Route::get('/live/cache/live-json', 'LiveController@allLiveJsonStatic');//直播赛事接口静态化
//    Route::get('/live/cache/match/detail', 'LiveController@staticLiveDetail');//静态化当前所有比赛的直播终端
//    Route::get('/live/cache/player/json', 'LiveController@staticPlayerJson');//静态化所有当前正在比赛的线路
//    Route::get('/live/cache/flush', 'LiveController@flushVideoCache');//刷新缓存文件
//    Route::get('/live/cache/match/detail_id/{id}/{sport}', 'LiveController@staticLiveDetailById');//静态化wap/pc终端/线路

});

Route::group(["namespace" => 'Article'], function () {
    Route::get("/news", "ArticleController@news");
    Route::get("/news/index{page}.html", "ArticleController@news");
    Route::get("/news/{id}.html", "ArticleController@detail");

    Route::get("/tuijian", "ArticleController@tuijian");
    Route::get("/tuijian/index{page}.html", "ArticleController@tuijian");
    Route::get("/tuijian/{id}.html", "ArticleController@detail");

    //Route::get("/static/news/{id}", "ArticleController@generateHtml");
});

Route::get('/{sportEn}/{id}.html', "Live\\LiveController@detailBy");//直播终端