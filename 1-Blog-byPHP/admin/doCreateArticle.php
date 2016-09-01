<?php
session_start();
if(!$_SESSION['sessionuser'])
{
  echo "<script>alert('禁止非法访问');location.href='index.php';</script>";
  exit;
}
$conn=mysql_connect('localhost','root','903456967');
mysql_select_db('blog');
mysql_query('set name utf8');

/*function magic($str)
{
 $str=trim($str);
 if(!get_magic_quotes_gpc())
	{
    $str=addslashes($str);
   }
 return htmlspecialchars($str);
} */
$title=$_POST['title'];
$content=$_POST['content'];
$author=$_SESSION['sessionuser'];

$create=mysql_query("insert into article(author,title,content,createtime) values ('$author','$title','$content',now())");
if($create)
{
 echo "<script>alert('发表成功');location.href='../article.php';</script>";
}
else
{
 echo "<script>alert('发表失败');window.history.back();</script>";
}
?>