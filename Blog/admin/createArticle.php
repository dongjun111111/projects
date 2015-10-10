<?php
header("content-type:text/html; charset=utf-8");

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names gb2312');
session_start();
$sessionuser=$_SESSION['sessionuser'];
if(!$sessionuser)
{
 echo "<script>alert('请先登录');location.href='../article.php';</script>";
 exit;
}
$result=mysql_query("select * from admin where username='$sessionuser'");
while($row=mysql_fetch_array($result))
{
  $id=$row['id'];
  $photo=$row['photo'];
  $username=$row['username'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="../css/init.css" rel="stylesheet" type="text/css">
<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/createNew.css" rel="stylesheet" type="text/css">
<title>创造新文章</title>
</head>
<body>
<h1>D-Jason</h1>
<div id="header">
<ul>
	<li><a href="../index.php">首页</a></li>
	<li><a href="../article.php">文章</a></li>
    <li><a href="../tucao.php">吐槽</a></li>
</ul>
<p>
<?php
if(!$sessionuser)
{ echo '
 <a href="javascript:void(0)" onclick="start()"><img src="../images/login.png" height="80px" width="80px" alt="Login" /></a>
 ';
}
else
{
  echo '
 <a href="adminInfo.php?id='.$id.'"><img  style="margin-top:10px;" src="'.$photo.'" height="40px" width="40px" alt="'.$username.'"/></a><a href="../loginOut.php" ><b>登出</b></a>
   ';
}
?>
</p>
</div>

<div id="createNew">
<div class="create">
<form action="doCreateArticle.php" method="post">
<br>
<input type="hidden" value="<?php echo $sessionuser;?>" id="hidden" />
<p><b>标题:</b><input type="text" name="title" class="title"  placeholder="please input title"/></p><br> 
<textarea  class="ckeditor" cols="40" rows="8" name="content"></textarea>
<input type="submit" class="submit" value="发表" />
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
<p>验证:<input type="text" name="confirm" class="confirm" placeholder="请输入验证码" /><img src="code.php" height="30em" width="60em" alt="confirm" /></p>
<input type="submit" value="登录" class="submit" onclick="check()" />
</form>
<p style="position:relative;margin:-2em 3em;"><a href="register.php">没有账号?去注册</a></p>
</div>
<script  src="../js/login.js"></script>
<script  src="../ckeditor/ckeditor.js"></script>
<script>
var oHidden=document.getElementById("hidden");
function check()
{
if(oHidden.value != null)
	{return true;}
else
	{alert("请先登录");return false;}
}
</script>
</body>
</html>
