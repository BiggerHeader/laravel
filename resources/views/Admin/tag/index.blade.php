@extends('layout.layoutcate')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 标签
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
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/tag/create')}}"><i class="fa fa-plus"></i>新增标签</a>
                    <a href="{{url('admin/tag')}}"><i class="fa fa-recycle"></i>标签列表</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标签名</th>
                        <th>标签颜色</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                {{$v['tag_id']}}
                            </td>
                            <td class="tc">
                                {{$v['tag_name']}}
                            </td>
                            <td class="tc">
                                {{$v['tag_color']}}
                            </td>
                            <td>
                                <a href="{{url('admin/tag/'.$v['tag_id'].'/edit')}}">修改</a>
                                <a href="javascript:0" onclick="deleteTag({{$v['tag_id']}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function deleteTag(cate_id) {
            layer.confirm('您确定要删出吗？', {
                btn: ['确定', '取消'],
            }, function () {
                $.post("{{url('admin/tag')}}" + "/" + cate_id, {
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
            })

        }
    </script>
@endsection