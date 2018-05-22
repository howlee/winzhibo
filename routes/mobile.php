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

Route::group(["namespace" => 'Live'], function () {

});

/**
 * 直播入口
 */
Route::group(["namespace" => 'Live'], function () {
    Route::any("/", function (){
        return redirect('/m/lives.html');
    });
    Route::any("/football.html", function (){
        return redirect('/m/lives.html');
    });
    Route::any("/basketball.html", function (){
        return redirect('/m/lives.html');
    });
    Route::any("/other.html", function (){
        return redirect('/m/lives.html');
    });
    Route::get("/lives.html", "LiveController@lives");//直播列表

    Route::get("/live/football/{id}.html", "LiveController@footballdetail");//直播终端
    Route::get("/live/basketball/{id}.html", "LiveController@basketballDetail");//直播终端
    Route::get("/live/other/{id}.html", "LiveController@otherDetail");//直播终端

    Route::get("/live/subject/videos/{type}/{page}.html", 'LiveController@subjectVideos');//录像列表
    Route::get("/live/subject/video/{first}/{second}/{vid}.html", 'LiveController@subjectVideoDetail');//录像终端
    Route::get("/lives/data/refresh.json", "LiveController@match_live");//比赛比分数据
});
