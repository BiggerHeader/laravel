@extends('layout.Home.layoutmain')
@section('seo')
    <title>{{$cate->cate_title}}-{{Config::get('web.title')}}</title>
    <meta name="keywords" content="{{Config::get('web.keywords')}}"/>
    <meta name="description" content="{{Config::get('web.description')}}"/>
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav">
            <span>{{$cate->cate_desc}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a
                    href="{{url('cate/'.$cate->cate_id)}}"
                    class="n2">{{$cate->cate_name}}</a>
        </h1>
        <div class="newblog left">
            @foreach($art as $v )
                <h2>{{$v->art_title}}</h2>
                <figure><img src="{{url($v->art_thumb)}}"></figure>
                <ul class="nlist">
                    <p> &nbsp;&nbsp;&nbsp;{{$v->art_desc}}...</p>
                    <a title="{{$v->art_title}}" href="{{url('/detail/'.$v->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
                </ul>
                <p class="dateview"><span>{{date('Y-m-d  H:h:s',$v->art_time)}}</span><span>作者：{{$v->art_author}}</span><span>标签：<a
                                href="{{url('/cate/'.$cate->cate_id)}}">{{$cate->cate_name}}</a></span></p>
            @endforeach
            <div class="line"></div>
            <div class="blank"></div>
            {{--<div class="ad">
                <img src="{{asset('resources/assets/Home/images')}}/">
            </div>--}}
            <div class="page">
                {{$art->links()}}
            </div>
            {{--调整时钟间距--}}
            <style>
                p.dateview span {
                    margin: 0 20px 0 0;
                    padding-left: 15px;
                }
            </style>
        </div>
        <aside class="right">
            <div class="rnav">
                <ul>
                    @foreach($sub as $key=>$v)
                        <li class="rnav{{$key+1}}"><a href="{{url('/cate/'.$v->cate_id)}}" target="_blank">{{$v->cate_name}}</a></li>
                    @endforeach
                </ul>
            </div>
        @parent
        {{--<div class="visitors">
            <h3><p>最近访客</p></h3>
            <ul>

            </ul>
        </div>--}}
        <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a
                        class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span
                        class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585"></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000)
            </script>
            <!-- Baidu Button END -->
        </aside>
    </article>
@endsection