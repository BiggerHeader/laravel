@extends('layout.layout1')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{'admin/info'}}">首页</a> &raquo;配置
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
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>查看配置项</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/config')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>

                <tr>
                    <th><i class="require">*</i>标题：</th>
                    <td>
                        <input type="text" class="lg" name="cfg_title">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>名称：</th>
                    <td>
                        <input type="text" class="lg" name="cfg_name">
                    </td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>类型：</th>
                    <td>
                        <input type="radio" name="field_type" onclick="show_hidden($(this))" value="input" checked>input
                        <input type="radio" name="field_type" onclick="show_hidden($(this))" value="textarea">textarea
                        <input type="radio" name="field_type" onclick="show_hidden($(this))" value="radio">radio
                    </td>
                </tr>

                <tr class="radio_value">
                    <th width="120"><i class="require">*</i>类型值：</th>
                    <td>
                        <input type="text" name="field_value">
                    </td>
                </tr>
                <script>

                    function show_hidden(self) {
                        self = typeof self === 'undefined' ? $("input[name=field_type]:checked") : self;
                        var val = self.val();
                        self.siblings().attr('checked', false);
                        self.attr('checked', true)
                        if (val == 'input' ||val == 'textarea' ) {
                            /* 这个方法是怎么实现的  既不是 block元素  也占用空间  */
                            $('.radio_value').hide();
                        } else if (val == 'radio'){
                            $('.radio_value').show();
                        }
                    }
                    show_hidden();
                </script>
                <tr>
                    <th width="120"><i class="require">*</i>排序：</th>
                    <td>
                        <input type="text" class="lg" name="cfg_order">
                    </td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>说明：</th>
                    <td>
                        <textarea rows="5" cols="15" name='cfg_tips'></textarea>
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