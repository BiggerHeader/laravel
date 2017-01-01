@extends('layout.layout1')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{'admin/info'}}">首页</a> &raquo; 添加导航栏
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>新增文章</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/nav/'.$field->nav_id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put"/>
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>导航栏名称：</th>
                    <td>
                        <input type="text" class="lg" name="nav_name" value="{{$field->nav_name}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>导航栏标题：</th>
                    <td>
                        <input type="text" class="lg" name="nav_title" value="{{$field->nav_title}}">
                    </td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>导航栏地址：</th>
                    <td>
                        <input type="text" class="lg" name="nav_url" value="{{$field->nav_url}}">
                    </td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>排序：</th>
                    <td>
                        <input type="text" class="lg" name="nav_order" value="{{$field->nav_order}}">
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection