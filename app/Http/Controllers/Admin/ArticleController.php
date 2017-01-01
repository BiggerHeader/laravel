<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Cate;
use App\Http\Model\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    /**
     * 文章列表
     */
    public function index()
    {
        $art = Article::orderBy('cate_id','desc')->paginate(5);
        return view('Admin.article.index',compact('art'));
    }

    /**
     * 显示文章 get
     */
    public function create()
    {
        $cate = Cate::get();
        $data = Cate::notLimit($cate);
        $tags = Tag::get();
        return view('Admin.article.add', compact('data',"tags"));
    }

    /**
     * 添加文章 post
     */
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();
        //验证规则
        $ruls = [
            'art_title' => 'required',
            'cate_id' => 'required'
        ];
        //提示信息
        $msg = [
            'art_title.required' => '标题必填',
            'cate_id.required' => '文章分类必填'
        ];

        //获取验证对象
        $validate = Validator::make($input, $ruls, $msg);
        if ($validate->passes()) {
          //  dd($input);
            $input['art_tags']  = ",".implode(",",$input['art_tags']).",";
            //添加导数据库  用create 方法
            $res = Article::create($input);
            if ($res) {
                return redirect('admin/article');
            } else {
                return back()->with('数据添加错误');
            }
        } else {
            return back()->withErrors($validate);
        }
    }

    /**
     * 文章编辑
     */
    public function edit($art_id)
    {
        $field = Article::find($art_id);
        $field->art_tags = explode("," , trim($field->art_tags,","));
        $data= Cate::notLimit(Cate::get());
        //获取所有的标签
        $tags = Tag::get();
        return view('Admin.article.edit',compact('field','data',"tags"));
    }
    /**
     * 分类修改
     */
    public function update($art_id)
    {
        if($data = Input::except('_token','_method')){
            $data['art_tags']  = ",".implode(",",$data['art_tags']).",";
            $res = Article::where("art_id", $art_id)->update($data);
            if($res){
                return  redirect('admin/article');
            }else{
                return back()->with('errors','更新失败');
            }
        }
    }

    /**
     * 文章删除
     */
    public function destroy($art_id)
    {
        $res = Article::where("art_id",$art_id)->delete();
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
}
