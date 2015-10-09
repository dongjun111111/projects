<?php
header('content-type:text/html; charset=utf-8');
?>
<!doctype html>
<html>
<head>
<link href="./css/init.css" rel="stylesheet" type="text/css">
<link href="./css/index.css" rel="stylesheet" type="text/css">
<link href="./css/contact.css" rel="stylesheet" type="text/css">

</head>
<body>
<h1>D-Jason</h1>
<div id="header">
<ul>
	<li><a href="index.php">首页</a></li>
	<li><a href="article.php">文章</a></li>
    <li><a href="tucao.php">吐槽</a></li>
</ul>
<p><a href="javascript:void(0)" onclick="login('block')"><img src="./images/login.png" height="120px" width="120px" alt="Login" /></a></p>
</div>
<div id="contact-container">
<div class="content">
<h2>董军/D-Jason</h2>
<p>朋友，你好！我是董军，一名天天做着改变世界的白日梦的逗比伪文艺准IT从业者！您可以在<a href="http://dongjun111111.github.io/D-Jason.html">GitHub</a>或者在<a href="javascript:void(0)" onclick="weibo()">Weibo</a>上找到我，期待与你成为好朋友，哈哈！我的个人微信公众平台号是<q>OvercomeYouself</q>(不要告诉我单词为什么拼错了，我故意的),你可以关注我哟，虽然很少更新，不过私信必回的！</p>
</div>
</div>

<div id="footer">
<p><a href="copyRight.php">版权声明</a>&nbsp|&nbsp<a href="http://dongjun111111.github.io/D-Jason.html">关于作者</a>&nbsp|&nbsp<a href="contact.php">联系作者</a></p><br>
<p>Copyright © 1998 - 2015 D-Jason. All Rights Reserved</p>
</div>

<div id="login">
<p><a href="javascript:void(0)" onclick="login('none')">X</a></p>
<form action="doLogin.php" method="post">
姓名:<input type="text" name="username" placeholder="请输入您的姓名" /><br>
密码:<input type="password" name="password" placeholder="请输入您的密码" /><br>
<p>验证:<input type="text" name="confirm" class="confirm" placeholder="请输入验证码" /><img src="#" height="2em" width="5em" alt="confirm" /></p>
<input type="submit" value="登录" class="submit" />
</form>
<p style="position:relative;margin:-2em 3em;"><a href="./admin/register.php">没有账号?去注册</a></p>
</div>
<script  src="./js/login.js"></script>
<script  src="./js/contact.js"></script>

</body>
</html>