<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use App\Http\Model\Fgheader;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigheaderController extends CommonController
{
    public function index()
    {
        $res = Fgheader::paginate(5);
        foreach ($res as $key => $r){
            $array =  explode("\r\n",$r->h_motto);
            $res[$key]->h_motto = $array;
        }
        return view('Admin.fgheader.index', compact('res'));
    }

    public function create()
    {
        return view('Admin.fgheader.add');
    }

    /**
     * method : post
     * 添加分类提交
     */
    public function store()
    {
        if ($data = Input::except('_token')) {
            /// date("Y-m-d",time());
            $data['h_time'] = date("Y-m-d", time());
            //验证规则
            $ruls = [
                'h_url' => 'required',
                'h_motto' => 'required',
            ];
            //提示信息
            $msg = [
                'h_url.required' => '图片必须上传',
                'h_motto.required' => '格言必填',
            ];
            //获取验证对象
            $validate = Validator::make($data, $ruls, $msg);
            if ($validate->passes()) {
                //添加导数据库  用create 方法
                $res = Fgheader::create($data);
                if ($res) {
                    return redirect('Admin/fgheader');
                } else {
                    return back()->with('数据添加错误');
                }
            } else {
                return back()->withErrors($validate);
            }

        }
        return view('Admin.fgheader.index');
    }

    /**
     * 修改配置项
     */
    public function edit($h_id)
    {
        $data = Fgheader::find($h_id);
        return view("Admin.fgheader.edit", compact("data"));
    }

    public function update($h_id)
    {
        if ($data = Input::except('_token', '_method')) {
            $res = Fgheader::where("h_id", $h_id)->update($data);
            if ($res) {
                return redirect('Admin/fgheader');
            } else {
                return back()->with('errors', '更新失败');
            }
        }
    }
    /**
     * 删除配置项
     */
    public function destroy($h_id)
    {
        $h_url = Fgheader::select("h_url")->find($h_id);
        $url = str_replace("\\","/",base_path())."/".$h_url->h_url;
        $res =  null;
        if(file_exists($url)){
             unlink($url);
            $res = Fgheader::destroy($h_id);
        }
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    /**
     * 设置主页的显示头模板
     */
    public function is_show()
    {
        $data = Input::get("h_id");
        $res  =Fgheader::where("h_is_show",1)->select("h_id")->first();

        if(!empty($res)){
            Fgheader::where("h_id",$res->h_id)->update(["h_is_show"=>0]);
        }
       $res =  Fgheader::where("h_id",$data)->update(["h_is_show"=>1]);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
}
