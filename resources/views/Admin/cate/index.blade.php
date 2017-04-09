@extends('layout.layoutcate')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分类列表
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->

    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('/admin/cate/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{url('/admin/cate')}}"><i class="fa fa-recycle"></i>文章列表</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>分类名称</th>
                        <th>审核状态</th>
                        <th>点击</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc"><input type="checkbox" name="id[]" value="59"></td>
                            <td class="tc">
                                <input type="text" name="ord[]" value="{{$v['cate_order']}}"
                                       onchange="changeO(this,'{{$v['cate_id']}}');">
                            </td>
                            <td class="tc">{{$v['cate_id']}}</td>
                            <td>
                                <a href="#">{{$v['cate_name']}}</a>
                            </td>
                            <td>
                                <a href="#">{{$v['cate_title']}}</a>
                            </td>
                            <td></td>
                            <td>{{$v['cate_view']}}</td>
                            <td>
                                <a href="{{url('admin/cate/'.$v['cate_id'].'/edit')}}">修改</a>
                                <a href="javascript:0" onclick="delOne({{$v['cate_id']}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>

    <script>
        function changeO(obj, cate_id) {
            var val = $(obj).val();
            $.post('{{url('admin/changeorder')}}', {
                'cate_id': cate_id,
                'val': val,
                '_token': '{{csrf_token()}}'
            }, function (msg) {
                if (msg == 1) {
                    layer.alert('修改成功', {icon: 6});
                } else {
                    layer.alert('修改失败', {icon: 5});
                }
            })
        }

        function delOne(cate_id) {
            layer.confirm('您确定要删出吗？', {
                btn: ['确定', '取消'],
            }, function () {
                $.post("{{url('admin/cate')}}"+"/"+cate_id, {
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
    <!--搜索结果页面 列表 结束-->
@endsection

