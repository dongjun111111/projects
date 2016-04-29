<?php
header("content-type:text/html; charset=utf-8");
session_start();
$sessionuser=$_SESSION['sessionuser'];

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names gb2312');

$result=mysql_query("select * from admin where username='$sessionuser'");
while($row=mysql_fetch_array($result))
{
  $id=$row['id'];
  $photo=$row['photo'];
  $username=$row['username'];
}

?>
<!doctype html>
<html>
<head>
<title>吐槽</title>
<meta charset="utf-8">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Descriptions" content="">
<link href="./css/init.css" rel="stylesheet" type="text/css">
<link href="./css/index.css" rel="stylesheet" type="text/css">
<link href="./css/tucao.css" rel="stylesheet" type="text/css">

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
 <a href="javascript:void(0)" onclick="start()"><img src="./images/login.png" height="80px" width="80px" alt="Login" /></a>
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
显示
</div>
<div class="show-create">
右边，创建新吐槽或者注册
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
</body>
</html>