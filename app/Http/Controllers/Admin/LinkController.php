<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Link;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
class LinkController extends Controller
{
    public function index()
    {
        $data = Link::orderBy('link_order','asc')->get();
        return view('Admin.Links.index',compact('data'));
    }
    /**
     *排序友情链接
     */
    public function linkorder()
    {
        if ($data = Input::all()) {
            $isExist = Link::find($data['link_id']);
            if ($isExist) {
                $isExist->link_order = $data['val'];
                $res = $isExist->update();
                if ($res) {
                    return 1;
                } else {
                    return 0;
                }
            }
        }
        return 0;
        
    }
    /**
     * method :get
     * 添加友情链接页面显示
     */
    public function create()
    {
        return view('Admin.Links.add');
    }
    /**
     * method : post
     * 添加分类提交
     */
    public function store()
    {
        if($data = Input::except('_token')){
            //验证规则
            $ruls=[
                'link_url'=>'required',
                'link_title'=>'required',
                'link_order'=>'numeric'
            ];
            //提示信息
            $msg =[
                'link_name.required'=>'地址必填',
                'link_title.required'=>'标题必填',
                'link_order.numeric'=>'排序填数字'
            ];
            //获取验证对象
            $validate =  Validator::make($data,$ruls,$msg);
            if($validate->passes()){
                //添加导数据库  用create 方法
                $res =  Link::create($data);
                if($res){
                    return redirect('admin/link');
                }else{
                    return back()->with('数据添加错误');
                }
            }else{
                return back()->withErrors($validate);
            }

        }
        return view('Admin.link.add');
    }
    /**
     * 链接删除
     */
    public function destroy($link_id)
    {
        $res = Link::where("link_id",$link_id)->delete();
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    /**
     * 编辑
     */
    public function edit($link_id)
    {
        $field = Link::find($link_id);
        return view('Admin.Links.edit',compact('field'));
    }
    /**
     * 更改
     */
    public function update($link_id)
    {
        if($data = Input::except('_token','_method')){
            $res = Link::where("link_id", $link_id)->update($data);
            if($res){
                return  redirect('admin/link');
            }else{
                return back()->with('errors','更新失败');
            }
        }
    }
}
