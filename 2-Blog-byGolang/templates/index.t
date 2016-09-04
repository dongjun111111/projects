<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Jason's Posts">
	<meta name="keywords" content="Jason,Golang,Go语言,博客">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">

	<!-- No Baidu Siteapp-->
	<meta http-equiv="Cache-Control" content="no-siteapp"/>

	<link rel="icon" type="image/png" href="assets/img/favicon.png">
	<link rel="stylesheet" href="http://apps.bdimg.com/libs/fontawesome/4.2.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/css/screen.css">
	<title>Jason</title>
	<script type="text/javascript" src="/assets/js/baidu-count.js"></script>
</head>

<body>
<div class="container">
	<header>
		<h1 class="maintitle"> Jason's Home </h1>
	</header>
    <section class="posts">
	{{range .}}
	<div class="indexcontents">
	{{if ne .Title ""}}
		<h2><i class="fa fa-pencil"></i> {{.Title}} {{if .Description}} <font class="desc">({{.Description}})</font>{{end}}
		</h2>			
			{{range .Posts}}
				<p>
					<a href="/{{.Name}}">{{.Title}}</a>
					{{if .Description}} <font class="desc">({{.Description}})</font> {{end}}
				</p>
			{{end}}
	{{end}}
	</div>
	{{end}}
    </section>

	<section class="about">
	<div class="indexcontents">
			<i class="fa fa-weibo fa-x"></i><a href="http://www.weibo.com/u/3164465513">Weibo</a>
            <i class="fa fa-twitter fa-x"></i><a href="https://twitter.com/90DJason">Twitter</a>
            <i class="fa fa-facebook fa-x"></i><a href="https://www.facebook.com/90DJason">Facebook</a>
	</div>
	</section>

	<footer>
		<p>本站文章采用<a rel="license" href="http://creativecommons.org/licenses/by/4.0/">CC BY 4.0</a>进行许可，文中涉及代码采用<a rel="license" href="http://creativecommons.org/publicdomain/zero/1.0/">CC0 1.0 Universal</a>进行许可</p>
		<p>订阅本站文章：<a href="http://blog.djason.cc/feed" target="_blank"><i class="fa fa-rss-square"></i>ATOM</a>  <a href="http://blog.djason.cc/rss" target="_blank"><i class="fa fa-rss-square"></i>RSS</a></p>
		<p>Powered By Jason</p>
	</footer>
</div>
</body>
</html>