var hintInterval = 0.1;
var interval = 0;
var mainInterval;
var hintObject;
var hintDiv;
var hintObjects = new Array();

function initHint()
{
	if(null == hintDiv)
	{
	    document.write("<div id='hintDiv'></div>");
	    hintDiv = document.getElementById("hintDiv");
    	with(hintDiv.style)
     	{
     		position = "absolute";
     		padding = "0px";
     		color = "#E5CEA6";
     		border = "0";
     		width = 200;
     		left = -1000;
     		backgroundColor = "#ffffff";
     		display = "none";
     		zIndex = 100;
     	}
	 common.setOpacity(hintDiv,95);


	}


}

function objText(obj, txt)
{
     this.obj = obj;
     this.txt = txt;
}
function getHintText(obj)
{
     for(var i=0; i<hintObjects.length;i++)
     {
     	 var curr = obj;
     	 while (true)
     	 {
     	 	if(curr == null)break;
     	 	if(hintObjects[i].obj == curr)break;
     	 	curr = curr.parentNode;
     	 }
          if(curr != null)
               return hintObjects[i].txt;
     }
     return null;
}

function addHint(obj, html)
{
     hintObjects.push(new objText(obj,html));
     obj.onmouseover = hintObjectOver;     
     obj.onmouseout = hintObjectOut;     
     obj.onmousedown = hintObjectMouseDown;
}
function stopInterval()
{
     window.clearInterval(mainInterval);
     interval = 0;
}
function hintObjectOver(evt)
{
	 hintObject = evt?evt.target:event.srcElement;

     mainInterval = window.setInterval(checkHint,100);
}
function checkHint()
{
     interval += 0.1;
     if(interval > hintInterval)
     {
          showHint();
          stopInterval();
          
     }
}
function showHint()
{
     if(!draging)
     {
     	  var text = getHintText(hintObject);
     	  if(null != text)
     	  {
          	hintDiv.innerHTML = text;
          	hintDiv.style.left = mouseX+10;
          	hintDiv.style.top = mouseY+10;

          	hintDiv.style.display = "block";

          }

     }
}
function hintObjectOut(evt)
{
     hintDiv.style.display = "none";
     stopInterval();
     draging = false;
     hintObject = null;
}
function hintObjectMouseDown(evt)
{
     hintDiv.style.display = "none";
     stopInterval();
     draging = false;
     hintObject = null;
     //window.event.srcElement.style.backgroundColor = "#ffff00";
}
