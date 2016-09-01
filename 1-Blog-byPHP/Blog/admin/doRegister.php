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
$username=$_POST['username'];
$sex=$_POST['sex'];
$qq=$_POST['qq'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$password=$_POST['password'];
$confirm=$_POST['confirm'];
$ip=$_SERVER['REMOTE_ADDR'];

if($password != $confirm)
{
  echo "<script>alert('请重新输入');</script>";
  exit;
}
$password=md5($password);
$isok=mysql_query("insert into admin(username,sex,email,phone,password,qq,ip,addtime,classify) values ('$username','$sex','$email','$phone','$password','$qq','$ip',now(),'一般用户')");
if($isok)
{
  echo "<script>alert('注册成功');location.href='../index.php';</script>";
}
else
{
   echo "<script>alert('注册失败');location.href='../index.php';</script>";
}
?>