<?php
$id=$_GET['id'];

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

$delete=mysql_query("delete from admin where id='$id'");
if($delete)
{
 echo "<script>alert('删除成功');location.href='allUser.php';</script>";
}
else
{
 echo "<script>alert('删除失败');location.href='allUser.php';</script>";

}
?>