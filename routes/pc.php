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
    Route::any("/", function (){
        return redirect('/index.html');
    });

    Route::get('/index.html',"LiveController@lives");//首页
    Route::get('/live/football.html',"LiveController@footballLives");//足球比赛直播
    Route::get('/live/basketball.html',"LiveController@basketballLives");//篮球比赛直播

    Route::get('/live/videos', 'LiveController@videos');
    Route::get('/live/videos/index{page}.html', 'LiveController@videos');

    Route::get('/live/{type}/{mid}.html',"LiveController@detail");//足球直播页

    Route::get("/socket/index.html", function () {
        return view('socket.index');
    });

    //============================================================================================================================//
    //直播相关静态化
    Route::get('/live/player-json/{id}', 'LiveController@staticLiveUrl');//静态化 线路json
    Route::get('/live/cache/live-json', 'LiveController@allLiveJsonStatic');//直播赛事接口静态化
    Route::get('/live/cache/match/detail', 'LiveController@staticLiveDetail');//静态化当前所有比赛的直播终端
    Route::get('/live/cache/player/json', 'LiveController@staticPlayerJson');//静态化所有当前正在比赛的线路
    Route::get('/live/cache/flush', 'LiveController@flushVideoCache');//刷新缓存文件
    Route::get('/live/cache/match/detail_id/{id}/{sport}', 'LiveController@staticLiveDetailById');//静态化wap/pc终端/线路

});