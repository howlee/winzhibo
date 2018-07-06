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
    Route::get("/index.html", "LiveController@index");//直播列表
    Route::get("/videos.html", "LiveController@videos");
});
