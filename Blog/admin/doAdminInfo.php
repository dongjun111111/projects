<?php
header("content-type:text/html; charset=gb2312");
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

$id=$_POST['id'];
$username=$_POST['username'];
$photo=$_FILES['photo'];
$sex=$_POST['sex'];
$qq=$_POST['qq'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$ip=$_SERVER['REMOTE_ADDR'];
$isphoto=isset($_FILES['photo']['size'])?$_FILES['photo']['size']:0;
if($isphoto > 0)
{
    $arr=explode(".",$_FILES['photo']['name']);//将文件名按点分成数组
    $hz=$arr[count($arr)-1];//取得文件后缀名
	$filepath="../uploads/";//定义文件上传路径
	$randname=date("Y").date("m").date("d").date("H").date("i").date("s").rand(100,999).".".$hz;//重命名
	if(is_uploaded_file($_FILES['photo']['tmp_name']))
	{
	 if(move_uploaded_file($_FILES['photo']['tmp_name'],$filepath.$randname))
		{
		echo "上传成功";
		}
		else
		{
		 echo "上传失败";
		}
	}
	else
	{
	 echo "不是一个上传文件";
	 exit;
	  }

   $photo=$filepath.$randname;

    $result=mysql_query("update admin set username='$username',photo='$photo',sex='$sex',qq='$qq',ip='$ip',phone='$phone',email='$email' where id='$id'");
	if(isset($result))
	{
	 echo "<script>alert('修改成功');location.href='../index.php';</script>";
	}
	else
	{
	 echo "<script>alert('修改失败');location.href='../index.php';</script>";
	}
}

else
{
	$result=mysql_query("update admin set username='$username',sex='$sex',qq='$qq',ip='$ip',phone='$phone',email='$email' where id='$id'");
	if(isset($result))
	{
	 echo "<script>alert('修改成功');location.href='../index.php';</script>";
	}
	else
	{
	 echo "<script>alert('修改失败');location.href='../index.php';</script>";
	}

}

?>