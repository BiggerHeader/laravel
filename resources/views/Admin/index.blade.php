@extends('layout.layout1')
@section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">后台管理模板</div>
			<ul>
				<li><a href="{{url('/')}}" target="_blank" class="active">首页</a></li>
				<li><a href="{{url('admin/info')}}" target="main">管理页</a></li>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>管理员：admin</li>
				<li><a href="{{url('admin/changepass')}}" target="main">修改密码</a></li>
				<li><a href="{{url('admin/logout')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
            <li>
            	<h3><i class="fa fa-fw fa-clipboard"></i>内容管理</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/cate')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>分类操作</a></li>
					<li><a href="{{url('admin/article')}}" target="main"><i class="fa fa-fw fa-list-alt"></i>文章操作</a></li>
					<li><a href="{{url('admin/tag')}}" target="main"><i class="fa fa-tag"></i>标签操作</a></li>
                </ul>
            </li>
            <li>
            	<h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>
                <ul class="sub_menu">
					<li><a href="{{url('admin/nav')}}" target="main"><i class="fa fa-fw fa-paper-plane-o"></i>导航操作</a></li>
					<li><a href="{{url('admin/link')}}" target="main"><i class="fa fa-fw  fa-share-alt"></i>友情链接操作</a></li>
                    <li><a href="{{url('admin/config')}}" target="main"><i class="fa fa-fw fa-cubes"></i>网站配置</a></li>
					<li><a href="{{url('admin/fgheader')}}" target="main"><i class="fa fa-fw fa-cubes"></i>网站头配置</a></li>
                    <li><a href="Javascript:0" target="main"><i class="fa fa-fw fa-database"></i>备份还原</a></li>
                </ul>
            </li>
            <li>
            	<h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>
                <ul class="sub_menu">
                    <li><a href="http://www.yeahzan.com/fa/facss.html" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>
                    <li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>
                </ul>
            </li>
        </ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->
<!--底部 开始-->
<div class="bottom_box">
	CopyRight © 2017. Powered By <a href="http://www.datou.com">http://www.dtcode.com</a>.
</div>
<!--底部 结束-->
@endsection