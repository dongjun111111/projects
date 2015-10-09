<?php
session_start();
$username=$_SESSION['sessionuser'];

$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set names gb2312');

mysql_query("update admin set outtime=now() where username='$username' ");
session_destroy();
unset($_SESSION['sessionuser']);
echo "<script>location.href='index.php';</script>";
?>