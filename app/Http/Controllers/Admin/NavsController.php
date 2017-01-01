<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\nav;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
class NavsController extends Controller
{
    public function index()
    {
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('Admin.navs.index',compact('data'));
    }
    /**
     *排序友情链接
     */
    public function navorder()
    {
        if ($data = Input::all()) {
            $isExist = Navs::find($data['nav_id']);
            if ($isExist) {
                $isExist->nav_order = $data['val'];
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
        return view('Admin.Navs.add');
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
                'nav_name'=>'required',
                'nav_url'=>'required',
                'nav_title'=>'required',
                'nav_order'=>'numeric'
            ];
            //提示信息
            $msg =[
                'nav_name.required'=>'名称必填',
                'nav_title.required'=>'标题必填',
                'nav_order.numeric'=>'排序填数字',
                'nav_url.required'=>'地址必填',
            ];
            //获取验证对象
            $validate =  Validator::make($data,$ruls,$msg);
            if($validate->passes()){
                //添加导数据库  用create 方法
                $res =  Navs::create($data);
                if($res){
                    return redirect('admin/nav');
                }else{
                    return back()->with('数据添加错误');
                }
            }else{
                return back()->withErrors($validate);
            }

        }
        return view('Admin.Navs.add');
    }
    /**
     * 链接删除
     */
    public function destroy($nav_id)
    {
        $res = Navs::where("nav_id",$nav_id)->delete();
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    /**
     * 编辑
     */
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
        return view('Admin.Navs.edit',compact('field'));
    }
    /**
     * 更改
     */
    public function update($nav_id)
    {
        if($data = Input::except('_token','_method')){
            $res = Navs::where("nav_id", $nav_id)->update($data);
            if($res){
                return  redirect('admin/nav');
            }else{
                return back()->with('errors','更新失败');
            }
        }
    }
}
