<?php
error_reporting(0);
header("content-type:text/html;charset=utf-8");

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names gb2312');

?>
<!doctype html>
<html>
<head>
<link href="../css/init.css" rel="stylesheet" type="text/css">
<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/register.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>D-Jason</h1>
<div id="header">
<ul>
	<li><a href="../index.php">首页</a></li>
	<li><a href="../article.php">文章</a></li>
    <li><a href="../tucao.php">吐槽</a></li>
</ul>
<p><a href="javascript:void(0)" onclick="login('block')"><img src="../images/login.png" height="80px" width="80px" alt="Login" /></a></p>
</div>
<div id="register-container">
<div class="content">
<form action="doRegister.php" method="post" enctype="multipart/form-data">
<div id="step">
  <input type="button" class="selected" value="第一步" />
  <input type="button" value="第二步" />
  <input type="button" value="第三步" />
  </div>

  <div id="showeverystep">
  <div id="step1" class="active">
  <br><h2>创造新注册名</h2>
  <p>姓名:<input type="text" name="username" id="username" />&nbsp<label id="label"></label></p><br>
 </div>
 <div id="step2">
  <br><h2>详细资料</h2>
  性别:<select name="sex">
  <option value="male" selected>男</option>
  <option value="female">女</option>
  </select><br>
  头像:<input type="file" name="photo" /><br>
  手机:<input type="text" name="phone" id="phone" /><br>
  邮箱:<input type="text" name="email" id="email" /><br>
  Q   Q:<input type="text" name="qq" id="qq" /><br>
 </div>
 <div id="step3">
 <br><h2>密码</h2>
 密码:<input type="password" name="password" /><br>
 确认:<input type="password" name="confirm" /></br>
 <input type="submit" value="注册" class="submit" />
 </div>
 </div>

</form>
</div>
</div>

<div id="footer">
<p><a href="../copyRight.php">版权声明</a>&nbsp|&nbsp<a href="http://dongjun111111.github.io/D-Jason.html">关于作者</a>&nbsp|&nbsp<a href="../contact.php">联系作者</a></p><br>
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
<p style="position:relative;margin:-2em 3em;"><a href="register.php">没有账号?去注册</a></p>
</div>
<script  type="text/javascript" src="../js/login.js"></script>
<script type="text/javascript" src="../js/register.js"></script>
<script type="text/javascript" src="../js/Ajax.js"></script>
<script>
window.onload=function()
{
var oUsername=document.getElementById("username");
var oStep1=document.getElementById("step1");
var oStep2=document.getElementById("step2");
oUsername.onblur=function()
	{
	 fun(oUsername.value);//重要
	}	
}
</script>
</body>
</html>