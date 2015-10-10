<?php
error_reporting(0);
header("Content-Type:text/html; charset=utf-8");
session_start();
$sessionuser=$_SESSION['sessionuser'];

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names utf8');//这边不是uft-8,而是utf8,我擦

$result=mysql_query("select * from admin where username='$sessionuser'");
while($row=mysql_fetch_array($result))
{
  $id=$row['id'];
  $photo=$row['photo'];
  $username=$row['username'];
}

$article=mysql_query("select * from article limit 3");
?>
<!doctype html>
<html>
<head>
<html><title>文章</title>
<meta charset="utf-8">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Descriptions" content="">
<link href="./css/init.css" rel="stylesheet" type="text/css">
<link href="./css/index.css" rel="stylesheet" type="text/css">
<link href="./css/article.css" rel="stylesheet" type="text/css">
<link href="./css/tagCloud.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>D-Jason</h1>
<div id="header">
<ul>
	<li><a href="index.php">首页</a></li>
	<li><a href="article.php">文章</a></li>
    <li><a href="tucao.php">吐槽</a></li>
</ul>
<p>
<?php
if(!$sessionuser)
{ echo '
 <a href="javascript:void(0)" onclick="start()"><img src="./images/login.png" height="80px" width="80px" alt="Login"  /></a>
 ';
}
else
{
	$photo=substr($photo,1);
  echo '
 <a href="./admin/adminInfo.php?id='.$id.'"><img  style="margin-top:10px;" src="'.$photo.'" height="40px" width="40px" alt="'.$username.'"/></a><a href="loginOut.php" ><b>登出</b></a>
   ';
}
?>
</p>
</div>

<div id="show">
<div class="show-detail">
<ul>
<?php 
while($rows=mysql_fetch_array($article))
{
	echo '
<li><div style="position:relative;height:12em;width:100%;background:#093;overflow:hidden;">
<h2>'.$rows["title"].'</h2><span style="position:absolute;margin-top:-0.5em;margin-left:23em;font-size:0.8em;">'.$rows["author"].' 发表于'.$rows["createtime"].'&nbsp <img src="./images/star.png" height="16px" width="16px" alt="star"/>'.$rows["vote"].'</span>
<div >'.$rows["content"].'</div>
<p><a href="./admin/articleDetail.php?id='.$rows["id"].'" style="float:right;color:white;">阅读原文</a></p>
</div><hr></li>

';};
?>
</ul>
</div>
<div class="show-create">
<div class="show1">
<?php 
if($sessionuser)
{echo '
<input type="button" value="我也来一发" onclick="chuangyue()" /> ';
}
else
{echo'
<input type="button" value="我也来一发" onclick="register()" /> ';
}
?>
</div>
<div class="show2">
    <div id="tagscloud">
	<?php
	if(!$sessionuser)
	{echo '
     <a href="" class="tagc1">111111111</a>
	<a href="" class="tagc2">222222222</a>
	<a href="" class="tagc5">5555555555</a>
	<a href="" class="tagc1">1111111</a>
	<a href="" class="tagc2">222222222</a>
	<a href="" class="tagc5">5555555555</a>
	<a href="" class="tagc1">1111111</a>
	<a href="" class="tagc2">222222222</a>
	<a href="" class="tagc5">5555555555</a>
	<a href="" class="tagc1">1111111</a>
	<a href="" class="tagc2">222222222</a>
	<a href="" class="tagc5">5555555555</a>
	';}
	else
	{echo '
	   <a href="" class="tagc1">'.$id.'</a>
	<a href="" class="tagc2">'.$username.'</a>
	<a href="" class="tagc5">'.$username.'</a>
	<a href="" class="tagc1">'.$id.'</a>
	<a href="" class="tagc2">'.$username.'</a>
	<a href="" class="tagc5">'.$username.'</a>
	<a href="" class="tagc1">'.$id.'</a>
	<a href="" class="tagc2">'.$username.'</a>
	<a href="" class="tagc5">'.$username.'</a>
	<a href="" class="tagc1">'.$id.'</a>
	<a href="" class="tagc2">'.$username.'</a>
	<a href="" class="tagc5">'.$username.'</a>
	';
	}
	?>
    </div>  
</div>
<div class="show3">
</div>

</div>
<div class="show-bottom">
待定模块
</div>
</div> 

<div id="foot">
<p><a href="copyRight.php">版权声明</a>&nbsp|&nbsp<a href="http://dongjun111111.github.io/D-Jason.html">关于作者</a>&nbsp|&nbsp<a href="contact.php">联系作者</a></p><br>
<p>Copyright © 1998 - 2015 D-Jason. All Rights Reserved</p>
</div>

<div id="login">
<p><a href="javascript:void(0)" onclick="login('none')">X</a></p>
<form action="./admin/doLogin.php" method="post">
姓名:<input type="text" name="username" placeholder="请输入您的姓名" /><br>
密码:<input type="password" name="password" placeholder="请输入您的密码" /><br>
<p>验证:<input type="text" name="confirm" class="confirm" placeholder="请输入验证码" /><img src="./admin/code.php" height="30em" width="60em" alt="confirm" /></p>
<input type="submit" value="登录" class="submit" />
</form>
<p style="position:relative;margin:-2em 3em;"><a href="./admin/register.php">没有账号?去注册</a></p>
</div>
<script  src="./js/login.js"></script>
<script  src="./js/tagCloud.js"></script>
<script>
function register()
{
	location.href="./admin/register.php";
}
function chuangyue()
{
	location.href="./admin/createArticle.php";
}
</script>
</body>
</html>