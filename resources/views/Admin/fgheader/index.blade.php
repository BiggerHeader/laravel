@extends('layout.layoutcate')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 网站配置
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    {{--<div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/fgheader/')}}" method="get">
        {{csrf_field()}}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/fgheader/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/fgheader')}}"><i class="fa fa-recycle"></i>查看配置项</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->

        </div>

        <div class="result_wrap">
            <div class="result_title">
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
            <div class="result_content" style="border: 2px red solid">
                <table class="list_tab">
                <form action="{{url('admin/fgheader')}}" method="post">
                    @foreach($res as $v)
                        <tr class="tc">
                            <td>
                        <div class="wrapall"
                             style="border: double grey 1px;width:800px;height: 200px ;position: relative;display: block;font-family: 'Monaco', 'Lucida Console', monospace;font-size: medium;">
                            <input type="radio" name="h_is_show" size="20" value="{{$v->h_id}}" onclick="is_show({{$v->h_id}})"
                                   @if($v->h_is_show)
                                           checked
                                   @endif
                                   style="position: absolute;right: 2px;top: 5px;z-index: 10;">
                            <img src="{{url('/').'/'.$v->h_url}}"
                                 style="width: inherit;height: inherit;position: relative;display: block;">
                            <div class="content"
                                 style="background-color:rgba(25,35,24,0.3) ;position: absolute;display:none;width: inherit;height: inherit;top: 0;">
                                <span>作者：<b>{{$v->h_author}}</b></span>
                                <div style="padding-left: 15px ;padding-top: 20px;">
                                    @foreach($v->h_motto as $m)
                                        <p>{{$m}}</p>
                                    @endforeach
                                    <small style="position:absolute;bottom:0px;right: 5px">{{$v->h_time}}</small>
                                </div>
                            </div>
                        </div>
                            </td>
                            <td>
                                <a href="{{url('admin/fgheader/'.$v->h_id.'/edit')}}">修改</a> &nbsp;&nbsp;
                                <a href="javascript:(0)" onclick="destroy({{$v->h_id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </form>
                </table>
                <div class="page_list">

                </div>
                <div class="ad" style="clear: both"></div>
                <div class=></div>
                <div class="btn_group">
                    <input type="button" value="选定">
                    <input type="submit" class="back" onclick="changecfg()" value="修改配置">
                </div>
            </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>
    <script>
        /**
         * 选择是否显示
         */
        function  is_show(h_id) {
            $.post("{{url('admin/is_show/')}}",{
                "_token":"{{csrf_token()}}",
                "h_id":h_id
            },function (msg) {
                if (msg == 1) {
                    var tips = '设置成功';
                    layer.msg(tips, {time: 2000, icon: 6});
                    location.reload();
                } else {
                    var tips = '设置失败';
                    layer.msg(tips, {time: 2000, icon: 5});
                }
            })
        }
        function destroy(h_id) {
            layer.confirm('您确定要删出吗？', {
                btn: ['确定', '取消'],
            }, function () {
                $.post("{{url('admin/fgheader')}}" + "/" + h_id, {
                    '_method': 'delete',
                    '_token': "{{csrf_token()}}"
                }, function (msg) {
                    if (msg == 1) {
                        var tips = '删除成功';
                        layer.msg(tips, {time: 2000, icon: 6});
                        location.reload();
                    } else {
                        var tips = '删除失败';
                        layer.msg(tips, {time: 2000, icon: 5});
                    }
                });
            }, function () {
            })

        }
    </script>
    {{-- content的隐藏于显示的js--}}
    <script>
        $(".wrapall").bind('mouseover', function () {
            $(this).find('.content').css('display', 'block');
        })
        $(".wrapall").bind('mouseout', function () {
            $(this).find('.content').css('display', 'none');
        })
    </script>
@endsection