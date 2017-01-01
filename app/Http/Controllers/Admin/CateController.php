<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Model\Cate;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CateController extends CommonController
{
    /**
     * 分类主页
     */
    public function index()
    {
        $objCate = new   Cate();
        $cate = $objCate->orderby('cate_order', 'asc')->get();
        $data = Cate::notLimit($cate);
        return view('Admin.cate.index')->with('data', $data);
    }

    /**
     * 修改排序
     */
    public function changeorder()
    {
        if ($data = Input::all()) {
            $isExist = Cate::find($data['cate_id']);
            if ($isExist) {
                $isExist->cate_order = $data['val'];
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
     * 添加文章分类
     */
    public function create()
    {
        $data= Cate::where("cate_pid" , 0 )->get();
        return view('Admin.cate.add',compact('data'));
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
                'cate_name'=>'required',
                'cate_title'=>'required',
                'cate_order'=>'numeric'
            ];
            //提示信息
            $msg =[
                'cate_name.required'=>'分类名必填',
                'cate_title.required'=>'标题必填',
                'cate_order.numeric'=>'排序填数字'
            ];
            //获取验证对象
            $validate =  Validator::make($data,$ruls,$msg);
            if($validate->passes()){
               //添加导数据库  用create 方法
               $res =  Cate::create($data);
               if($res){
                   return redirect('admin/cate');
               }else{
                    return back()->with('数据添加错误');
               }
            }else{
                return back()->withErrors($validate);
            }

        }
        return view('Admin.cate.add');
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
    public function edit($cate_id)
    {
        $field = Cate::find($cate_id);
        $data= Cate::where("cate_pid" , 0 )->get();
        return view('Admin.cate.edit',compact('field','data'));
    }
    /**
     * 分类修改
     */
        public function update($cate_id)
    {
        if($data = Input::except('_token','_method')){
            //判断自己不能为自己的父节点
            if($cate_id == $data['cate_pid']){
                return back()->with('errors','请选择合适的父节点');
            }
            $res = Cate::where("cate_id", $cate_id)->update($data);
            if($res){
                return  redirect('admin/cate');
            }else{
                return back()->with('errors','更新失败');
            }
        }
    }

    /**
     * 分类删除
     */
    public function destroy($cate_id)
    {
        $res = Cate::where("cate_id",$cate_id)->delete();
        if($res){
            //吧子分类变成顶级分类
            Cate::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
            return 1;
        }else{
            return 0;
        }
    }
}
