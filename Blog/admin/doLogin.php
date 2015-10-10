<?php
header('content-type:text/html; charset=gb2312');

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names gb2312');

$username=$_POST['username'];
$password=$_POST['password'];
$confirm=$_POST['confirm'];
$password=md5($password);
$isok=mysql_query("select * from admin where username='$username' and password='$password'");
$row=mysql_fetch_row($isok);
$ok=$row[0];
if($ok)
{
  session_start();
  $_SESSION['sessionuser']=$username;
  mysql_query("update admin set logintime=now() where username='$username'");
  echo "<script>window.history.back();</script>";
}
else
{
   echo "<script>alert('µÇÂ¼Ê§°Ü');location.href='index.php';</script>";
}
?>