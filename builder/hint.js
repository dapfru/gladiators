var hintInterval = 0.1;
var interval = 0;
var mainInterval;
var hintObject;
var hintDiv;
var tacticsDiv;
var hintObjects = new Array();
var hintMode = true;
var lastBorder="";
var lastControl=null;

function initHint2()
{

	if(null == tacticsDiv)
	{
	    document.write("<div id='tacticsDiv'></div>");
	    tacticsDiv = document.getElementById("tacticsDiv");
    	with(tacticsDiv.style)
     	{
     		position = "absolute";
     		padding = "0px";
     		color = "#E5CEA6";
     		border = "0";
     		width = 210;
     		left = -1000;
     		backgroundColor = "#FFE0AA";
     		display = "none";
     		zIndex = 100;
     	}
//	 common.setOpacity(tacticsDiv,95);


	}


}

function initHint()
{
initHint2();
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
     		backgroundColor = "#FFE0AA";
     		display = "none";
     		zIndex = 100;
     	}
	 common.setOpacity(hintDiv,95);


	}


}

function objText(obj, txt,tacticsHtml)
{
     this.obj = obj;
     this.txt = txt;
     this.tacticsHtml=tacticsHtml;
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


function getHintData(obj)
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
               return hintObjects[i];
     }
     return null;
}


function addHint(obj, player, html,tacticsHtml)
{
     hintObjects.push(new objText(obj,html,tacticsHtml));
     obj.onmouseover = hintObjectOver;     
     obj.onmouseout = hintObjectOut;     
     obj.onmousedown = hintObjectMouseDown;
     obj.oncontextmenu = hintObjectContextMenu;
     obj.player=player;
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

function showHint2()
{
     if(!draging)
     {
     	  var data = getHintData(hintObject);
     	  if(null != data)
     	  {
//          	tacticsDiv.innerHTML = data.tacticsHtml;
//          	tacticsDiv.style.left = 500;//mouseX;//+10;
//          	tacticsDiv.style.top = 200;//mouseY;//-210;

//          	tacticsDiv.style.display = "block";
		var el=document.getElementById("rpLabel4");
		el.style.display = "block";
		
		var attackTrB=findSlider("attackTrB");
		var powerTrB=findSlider("powerTrB");
	        var blockTrB=findSlider("blockTrB");
	        var courageTrB=findSlider("courageTrB");
		attackTrB.enableHint=false;
		powerTrB.enableHint=false;
		blockTrB.enableHint=false;
		courageTrB.enableHint=false;


          }

     }
}

function showHint()
{
  if (!hintMode)
    return;
  
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

function hintObjectContextMenu(evt)
{
  return false;
}

function maphintObjectToPlayer()
{

  return null;
}

function findSlider(name)
{
for (var i=0; i<window.sliders.length; i++)
  if (window.sliders[i].name==name)
    return window.sliders[i];
return null;    
/*
  var inputs = document.getElementsByTagName("input");
  for(var i=0; i<inputs.length; i++)
  {
    if((inputs[i].className == className) && (true))
    {
      return inputs[i];
    }
  }
  alert("123");
  return null;
  */
}

function hintObjectMouseDown(evt)
{
evt=evt?evt:event;
//  if (evt.shiftKey)//(evt.button==2) 
  {

  if (lastControl!=null)
    lastControl.style.border=lastBorder;
  lastControl=hintObject;
  lastBorder=lastControl.style.border;
    hintObject.style.border="1px solid #00C905";

    var data=getHintData(hintObject);
    var player=data.obj.player;
    var oldplayer=tacticsDiv.player;
    tacticsDiv.player=player;
//    hintMode=false;
    showHint2();

    var attackTrB=findSlider("attackTrB");
    var powerTrB=findSlider("powerTrB");
    var blockTrB=findSlider("blockTrB");
    var courageTrB=findSlider("courageTrB");
    
    if (oldplayer!=null)
    {
      oldplayer.attack=attackTrB.GetValue();
      oldplayer.power=powerTrB.GetValue();
      oldplayer.block=blockTrB.GetValue();
      oldplayer.courage=courageTrB.GetValue();    
    }
    
	attackTrB.SetValue(player.attack);
	powerTrB.SetValue(player.power);
	blockTrB.SetValue(player.block);
	courageTrB.SetValue(player.courage);
    
	document.getElementById("personaltactics").innerHTML='Тактика '+player.name;

	//document.getElementById("hintdiv").style.marginTop=90;

  }
//  else
  {
     hintDiv.style.display = "none";
     stopInterval();
     draging = false;
     hintObject = null;
     //window.event.srcElement.style.backgroundColor = "#ffff00";
  }     
}
