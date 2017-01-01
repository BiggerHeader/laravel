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
                <a href="{{url('admin/fgheader/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/fgheader')}}"><i class="fa fa-recycle"></i>查看配置项</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/fgheader/'.$data->h_id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put"/>
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>图片地址：</th>
                    <td>
                        <input type="text" name="h_url" size="20" value="{{$data->h_url}}">
                        <script src="{{url('myextend/uploadify/jquery.uploadify.min.js')}}"
                                type="text/javascript"></script>
                        <link rel="stylesheet" type="text/css" href="{{url('myextend/uploadify/uploadify.css')}}">
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function () {
                                $('#file_upload').uploadify({
                                    'buttonText': '图片上传',
                                    'formData': {
                                        'timestamp': '<?php echo $timestamp;?>',
                                        '_token': "{{csrf_token()}}"
                                    },
                                    'swf': "{{url('myextend/uploadify/uploadify.swf')}}",
                                    //修改上传路径
                                    'uploader': "{{url('admin/upload')}}",
                                    'onUploadSuccess': function (file, data, response) {
                                        $("input[name=h_url]").val(data);
                                        $("#upload_show").attr('src','/'+data);
                                    },
                                });
                            });
                        </script>
                        <style>
                            .uploadify {
                                display: inline-block;
                            }

                            .uploadify-button {
                                border: none;
                                border-radius: 5px;
                                margin-top: 8px;
                            }

                            table.add_tab tr td span.uploadify-button-text {
                                color: #FFF;
                                margin: 0;
                            }
                        </style>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>预览：</th>
                    <td>
                       <img src="{{url($data->h_url)}}" id="upload_show">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>作者：</th>
                    <td>
                        <input type="text" name="h_author"  value="{{$data->h_author}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>格言：</th>
                    <td>
                        <textarea  name='h_motto' style="height: 100px;"> value="{{$data->h_motto}}"</textarea><i class="require">换行用 P代表</i>
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