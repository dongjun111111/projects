<?php
header('content-type:text/html; charset=utf-8');
session_start();
$sessionuser=$_SESSION['sessionuser'];

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names utf8');

$result=mysql_query("select * from admin where username='$sessionuser'");
while($rows=mysql_fetch_array($result))
{
  $ids=$rows['id'];
  $photo=$rows['photo'];
  $username=$rows['username'];
}

$id=$_GET['id'];
$article=mysql_query("select * from article where id='$id'");
?>
<!doctype html>
<html>
<head>
<link href="../css/init.css" rel="stylesheet" type="text/css">
<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/articleDetail.css" rel="stylesheet" type="text/css">
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
if(!$username)
{ echo '
 <a href="javascript:void(0)" onclick="start()"><img src="../images/login.png" height="80px" width="80px" alt="Login" /></a>
 ';
}
else
{
  echo '
 <a href="adminInfo.php?id='.$ids.'"><img  style="margin-top:10px;" src="'.$photo.'" height="40px" width="40px" alt="'.$username.'"/></a><a href="../loginOut.php" ><b>登出</b></a>
   ';
}
?>
</p>
</div>
<div id="detail">
<?php
while($row = mysql_fetch_array($article))
{
 echo '
 <h2>'.$row["title"].'</h2>类别:'.$row["category"].'<span class="span1">作者:'.$row["author"].'&nbsp|&nbsp发表日期:'.$row["createtime"].'&nbsp&nbsp&nbsp<img src="../images/star.png" height="20em" width="20em" alt="star" />'.$row["vote"].'&nbsp&nbsp <span><a href="javascript:void(0)" onclick="like()"><img src="../images/like.png" height="25em" width="25em" alt="like" /></a></span></span><br><br>
  <div  class="x">'.$row["content"].'</div >
 ';}
?>
<div class="comment" id="comment"><p style="font-size:2em;"><a href="comment.php?id=<?php echo $id;?>">评论</a></p></div>
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
<input type="submit" value="登录" class="submit" />
</form>
<p style="position:relative;margin:-2em 3em;"><a href="/register.php">没有账号?去注册</a></p>
</div>
<script  src="../js/login.js"></script>
<script>
function like()//点赞的功能
{

}
</script>
</body>
</html>