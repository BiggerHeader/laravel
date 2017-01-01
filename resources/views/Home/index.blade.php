@extends('layout.Home.layoutmain')
@section('seo')
    <title>{{Config::get('web.title')}}</title>
    <meta name="keywords" content="{{Config::get('web.keywords')}}"/>
    <meta name="description" content="{{Config::get('web.description')}}"/>
@endsection
@section('content')
     <div class="banner"  style="position: relative">
         <img src="{{url($header->h_url)}}" style="width: inherit;height: inherit;z-index: -10;display: inline-block;position: absolute;left: 0px;top: 0px;">
       <section class="box">
            <ul class="texts">
                @foreach($header->h_motto as $h)
                    <p>{{$h}}</p>
                @endforeach
            </ul>
            <div class="avatar"><a href="#"><span>Bigheader</span></a></div>
        </section>
    </div>
    <div class="template">
        <div class="box">
            <h3>
                <p><span>大头个人博客</span></p>
            </h3>
            <ul>
                @foreach($hot as $v)
                    <li><a href="{{url('/detail/'.$v->art_id)}}" target="_blank">
                            <img src="{{url('/'.$v->art_thumb)}}"></a><span>{{$v->art_title}}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <article>
            <h2 class="title_tj">
                <p>文章<span>推荐</span></p>
            </h2>
            <div class="bloglist left">
                @foreach($list as $v)
                    <h3>{{$v->art_title}}</h3>
                    <figure><img src="{{url($v->art_thumb)}}"></figure>
                    <ul>
                        <p>{{$v->art_desc}}...</p>
                        <a title="{{$v->art_title}}" href="{{url('/detail/'.$v->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
                    </ul>
                    <p class="dateview">
                        <span>
                            {{date('Y/m/d  H:i:s',$v->art_time)}}</span><span>作者：{{$v->art_author}}</span><span>
                            标签：{!! $v->art_tags !!}
                        </span>
                    </p>
                @endforeach
                    <div class="page" >
                        {{$list->links()}}
                    </div>
            </div>
        {{--调整时钟间距--}}
        <style>
            p.dateview span {
                margin: 0 20px 0 0;
                padding-left: 15px;
            }
        </style>
        <aside class="right">
            <div class="weather">
                <iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true"
                        src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe>
            </div>
            @parent
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

