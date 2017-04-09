<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    //
    public function index()
    {
        $data = Tag::get();
        return view("Admin.tag.index",compact('data'));
    }

    /**
     * method :get
     * 添加文章分类
     */
    public function create()
    {
        return view('Admin.tag.add');
    }

    /**
     * method : post
     * 添加分类标签提交
     */
    public function store()
    {
        if ($data = Input::except('_token')) {
            //验证规则
            $ruls = [
                'tag_name' => 'required',
            ];
            //提示信息
            $msg = [
                'tag_name.required' => '标签名必填',

            ];
            //获取验证对象
            $validate = Validator::make($data, $ruls, $msg);
            if ($validate->passes()) {
                //添加导数据库  用create 方法
                $res = Tag::create($data);
                if ($res) {
                    return redirect('Admin/tag');
                } else {
                    return back()->with('数据添加错误');
                }
            } else {
                return back()->withErrors($validate);
            }

        }
        return view('Admin.tag.add');
    }

    /**
     * 分类显示
     */
    public function show()
    {
        echo 'index';
    }

    /**
     * 分类编辑
     */
    public function edit($tag_id)
    {

        $data = Tag::where("tag_id", $tag_id)->first();
        return view('Admin.tag.edit', compact('data'));
    }

    /**
     * 分类修改
     */
    public function update($tag_id)
    {
        if ($data = Input::except('_token', '_method')) {
            $res = tag::where("tag_id", $tag_id)->update($data);
            if ($res) {
                return redirect('Admin/tag');
            } else {
                return back()->with('errors', '更新失败');
            }
        }
    }

    /**
     * 分类删除
     */
    public function destroy($tag_id)
    {
        $res = tag::where("tag_id", $tag_id)->delete();
        if ($res) {
            return 1;
        } else {
            return 0;
        }
    }
}
