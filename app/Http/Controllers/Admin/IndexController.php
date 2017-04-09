<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin;
class IndexController extends CommonController
{
    public function index(){

        return view('Admin/index');
        //触发事件

    }


    public function info()
    {
        return view('Admin/info');
    }
}
