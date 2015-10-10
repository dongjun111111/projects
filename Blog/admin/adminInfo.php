<?php
header("content-type:text/html; charset=utf-8");
session_start();
$sessionuser=$_SESSION['sessionuser'];
if(!$sessionuser)
{
 echo "<script>alert('禁止非法访问');location.href='../index.php';</script>";
 exit;
}

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names gb2312');

$id=$_GET['id'];
$info=mysql_query("select * from admin where id='$id'");
while($row=mysql_fetch_array($info))
{
  $username=$row['username'];
  $sex=$row['sex'];
  $qq=$row['qq'];
  $phone=$row['phone'];
  $email=$row['email'];
  $ip=$row['ip'];
  $addtime=$row['addtime'];
  $outtime=$row['outtime'];
  $classify=$row['classify'];
  $photo=$row['photo'];
}

?>
<!doctype html>
<html>
<head>
<title><?php echo $username;?>的详细信息</title>
<link href="../css/init.css" rel="stylesheet" type="text/css">
<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/adminInfo.css" rel="stylesheet" type="text/css">
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
 <a href="javascript:void(0)" onclick="start()"><img src="./images/login.png" height="80px" width="80px" alt="Login" /></a>
 ';
}
else
{
  echo '
 <a href="./admin/adminInfo.php?id='.$id.'"><img  style="margin-top:10px;" src="'.$photo.'" height="40px" width="40px" alt="'.$username.'"/></a><a href="../loginOut.php" ><b>登出</b></a>
   ';
}
?>
</p>
</div>
<div id="infoContent">
<form action="doAdminInfo.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $id;?>" />
用户:<input type="text" name="username" value="<?php echo $username;?>" /><br>
头像:<input type="file" name="photo" /><img src="<?php echo $photo;?>" height="30em" width="30em" alt="<?php echo $username;?>" /><br>
性别:<select  name="sex">
<option value="male"<?php if($sex == 'male'){echo 'selected';}?> >男</option>
<option value="female" <?php if($sex == 'female'){echo 'selected';}?> >女</option>
</select><br>
秋秋:<input type="text" name="qq" value="<?php echo $qq;?>" /><br>
手机:<input type="text" name="phone" value="<?php echo $phone;?>"/><br>
邮箱:<input type="text" name="email" value="<?php echo $email;?>" /><br>
登录IP:<label><?php echo $ip;?></label><br>
加入时间:<label><?php echo $addtime;?></label><br>
上次登出:<label><?php echo $outtime;?></label><br>
<?php
if($classify == "3")
{echo "权限:<select name='classify'>
<option value='3'>超级管理员</option>
<option value='2'>管理员</option>
<option value='1'>一般用户</option>
</select><br>";}
?>
<input type="submit" value="刷新" class="submit" />
</form>
</div>
<div id="footer">
<p><a href="../copyRight.php">版权声明</a>&nbsp|&nbsp<a href="http://dongjun111111.github.io/D-Jason.html">关于作者</a>&nbsp|&nbsp<a href="../contact.php">联系作者</a></p><br>
<p>Copyright © 1998 - 2015 D-Jason. All Rights Reserved</p>
</div>


</body>
</html>