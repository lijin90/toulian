// JavaScript Document
function moveUp(objId){
	var oDiv=document.getElementById(objId);
	var ind=0;
	var timer=null;
	var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
	if (window.navigator.userAgent.indexOf("MSIE 6")!=-1){
		oDiv.style.top=scrollTop+document.documentElement.clientHeight-oDiv.offsetHeight+"px";
	}else{
		oDiv.style.position="fixed";
	}
	oDiv.onclick=function (){
		ind=0;
		clearInterval(timer);
		var start=scrollTop;
		var change=-start;
		timer=setInterval(function (){
			ind++;
			if (ind>=20){
				clearInterval(timer);
			}
			document.documentElement.scrollTop=Tween.Cubic.easeInOut(ind,start,change,20);
			document.body.scrollTop=Tween.Cubic.easeInOut(ind,start,change,20);
		},25);
	}
}	