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
/**
 * 直播入口
 */
Route::group(["namespace" => 'Live'], function () {
    Route::get("/", "LiveController@index");//直播列表
    Route::get("/detail/{sport}_{mid}.html", "LiveController@detail");//直播终端


    Route::get("/video/", "LiveController@videos");
    Route::get("/video/index{page}.html", "LiveController@videosJson");
    Route::get("/video/{id}.html", "LiveController@video");
});


Route::get("/{sportEn}/{mid}.html", "Live\\LiveController@detailBy");