<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::post('/',  [
     'uses' => 'TestController@showPost'
]);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web']], function () {
    Route::get('admin/verify','Admin\LoginController@verify');
   /// 密码的生成函数
    Route::any('admin/crypt','Admin\LoginController@crypt');
});
//前台路由
Route::group(['middleware' => ['web']], function () {
    Route::get('/','Home\IndexController@index');
    Route::get('/cate/{cate_id}','Home\IndexController@cate');
    Route::get('/detail/{art_id}','Home\IndexController@detail');
    //查看类似的标签
    Route::get('/tag/{tag_id}','Home\IndexController@sometag');
    //提交留言
    Route::post('/message','Home\IndexController@message');
    //顶操作
    Route::post('/up','Home\IndexController@up');
});

// 后台  中间件 'admin.login'
Route::group(['middleware' => ['web'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::any('login','LoginController@login');
    Route::get('logout','LoginController@logout');
    Route::any('changepass','LoginController@changepass');

    Route::any('index','IndexController@index');
    Route::any('info','IndexController@info');
    Route::any('changeorder','CateController@changeorder');

    Route::resource('cate', 'CateController');
    Route::resource('article', 'ArticleController');

    //配置上传图片
    Route::any('upload','CommonController@upload');
    //友情链接
    Route::resource('link','LinkController');
    Route::post('linkorder','LinkController@linkorder');

    //导航路由
    Route::resource('nav','NavsController');
    Route::post('navorder','NavsController@navorder');
    //标签
    Route::resource('tag','TagsController');

    //网站的配置
    Route::resource('config','ConfigController');
    Route::post('cfgorder','ConfigController@cfgorder');
    Route::post('cfgcontent','ConfigController@cfgcontent');
    Route::get('becfgfile','ConfigController@becfgfile');

    //网站的头配置
    Route::resource('fgheader','ConfigheaderController');
    Route::post('is_show','ConfigheaderController@is_show');

    //配置上传图片
    Route::any('upload','CommonController@upload');
});

