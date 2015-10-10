<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>创建新文章</title>
<style>
*{margin:0;padding:0;}
  div {height:1.5em;width:1.5em;background:red;margin:1px;overflow:hidden;}
  </style>
</head>
<body>
  <div>D-Jason,欢迎您!</div>
  <script>
  window.onload=function()
  {
  var divs=document.getElementsByTagName("div");
  var timer=null;
  for(var i=0;i<divs.length;i++)
	  {
		  divs[i].timer=null;
	  divs[i].onmouseover=function()
		  {
       startMove(this,400);
		  }
		   divs[i].onmouseout=function()
		  {
       startMove(this,50);
		  }
	  }
  }
  function startMove(obj,iTarget)
  {
	  clearInterval(obj.timer);
     obj.timer=setInterval(function(){
		 speed=(iTarget-obj.offsetWidth)/6;
		 speed=speed>0?Math.ceil(speed):Math.floor(speed);
		 if(obj.offsetWidth==iTarget)
		 {clearInterval(obj.timer);}
		 else
		 {
          obj.style.width=obj.offsetWidth+speed+"px";
		 }
		},30);
  }
  </script>
</body>
</html>