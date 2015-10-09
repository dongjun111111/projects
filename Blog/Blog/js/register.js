var register=document.getElementById('step');
var aBtn=register.getElementsByTagName('input');
var register2=document.getElementById('showeverystep');
var aDiv=register2.getElementsByTagName('div');
var oUsername=document.getElementById('username');
for(var i=0;i<aBtn.length;i++)
{
	aBtn[i].index=i;
	aBtn[i].onclick=function()
	{  
	   for (var i=0;i<aBtn.length ;i++ )
	   {
		   aBtn[i].className="";
		   aDiv[i].className="";
	   }
	   this.className="selected";
	   aDiv[this.index].className="active";
	}
}