/////////////
// Rainbow //
/////////////
var rate = 20;
if (document.getElementById)
window.onerror=new Function("return true")
var objActive;
var act = 0;
var elmH = 0;
var elmS = 128;
var elmV = 255;
var clrOrg;
var TimerID;
var IE = 0;
var Mozilla = 0;
var szUA = navigator.userAgent;
if (szUA.indexOf("MSIE 5.") >= 0) {
    IE = 5;
}
else if (szUA.indexOf("Mozilla/5.") >= 0) {
    Mozilla = 6;
}
else if(szUA.indexOf("MSIE 4.") >= 0) {
    IE = 4;
}
else if(szUA.indexOf("Mozilla/4.") >= 0) {
    Mozilla = 4;
}
if (IE >= 4) {
    document.onmouseover = doRainbowAnchor;
    document.onmouseout = stopRainbowAnchor;
}
else if (Mozilla >= 6) {
    document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT);
    document.onmouseover = Mozilla_doRainbowAnchor;
    document.onmouseout = Mozilla_stopRainbowAnchor;
}
function doRainbow(obj)
{
    if (act == 0) {
        act = 1;
        if (obj)
            objActive = obj;
        else
            objActive = event.srcElement;
        clrOrg = objActive.style.color;
        TimerID = setInterval("ChangeColor()",100);
    }
}
function stopRainbow()
{
    if (act) {
        objActive.style.color = clrOrg;
        clearInterval(TimerID);
        act = 0;
    }
}
function doRainbowAnchor()
{
    if (act == 0) {
        var obj = event.srcElement;
        while (obj.tagName != 'A' && obj.tagName != 'BODY') {
            obj = obj.parentElement;
            if (obj.tagName == 'A' || obj.tagName == 'BODY')
                break;
        }

        if (obj.tagName == 'A' && obj.href != '') {
            objActive = obj;
            act = 1;
            clrOrg = objActive.style.color;
            TimerID = setInterval("ChangeColor()",100);
        }
    }
}
function stopRainbowAnchor()
{
    if (act) {
        if (objActive.tagName == 'A') {
            objActive.style.color = clrOrg;
            clearInterval(TimerID);
            act = 0;
        }
    }
}
function Mozilla_doRainbowAnchor(e)
{
    if (act == 0) {
        obj = e.target;
        while (obj.nodeName != 'A' && obj.nodeName != 'BODY') {
            obj = obj.parentNode;
            if (obj.nodeName == 'A' || obj.nodeName == 'BODY')
                break;
        }

        if (obj.nodeName == 'A' && obj.href != '') {
            objActive = obj;
            act = 1;
            clrOrg = obj.style.color;
            TimerID = setInterval("ChangeColor()",100);
        }
    }
}
function Mozilla_stopRainbowAnchor(e)
{
    if (act) {
        if (objActive.nodeName == 'A') {
            objActive.style.color = clrOrg;
            clearInterval(TimerID);
            act = 0;
        }
    }
}
function ChangeColor()
{
    objActive.style.color = makeColor();
}
function makeColor()
{
    if (elmS == 0) {
        elmR = elmV;    elmG = elmV;    elmB = elmV;
    }
    else {
        t1 = elmV;
        t2 = (255 - elmS) * elmV / 255;
        t3 = elmH % 60;
        t3 = (t1 - t2) * t3 / 60;

        if (elmH < 60) {
            elmR = t1;  elmB = t2;  elmG = t2 + t3;
        }
        else if (elmH < 120) {
            elmG = t1;  elmB = t2;  elmR = t1 - t3;
        }
        else if (elmH < 180) {
            elmG = t1;  elmR = t2;  elmB = t2 + t3;
        }
        else if (elmH < 240) {
            elmB = t1;  elmR = t2;  elmG = t1 - t3;
        }
        else if (elmH < 300) {
            elmB = t1;  elmG = t2;  elmR = t2 + t3;
        }
        else if (elmH < 360) {
            elmR = t1;  elmG = t2;  elmB = t1 - t3;
        }
        else {
            elmR = 0;   elmG = 0;   elmB = 0;
        }
    }

    elmR = Math.floor(elmR).toString(16);
    elmG = Math.floor(elmG).toString(16);
    elmB = Math.floor(elmB).toString(16);
    if (elmR.length == 1)    elmR = "0" + elmR;
    if (elmG.length == 1)    elmG = "0" + elmG;
    if (elmB.length == 1)    elmB = "0" + elmB;

    elmH = elmH + rate;
    if (elmH >= 360)
        elmH = 0;

    return '#' + elmR + elmG + elmB;
}
/////////////
// PopHelp //
/////////////
Xoffset=-60;
Yoffset= 20;
var old,skn,iex=(document.all),yyy=-1000;
var ns4=document.layers
var ns6=document.getElementById&&!document.all
var ie4=document.all
if (ns4)
skn=document.dek
else if (ns6)
skn=document.getElementById("dek").style
else if (ie4)
skn=document.all.dek.style
if(ns4)document.captureEvents(Event.MOUSEMOVE);
else{
skn.visibility="visible"
skn.display="none"
}
function popup(msg,bak){
var content="<TABLE  WIDTH=150 BORDER=1 BORDERCOLOR=black CELLPADDING=2 CELLSPACING=0 "+
"BGCOLOR="+bak+"><TD ALIGN=center><FONT COLOR=black SIZE=2 Face=Verdana>"+msg+"</FONT></TD></TABLE>";
yyy=Yoffset;
 if(ns4){skn.document.write(content);skn.document.close();skn.visibility="visible"}
 if(ns6){document.getElementById("dek").innerHTML=content;skn.display=''}
 if(ie4){document.all("dek").innerHTML=content;skn.display=''}
 var x=(ns4||ns6)?e.pageX:event.x+document.body.scrollLeft;
 skn.left=x+Xoffset;
 var y=(ns4||ns6)?e.pageY:event.y+document.body.scrollTop;
 skn.top=y+yyy;
}
function kill(){
yyy=-1000;
if(ns4){skn.visibility="hidden";}
else if (ns6||ie4)
skn.display="none"
}

/////////////
// vlbook  //
/////////////
function dispadd() {
  if (document.getElementById('floater').style.display == 'none') {
  	pagemaskOn(70);
    document.getElementById('floater').style.display = '';
    alignCenter(document.getElementById('floater'));
  } else {
  	document.getElementById('floater').style.display = 'none';
  	pagemaskOff();
  }
}
function alignCenter(obj) {
	var objHidden = false;
	if (obj.style.display == "none") {
		obj.style.display = "";
		objHidden = true;
	}
	obj.style.top = (document.body.scrollTop+((document.body.clientHeight-obj.clientHeight)/2))+"px";
	obj.style.left = (document.body.scrollLeft+((document.body.clientWidth-obj.clientWidth)/2))+"px";
	
	if (objHidden) obj.style.display = "none";
}

//////////////
// pagemask //
//////////////

var maskObjName = "pagemask";

document.write("<div style='position: absolute; z-index: 2; display:none; background-color: #ffffff' id='" + maskObjName + "' onclick=null></div>");

function pagemaskOn(percentTrans) {
	if (percentTrans == null) percentTrans = 50;
    document.getElementById(maskObjName).style.display = "";                       	
    document.getElementById(maskObjName).style.top = document.body.scrollTop;      
   	document.getElementById(maskObjName).style.left = document.body.scrollLeft;    
    document.getElementById(maskObjName).style.width = document.body.clientWidth;  
    document.getElementById(maskObjName).style.height = document.body.clientHeight;
    document.getElementById(maskObjName).style.filter = "alpha(opacity=" + percentTrans + ")";
    document.getElementById(maskObjName).style.MozOpacity = (percentTrans/100);
}

function pagemaskOff() {
    document.getElementById(maskObjName).style.display = "none"; 
}

function pagemaskUpdate() {
    document.getElementById(maskObjName).style.top = document.body.scrollTop; 
   	document.getElementById(maskObjName).style.left = document.body.scrollLeft; 
    document.getElementById(maskObjName).style.width = document.body.clientWidth;
   	document.getElementById(maskObjName).style.height = document.body.clientHeight;
}

window.attachEvent('onresize', pagemaskUpdate);
window.attachEvent('onscroll', pagemaskUpdate);
