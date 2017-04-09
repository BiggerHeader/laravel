<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('seo')

    <link href="{{asset('Home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('Home/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('Home/css/new.css')}}" rel="stylesheet">
    <link href="{{asset('Home/css/style.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('myextend/layer/layer.js')}}"></script>

    <link rel="stylesheet" href="{{asset('style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('style/font/css/font-awesome.min.css')}}">

    <!--[if lt IE 9]>
    <script src="{{asset('Home/js/modernizr.js')}}"></script>
    <![endif]-->
    @include('editor::head')

</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        @foreach( $navs as $v)<a href="{{$v->nav_url}}"><span>{{$v->nav_title}}</span><span
                    class="en">{{$v->nav_name}}</span></a>@endforeach
    </nav>
</header>
@section('content')
    <div class="news">
        <h3>
            <p>最新<span>文章</span></p>
        </h3>
        <ul class="rank">
            @foreach($news as $v)
                <li><a href="{{url('/detail/'.$v->art_id)}}" title="{{$v->art_title}}"
                       target="_blank">{{$v->art_title}}</a></li>
            @endforeach
        </ul>
        <h3 class="ph">
            <p>点击<span>排行</span></p>
        </h3>
        <ul class="paih">
            @foreach($hot as $v)
                <li><a href="{{url('/detail/'.$v->art_id)}}" title="{{$v->art_title}}"
                       target="_blank">{{$v->art_title}}</a></li>
            @endforeach
        </ul>
        <h3 class="links">
            <p>友情<span>链接</span></p>
        </h3>
        <ul class="">
            @foreach($links as $v)
                <li><a href="{{$v->link_url}}" title="{{$v->link_desc}}">{{$v->link_title}}</a></li>
            @endforeach
        </ul>
        <h3 class="links">
            <p>热门<span>标签</span></p>
        </h3>
        <ul class="mytag">
            @foreach($showtag as $t)
                <li><a href="{{url('/tag/'.$t->tag_id)}}" title="热门标签"
                       style="background-color:{{$t->tag_color}}">{{$t->tag_name}}</a></li>
            @endforeach
        </ul>
        <style>
            .mytag li {
                float: left;
            }

            .mytag li a {
                display: inline-block;
                width: auto;
                margin: 2px 10px;
                padding: 5px;
                line-height: 30px;
                font-size: 20px;
            }
        </style>

    </div>
@show
<footer>
    <p> {!!Config::get('web.copyright')!!} | {!!Config::get('web.count')!!} | {!!Config::get('web.cnzz')!!}</p>
</footer>
</body>
</html>