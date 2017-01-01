<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Fgheader;
use App\Http\Model\Link;
use App\Http\Model\Navs;
use App\Http\Model\Tag;
use Illuminate\Contracts\View\Facade;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $navs = Navs::all();
        //获取最新发布文章
        $news = Article::orderBy('art_time', 'desc')->take(8)->get();
        //获取友情链接
        $links = Link::orderBy('link_order', 'asc')->paginate(5);
        //获取点击量最高的文章
        $hot = Article::orderBy('art_view', 'desc')->take(6)->get();
        //获取标签
        $showtag = Tag::get();
        //设置头信息
        $header = Fgheader::where("h_is_show", 1)->first();
        $array = explode("\r\n", $header['h_motto']);
        $header["h_motto"] = $array;
        View::share(['navs' => $navs, 'news' => $news, 'links' => $links, 'hot' => $hot, 'showtag' => $showtag, "header" => $header]);
    }
}
