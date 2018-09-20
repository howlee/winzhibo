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

Route::group(['middleware' => 'admin_auth'], function () {
    Route::any("/", function () {
        return view('admin.index');
    });
});

Route::get('/noatt', function () {
    return view('admin.noatt');
});

/**
 * 用户相关
 */
Route::group(['namespace'=>'Role'], function () {
    Route::any("/login", "AuthController@index");
    Route::any("/logout", "AuthController@logout");

    Route::any("/accounts", "AuthController@accounts");//用户列表
    Route::any("/account/new", "AuthController@put");//新建用户
    Route::any("/account/update", "AuthController@put");//修改用户
    Route::any("/account/delete", "AuthController@delete");//删除用户
});

/**
 * 权限相关
 */
Route::group(['namespace'=>'Role', 'middleware' => 'admin_auth'], function () {
    Route::any("/roles", "RoleController@index");//角色列表
    Route::any("/roles/detail", "RoleController@detail");//新建、修改 角色页面
    Route::post("/roles/save", "RoleController@saveRole");//保存角色资料
    Route::post("/roles/del", "RoleController@delRole");//删除角色资料

    Route::any("/resources", "ResourceController@resources");//权限列表
    Route::post("/resources/save", 'ResourceController@saveRes');//保存权限
    Route::post("/resources/del", 'ResourceController@delRes');//删除权限
});


/**
 * 文章相关
 */
Route::group(['namespace'=>'Article', 'middleware' => 'admin_auth'], function () {
    Route::get('/article/list', 'ArticleController@articles');//文章列表
    Route::any("/article/new", "ArticleController@edit");//新建文章
    Route::post("/article/save", "ArticleController@save");//保存文章
    Route::any("/article/delete", "ArticleController@delete");//删除文章

    Route::any("/article/show", "ArticleController@show");//显示文章
    Route::any("/article/hide", "ArticleController@hide");//隐藏文章
    Route::any("/article/publish", "ArticleController@publish");//发布文章

    Route::any("/article/types", "ArticleTypeController@types");//文章分类列表
    Route::any("/article/types/save", "ArticleTypeController@saveType");//文章分类保存


    //抓取文章
    Route::get('/article/spiders', 'SpiderArticleController@articles');//列表
    Route::any('/article/spiders/detail', 'SpiderArticleController@detail');//新增
    Route::any('/article/spiders/update', 'SpiderArticleController@update');//修改
});


Route::group(['middleware' => 'admin_auth'], function () {
    Route::post("/upload/cover/", "UploadController@uploadCover");//上传封面
});
