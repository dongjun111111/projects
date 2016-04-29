<?php
error_reporting(0);
header("content-type:text/html; charset=utf-8");

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names utf8');

session_start();
$sessionuser=$_SESSION['sessionuser'];
if(!$sessionuser)
{
 echo "<script>alert('禁止非法访问');location.href='../index.php';</script>";
 exit;
}
$result=mysql_query("select * from admin where username='$sessionuser'");
while($row=mysql_fetch_array($result))
{
  $id=$row['id'];
  $photo=$row['photo'];
  $username=$row['username'];
  $classify=$row['classify'];
}

$pagesize=2;
if($classify == "2")
{
$alluser=mysql_query("select count(*) from admin where classify <3");

}
else
{
$alluser=mysql_query("select count(*) from admin ");
}
$roww=mysql_fetch_row($alluser);
$num=$roww[0];
$pagecount=ceil($num/$pagesize);
$currpage=empty($_GET['page'])?1:$_GET['page'];

?>
<!doctype html>
<html>
<head>
<link href="../css/init.css" rel="stylesheet" type="text/css">
<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/allUser.css" rel="stylesheet" type="text/css">
<title><?php echo $username;?>管理的所有用户</title>
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

<div id="alluser">
<p>共有<?php echo $num;?>人<input type="button" value="返回" onclick="back()" style="position:relative;background:#093;align;margin-left:86em;margin-top:1em;" /></p>
<table width="80%" border="1" cellpadding="2" cellspacing="5" align="center" style="margin-left:7.4em;">
<thead>
<tr><td>用户名</td><td>性别</td><td>头像</td><td>QQ</td><td>邮箱</td><td>权限</td><td width="15%">修改权限</td><td>IP</td><td>注册时间</td><td>删除</td></tr>
</thead>
<tbody>

<?php
if($classify == "2")
{
$allUsers=mysql_query("select * from admin  where classify < 3 limit ".($currpage-1)*$pagesize.",".$pagesize);
}
else
{
$allUsers=mysql_query("select * from admin limit ".($currpage-1)*$pagesize.",".$pagesize);
}
while($rows=mysql_fetch_array($allUsers))
{
	if($rows['classify'] == "3")
	{
	 $classify="超级管理员";
	}
	if($rows['classify'] == "2")
	{
	 $classify="管理员";
	}
	if($rows['classify'] == "1")
	{
	 $classify="一般用户";
	}
	if($rows['sex'] == "female")
	{
	$sex="女";
	}
	if($rows['sex'] == "male")
	{
	$sex="男";
	}

echo '<tr>
<td>'.$rows['username'].'</td><td>'.$sex.'</td><td><img src="'.$rows['photo'].'" height="25em" width="25em" alt="头像" /></td><td>'.$rows['qq'].'</td><td>'.$rows['email'].'</td><td>'.$classify.'</td><td><form action="changeClassify.php?id='.$rows['id'].'" method="post"><select name="classify"><option value="" selected>-请选择-</option><option value="2" >管理员</option>;<option value="1">一般用户</option>; ';
if($classify == "超级管理员")
	{
 echo '<option value="3">超级管理员</option>';}
 echo '</select><input type="submit" value="确认" style="background:grey;" /></form></td><td>'.$rows['ip'].'</td><td>'.$rows['addtime'].'</td><td> ';
if($rows['username'] == $sessionuser)
	{
   echo '<a href="#">删除</a></td></tr>';
    }
	else
	{
    echo '<a href="deleteUser.php?id='.$rows['id'].'" style="color:red;">删除</a></td></tr>
    ';}
}
?>

</tbody>
</table>
<p style="margin-left:70em;">
<?php
for($i=1;$i<=$pagecount;$i++)
{
	if($currpage == $i)
	{
	echo $i;
	}
	else
	{
     echo "<a href='allUser.php?page=".$i."'>$i</a>";
	}
}
?>
</p>
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
<p style="position:relative;margin:-2em 3em;"><a href="register.php">没有账号?去注册</a></p>
</div>
<script  src="../js/login.js"></script>
<script>
function back()
{
location.href="adminInfo.php?id=<?php echo $id;?>";
}
</script>
</body>
</html>