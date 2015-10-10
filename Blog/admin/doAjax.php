<?php
header('content-type:text/html; charset=gb2312');
error_reporting(0);
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

$username=$_GET['username'];
$re=mysql_query("select * from admin where username='$username'");
$row=mysql_fetch_row($re);
$res=$row[0];
if($res)
{
 echo "用户名已被使用";
}
else
{
  echo "ok";
}

?>