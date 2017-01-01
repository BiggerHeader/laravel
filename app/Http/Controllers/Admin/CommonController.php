<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    /**
     * 上传图片
     */
    public function upload()
    {
       $file = Input::file('Filedata');
       //判断是否是有效文件
        if($file->isValid()){
            //获取路径
            $path = $file->getRealPath();
            //获取扩展名
            $extension = $file->getClientOriginalExtension();
            $newName = date('YmdHis').rand(100,1000).'.'.$extension;
            //移动  返回的是一个路径
            $path = $file->move(base_path().'/uploads',$newName);
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }
}
