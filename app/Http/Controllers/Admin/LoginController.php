<?php

namespace App\Http\Controllers\Admin;
require_once '/myself/Code.class.php';
use App\Http\Model\Admin;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class LoginController extends CommonController
{
    public function login()
    {

        //验证登录
        if ($data = Input::all()) {
            session_start();
            if (strtoupper($data['code']) != $_SESSION['code']) {
                //返回之前的页面
                return back()->with('msg', '验证码错误');
            }
            $check = Admin::first();
            if ($check->user_name != $data['user_name'] || Crypt::decrypt($check->user_pass) != $data['user_pass']) {
                return back()->with('msg', '密码或用户名错误');
            }
            //保存数据
            session(['user'=>$check]);
            ///   +++++++++++++++++++++++++++++
           return redirect('admin/index');
        } else {
            return view('admin/login');
        }
    }

    /**
     * 验证码
     */
    public function verify()
    {
        $verify = new \Code();
        $verify->make();

    }

    /**
     * 加密
     */
    public function crypt()
    {
        
       // echo  Crypt::decrypt("OEZFNSBFNjg4IEExQjIgQkFFNCBFN0JBIEE2QkEgOEZFNSBFOEFBCkJEODMgOUNFNSBFNUE4IDlEQUYgQUVFNSBFNUE0IEE2QUQgQjlFNApFNEEwIDg2QkEgM0EyMCAwMDI5");exit();
        //echo Crypt::encrypt('');
    }
    /**
     * 退出
     */
    public  function  logout(){
        session(['user'=>null]);
       return  redirect('admin/login');

    }
    /*
     * 修改密码
     */
    /**
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function changepass()
    {
        if($data = Input::all()){
        //验证规则
        $ruls=[
            'password'=>'required|between:3,20|confirmed'
        ];
        //提示信息
        $msg =[
            'password.required'=>'新密码不能为空',
            'password.between'=>'新密必须在3到20位',
            'password.confirmed'=>'两次密码不一致',
        ];
        //获取验证对象
        $validate =  Validator::make($data,$ruls,$msg);
            if($validate->passes()){
                $info = Admin::first();
                if($data['password_o'] != Crypt::decrypt($info->user_pass) ){
                    return back()->with('errors','原密码错误');
                }
                //进行修改 密码
                $info->user_pass = Crypt::encrypt($data['password']);
                $info->update();

                return back()->with('errors','密码修改成功！');
            }else{
                return back()->withErrors($validate);
            }

        }
        return view('admin.chpass');
    }
}
