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

	<script>
		var _hmt = _hmt || [];
		(function() {
			var hm = document.createElement("script");
			hm.src = "//hm.baidu.com/hm.js?e0811847abcff7c3962075668a8d15ca";
			var s = document.getElementsByTagName("script")[0]; 
			s.parentNode.insertBefore(hm, s);
		})();
	</script>
</head>

<body>
<div class="container">
	<header>
		<h1> Jason's Home </h1>
		<p>The Best Or Nothing</p>
	</header>

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

	<section class="about">
	<div>
		<h2><i class="fa fa-user"></i> 关于作者</h2>
		<p>Jason，野生程序员一枚。</p>
		<p>		
			<i class="fa fa-github-alt fa-x"></i><a href="https://www.github.com/dongjun111111">GitHub</a>
			<i class="fa fa-weibo fa-x"></i><a href="http://www.weibo.com/u/3164465513">Weibo</a>
		</p>
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