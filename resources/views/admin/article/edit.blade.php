@extends('layout.layout1')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{'admin/info'}}">首页</a> &raquo; 添加文章
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
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>文章列表</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/article/'.$field->art_id)}}" method="post">
            <input type="hidden" name="_method" value="put"/>
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>文章所属分类：</th>
                    <td>
                        <select name="cate_id">
                            <option value="">==请选择==</option>
                            @foreach($data as $v)
                                <option value="{{$v['cate_id']}}"
                                        @if($field->cate_id == $v['cate_id']) selected @endif >{{$v['cate_name']}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>文章标题：</th>
                    <td>
                        <input type="text" class="lg" name="art_title" value="{{$field->art_title}}">
                        <p>标题可以写30个字</p>
                    </td>
                </tr>
                <tr>
                    <th>编辑：</th>
                    <td>
                        <input type="text" class="lg" name="art_author" value="{{$field->art_author}}">
                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td>
                        <input type="text" name="art_thumb" size="20" value="{{$field->art_thumb}}">
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
                                        $("input[name=art_thumb]").val(data);
                                        $("#upload_show").attr('src', '/' + data);
                                    }
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
                    <th></th>
                    <td>
                        <img src="/{{$field->art_thumb}}" alt="上传图片显示" id="upload_show"
                             style=" with:500px; height:300px">
                    </td>
                <tr>
                    <th>标签：</th>
                    <td>
                        @foreach($tags as $t)
                            @if(in_array($t->tag_id ,$field->art_tags))
                                <input type="checkbox" value="{{$t->tag_id}}" name="art_tags[]"
                                       checked/>{{$t->tag_name}} &nbsp;&nbsp;&nbsp;
                            @else
                                <input type="checkbox" value="{{$t->tag_id}}" name="art_tags[]"/>{{$t->tag_name}} &nbsp;
                                &nbsp;&nbsp;
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>文章描述：</th>
                    <td>
                        <textarea class="lg" name="art_desc">{{$field->art_desc}}</textarea>
                        <p>标题可以写30个字</p>
                    </td>
                </tr>
                <tr>
                    <th>文章内容：</th>
                    <td>
                        <script type="text/javascript" charset="utf-8"
                                src="{{url('myextend/baiduEditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8"
                                src="{{url('myextend/baiduEditor/ueditor.all.min.js')}}"></script>
                        <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                        <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                        <script type="text/javascript" charset="utf-8"
                                src="{{url('myextend/baiduEditor/lang/zh-cn/zh-cn.js')}}"></script>
                        {{-- 用实体的方法输出 --}}
                        <script id="editor" name="art_content" type="text/plain"
                                style="width:800px;height:500px;"> {!! $field->art_content !!}</script>
                        <script type="text/javascript">
                            //实例化编辑器
                            var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default {
                                line-height: 28px;
                            }

                            div.edui-combox-body, div.edui-button-body, div.edui-splitbutton-body {
                                overflow: hidden;
                                height: 20px;
                            }

                            div.edui-box {
                                overflow: hidden;
                                height: 22px;
                            }
                        </style>
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