@extends('layout.layoutcate')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 网站配置
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
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
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/cfgcontent')}}" method="post">
        {{csrf_field()}}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>查看配置项</a>
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
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>名称</th>
                        <th>标题</th>
                        <th>内容</th>
                        <th>操作配置</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" value="{{$v['cfg_order']}}"
                                       onchange="changeO(this,'{{$v['cfg_id']}}');">
                            </td>
                            <td class="tc">{{$v['cfg_id']}}</td>
                            <td>
                                <a href="#">{{$v['cfg_name']}}</a>
                            </td>
                            <td>
                                <a href="#">{{$v['cfg_title']}}</a>
                            </td>
                            <td>
                                <input type="hidden" name="cfg_id[]" value="{{$v['cfg_id']}}"/>
                                {{--以标签的形式输出--}}
                                {!! $v['html'] !!}
                            </td>
                            <td>
                                <a href="{{url('admin/config/'.$v['cfg_id'].'/edit')}}">修改</a>
                                <a href="javascript:0" onclick="delOne({{$v['cfg_id']}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="page_list">

                </div>
            </div>
            <div class="btn_group">
                <input type="submit" value="提交">
                <input type="button" class="back" onclick="history.go(-1)" value="返回" >
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
        function changeO(obj, cfg_id) {
            var val = $(obj).val();
            $.post('{{url('admin/cfgorder')}}', {
                'cfg_id': cfg_id,
                'val': val,
                '_token': '{{csrf_token()}}'
            }, function (msg) {
                if (msg == 1) {
                    layer.alert('修改成功', {icon: 6});
                    location.href = location.href;
                } else {
                    layer.alert('修改失败', {icon: 5});
                }
            })
        }

        function delOne(cfg_id) {
            layer.confirm('您确定要删出吗？', {
                btn: ['确定', '取消'],
            }, function () {
                $.post("{{url('admin/config')}}"+"/"+cfg_id, {
                    '_method': 'delete',
                    '_token': "{{csrf_token()}}"
                }, function (msg) {
                    if (msg == 1) {
                        var tips = '删除成功';
                        layer.msg(tips, {time: 2000, icon: 6});
                        location.href = location.href;
                    } else {
                        var tips = '删除失败';
                        layer.msg(tips, {time: 2000, icon: 5});
                    }
                });
            }, function () {
            })

        }
    </script>
@endsection