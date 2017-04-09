@extends('layout.Home.layoutdetail')

@section('seo')
    <title>{{$data->art_title}}-{{Config::get('web.title')}}</title>
    <meta name="keywords" content="{{$data->cate_keywords}}"/>
    <meta name="description" content="{{$data->cate_desc}}"/>
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav">
            <a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('/cate/'.$data->cate_id)}}" class="n2">{{$data->cate_name}}</a>

            <span><b>首页</b> &nbsp;<i class="fa fa-chevron-right"></i>&nbsp;<b>{{$data->cate_name}}</b></span>
        </h1>
        <div class="index_about">
            <h2 class="c_titile">{{$data->art_title}}</h2>
            <p class="box_c"><span
                        class="d_time"> {{date('Y/m/d  H:i:s',$data->art_time)}}</span><span>编辑：{{$data->art_author}}</span><span>查看次数：{{$data->art_view}}</span>
            </p>
            <ul class="infos">
                {!! $data->art_content !!}
            </ul>
            <div class="keybq">
                <p><span>标签</span>：
                    @foreach($tags as $t)
                        <a href="{{url('/')}}">{{$t->tag_name}}</a> &nbsp;&nbsp;
                    @endforeach
                </p>

            </div>
            <div class="ad"></div>
            <div class="nextinfo">
                @if($point['pre'])
                    <p>上一篇：<a href="{{url('/detail/'.$point['pre']->art_id)}}">{{$point['pre']->art_title}}</a></p>
                @else
                    <p>上一篇：没有上一篇
                @endif

                @if($point['nxt'])
                    <p>下一篇：<a href="{{url('/detail/'.$point['nxt']->art_id)}}">{{$point['nxt']->art_title}}</a></p>
                @else
                    <p>上一篇：主人还没跟新
                @endif

            </div>
            {{-------------有问题---------------}}
            <div class="otherlink">
                <h2>相关文章</h2>
                <ul>
                    @foreach($relative as $v)
                        <li><a href="{{url('/detail/'.$v->art_id)}}" title="{{$v->art_title}}">{{$v->art_title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            {{----评论开始---}}
            <div class="ad" style="clear: both"></div>
            <div class="leave-message ">
                <ul>
                    @foreach($comment as $v)
                        @if($v->m_parent==0)
                            <li>
                                <div class="leave-header first-header">
                                    <a class="name">{{$v->m_name}}</a>
                                </div>
                                <div class=" markdown-reply content-body markdown-body ">
                                    {!! $v->m_comment !!}
                                </div>
                                <link rel="stylesheet"
                                      href="{{asset('resources/assets/style/font/css/font-awesome.min.css')}}">
                                {{--第二次循环--}}
                                <blockquote class="blockquote">
                                    <ul>
                                        @foreach($comment as $a)
                                            @if($v->m_id == $a->m_parent)
                                                <li>
                                                    <div class="leave-header second-header">
                                                        <a class="name">{{$a->m_name}}</a>
                                                    </div>
                                                    <div class=" markdown-reply markdown-body content-inner content-commen ">
                                                        {!! $a->m_comment !!}
                                                    </div>
                                                    <link rel="stylesheet"
                                                          href="{{asset('resources/assets/style/font/css/font-awesome.min.css')}}">
                                                    <div class="leave-bottom">
                                                        <a href="javascript:void(0)"><i
                                                                    class="fa fa-calendar (别称)"></i> {{$a->m_time}}</a>
                                                        <a href="javascript:void(0)" class="up"><i
                                                                    class="fa fa-fw fa-meh-o"></i>
                                                            <span>{{$a->m_up}}</span>顶</a>
                                                        <a href="#message" class="reply"><i
                                                                    class="fa fa-fw  fa-mail-reply (别称)"></i>回复</a>
                                                        <input type="hidden" value="{{$a->m_id}}" name="m_id">
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </blockquote>
                                {{--第二次循环end--}}
                                <div class="leave-bottom">
                                    <a href="javascript:void(0)"><i class="fa fa-calendar (别称)"></i> {{$v->m_time}}</a>
                                    <a href="javascript:void(0)" class="up"><i class="fa fa-fw fa-meh-o"></i>
                                        <span>{{$v->m_up}}</span>顶</a>
                                    <a href="#message" class="reply"><i class="fa fa-fw  fa-mail-reply (别称)"></i>回复</a>
                                    <input type="hidden" value="{{$v->m_id}}" name="m_id">
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <style>
                .blockquote {
                    padding-left: 50px;
                }

                .editor-preview-active {
                / / display: none;
                }

                .CodeMirror .CodeMirror-scroll {
                    min-height: 220px;
                    width: 100%;
                }

                .CodeMirror-scroll {
                    background-color: white;

                }

                div.CodeMirror-gutter, .CodeMirror-linenumbers {
                    width: 0px;
                }

                .leave-bottom a, .leave-header a {
                    display: inline-block;
                    height: 30px;
                    line-height: 30px;
                    margin-right: 10px;
                    text-decoration: none;
                    cursor: pointer;
                }

                .content-commen, .markdown-reply {
                    /* border: #333c41 solid 2px;*/
                    font-size: 16px;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                    line-height: 1.4;
                    overflow: hidden;
                    line-height: 1.6;
                    word-wrap: break-word;
                }

                .content-inner {
                    width: 600px;
                    margin: 10px 60px;
                }

                .content-body {
                    width: 660px;
                    margin: 10px 60px;
                }

                .markdown-body .highlight pre, .markdown-body pre, .markdown-reply .highlight pre, .markdown-reply pre {
                    padding: 14px;
                    overflow: auto;
                    line-height: 1.45;
                    background-color: #4e4e4e;
                    border-radius: 3px;
                    color: #fff;
                    border: none;
                }

                .markdown-body p, .markdown-body blockquote, .markdown-body ul, .markdown-body ol, .markdown-body dl, .markdown-body table, .markdown-body pre, .markdown-reply p, .markdown-reply blockquote, .markdown-reply ul, .markdown-reply ol, .markdown-reply dl, .markdown-reply table, .markdown-reply pre {
                    margin-top: 0;
                    margin-bottom: 10px;
                    line-height: 30px;
                }
            </style>

            <form action="#" method="post">
                <div class="message editor" id="message">
                    <h2>开始你的评论吧</h2>
                    {{csrf_field()}}
                    <span><label>姓名：</label><input type="text" name="m_name" required></span>
                    <span><label>邮箱：</label><input type="email" name="m_email" required></span>
                    <span><label>网址：</label><input type="url" name="m_url" required></span>
                    <p></p>
                    <textarea name="m_comment" placeholder="请留言吧" id="myEditor"></textarea>
                    <span> <input type="button" value="提交"></span>
                    <span> <input type="reset" value="重写"></span>
                    <input type="hidden" value="{{$id}}" name="m_art_id">
                    <input type="hidden" name="m_parent" value="0">
                    <link href="{{ asset('/public/plugin/editor/css/zoom.css') }}" rel="stylesheet">
                </div>
            </form>
            <style>
                .leave-header a {
                    background: url({{url('Home/images/datou.jpg')}}) 2px center no-repeat;
                    background-size: 50px 50px;
                    background-position: bottom left;
                    border-top: 1px solid rgba(54, 65, 20, 0.58);
                    line-height: 60px;
                    font-size: 12px;
                    font-weight: normal;
                    margin-right: 20px;
                    padding-left: 60px;
                    height: 40px;
                    font-size: 20px;
                    display: block;
                }

                .second-header {
                    width: 690px;
                    color: #5d5e55;
                }

                .first-header {
                    width: 740px;
                    color: #374bb9;
                }

                .message {
                    width: 740px;
                    position: relative;

                }

                .message h2 {
                    background: url({{url('/resources/assets/Home/images/datou.jpg')}}) 10px center no-repeat;
                    background-size: 50px 50px;
                    background-position: bottom left;
                    border-bottom: #099 2px solid;
                    line-height: 60px;
                    font-size: 12px;
                    font-weight: normal;
                    margin-right: 20px;
                    padding-left: 60px;
                    height: 40px;
                    font-size: 20px;
                    color: #374bb9;
                    width: 720px;
                    display: block;
                }

                .message span {
                    margin-right: 20px;
                }

                .message input {
                    border: 1px solid #ddd;
                    width: 160px;
                    margin: 4px 5px 4px 0;
                    padding: 3px;
                    box-shadow: inset 2px 3px 5px #eee;
                }

                .message textarea {
                    width: 95%;
                    height: 120px;
                    font-size: 13px;
                    padding: 4px;
                    margin: 4px 0 0 0;
                    border: 1px solid #ddd;
                    box-shadow: inset 2px 3px 5px #eee;
                    margin-right: 20px;
                }
            </style>
        </div>
        <script>
            //顶操作
            $(".up").bind('click', function () {
                var m_id = $(this).closest(".leave-bottom").find("input[name='m_id']").val();
                var _this = $(this);
                $.ajax({
                    url: "{{url('/up')}}",
                    type: 'POST',
                    data: {
                        m_id: m_id,
                        _token: "{{csrf_token()}}",
                    },
                    success: function (msg) {
                        if (msg != 0) {
                            var span = $(_this).find("span");
                            span.html("");
                            span.html(msg);
                            var tips = '顶成功';
                            layer.msg(tips, {time: 2000, icon: 6});
                        } else {
                            var tips = '顶失败';
                            layer.msg(tips, {time: 2000, icon: 5});
                        }
                    }
                })
            })
            $(".reply").bind('click', function () {

                //var name = $(this).parent('.leave-bottom').siblings('.leave-header').children('.name').eq(0).text();
                //console.log(name)
                //$('.CodeMirror-scroll').text('');
                // $('.CodeMirror-scroll').prepend("@"+name);
                var id = $(this).parent('.leave-bottom').find("input[name='m_id']").val();
                console.log(id);
                $("form input[name='m_parent']").val(id);
            })
            ///var data = $('.CodeMirror-scroll').text()
            //提交表单
            $("form input[type='button']").bind('click', function () {
                var m_comment = $("#myEditor").val()//$('.CodeMirror-scroll').text();
                var m_parent = $("form input[name='m_parent']").val();
                var m_name = $("form input[name='m_name']").val();
                var m_url = $("form input[name='m_url']").val();
                var m_email = $("form input[name='m_email']").val();
                var m_art_id = $("form input[name='m_art_id']").val();

                var m_parent = $("form input[name='m_parent']").val();
                //开始写评论
                var nowtime = getNowFormatDate();
                $.ajax({
                    url: "{{url('/message')}}",
                    type: 'POST',
                    data: {
                        m_comment: m_comment,
                        m_parent: m_parent,
                        _token: "{{csrf_token()}}",
                        m_name: m_name,
                        m_url: m_url,
                        m_email: m_email,
                        m_art_id: m_art_id,
                        m_time: nowtime,
                        m_parent: m_parent
                    },
                    success: function (msg) {
                        if (msg == 1) {
                            // 直接评论
                            var tips = '评论成功';
                            layer.msg(tips, {time: 1000, icon: 6});
                            location.reload()
                        } else if (msg != 0) {
                            //回复别人的评论
                            var tips = "";
                            if (msg["m_name"]) {
                                tips += msg["m_name"];
                            } else if (msg['m_url']) {
                                tips += " , " + msg["m_url"]
                            } else if (msg['m_email']) {
                                tips += " , " + msg['m_email'];
                            }
                            layer.msg(tips, {time: 2000, icon: 5});
                            location.reload()
                        } else {
                            var tips = '评论失败';
                            layer.msg(tips, {time: 2000, icon: 5});
                        }
                    }
                });
                //获取当前时间
                function getNowFormatDate() {
                    var date = new Date();
                    var seperator1 = "-";
                    var seperator2 = ":";
                    var month = date.getMonth() + 1;
                    var strDate = date.getDate();
                    if (month >= 1 && month <= 9) {
                        month = "0" + month;
                    }
                    if (strDate >= 0 && strDate <= 9) {
                        strDate = "0" + strDate;
                    }
                    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
                        + " " + date.getHours() + seperator2 + date.getMinutes()
                        + seperator2 + date.getSeconds();
                    return currentdate;
                }
            })
        </script>
        <aside class="right">
            <!-- Baidu Button BEGIN -->
            {{--<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a
                        class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span
                        class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585"></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000)
            </script>--}}
            <!-- Baidu Button END -->
            <div class="blank"></div>
            @parent
        </aside>
    </article>

@endsection