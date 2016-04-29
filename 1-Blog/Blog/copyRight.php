<?php
header("content-type:text/html; charset=gb2312");

$file=fopen("copyRight.txt","r")or die("读取版权文件失败");
echo fread($file,filesize("copyRight.txt"));
fclose($file);
?>