


function Point(x,y)
{
	this.X = x;
	this.Y = y;
}
function SetAllPlayersToBase()
{
	for(var i=0; i<zones.length;i++)
	{
		var arrPlayers = new Array();
		for(var j=0; j<zones[i].players.length;j++)
		{
			arrPlayers.push(zones[i].players[j]);
		}
		for(var j=0; j<arrPlayers.length;j++)
		{
			SetPlayerToBase(arrPlayers[j].playerDiv,zones[i]);		}	}
}

function schema_change(value)
{
	if(value == "0")
		return;
	SetAllPlayersToBase();
	var zoneValues = value.split(',');
	var addedPlayers = new Array();
	var skippedZones = new Array();
	for(var i=0; i< zoneValues.length; i++)
	{
		var pos = zoneValues[i].toLowerCase();
		var count = 1;

		for(var c=0; c< count; c++)
		{
			var maxSkill = 0;
			var maxSkillPlId = 0;
			var maxSkillAll = 0;
			var maxSkillPlIdAll = 0;

			for(var j=0; j<players.length; j++)
			{
				if(!addedPlayers[players[j].GladiatorID])
				{
					//if(players[j].Position.toLowerCase() == pos || players[j].Combination.toLowerCase() == pos)
					//{



						if((players[j].Stamina * players[j].Level) > maxSkill && players[j].Injury == 0)
						{
							maxSkill = players[j].Stamina * players[j].Level;	
							maxSkillPlId = players[j].GladiatorID;
						}
					//}
					if((players[j].Stamina * players[j].Level) > maxSkillAll && players[j].Injury == 0)
					{
						maxSkillPlIdAll = players[j].GladiatorID;
						maxSkillAll = players[j].Stamina * players[j].Level;
					}
				}
				
			}


			if(maxSkillPlId)
			{
				AddPlayerToZoneById(getZoneById(pos),maxSkillPlId);
				addedPlayers[maxSkillPlId]=1;
			}
			else
			{
				AddPlayerToZoneById(getZoneById(pos),maxSkillPlIdAll);
				addedPlayers[maxSkillPlIdAll]=1;
			}

			
		}
	}

UnhighLightZones();

}
function getPlayerDivByPlayer(player)
{
		for(i=0; i<playersCount; i++)
		{
			if(players[i].GladiatorID == player.GladiatorID)
				return document.getElementById("player"+i);
		}
}
function getZoneByDiv(zoneDiv)
{	
	var zone = null;
	for(z = 0; z< zonesCount; z++)
	{
		if(zones[z].zoneDiv == zoneDiv)
		{
			zone = zones[z];
			break;
		}
	}
	return zone;


}




function containsPlayer(zone,player)
{
	for(var c = 0; c<zone.players.length; c++)
	{
		if(zone.players[c].GladiatorID == player.GladiatorID)
		{
			return true;
		}
	}
	return false;
}





function getPlayerById(GladiatorID)
{
	var player = null;
	for(p = 0; p< playersCount; p++)
	{
		if(players[p].GladiatorID == GladiatorID)
		{
			player = players[p];
			break;
		}
	}
	return player;

}
function getPlayerByDiv(playerDiv)
{
	var player = null;
	for(p = 0; p< playersCount; p++)
	{
		if(players[p].playerDiv == playerDiv)
		{
			player = players[p];
			break;
		}
	}
	return player;
}
function AddPlayerToZone(zoneDiv, playerDiv)
{
	var zone = getZoneByDiv(zoneDiv);



	var player = getPlayerByDiv(playerDiv);

	

	if(player.Injury > 0)
	{
		alert("игрок "+player.name+" травмирован!");
		SetPlayerToBase(player.playerDiv);
		RebuildZone(zone);
		return false;
		
	}


	if(!containsPlayer(zone,player))
	{
		var tmp = zone.players;
		zone.players = new Array();
		var pushPos = 2;
		var distanceFromCenter = 0;
		var playerX = (window.event)?(event.clientX-targetStartX)+targetObjectStartX:common.getPixels(playerDiv.style.left);
		distanceFromCenter = (common.getPixels(zoneDiv.style.width)/2)
								-(playerX - common.getPixels(zoneDiv.style.left));
		if(distanceFromCenter > 30 && tmp.length > 0)
			pushPos = 0;
			
		
		if(distanceFromCenter > 0 && distanceFromCenter < 30 && tmp.length > 0)
			pushPos = 1;
		for(var i = 0; i<tmp.length; i++)
		{
			if(pushPos == i)
				zone.players.push(player);
			
			zone.players.push(tmp[i]);
		}
		if(pushPos == 2)
			zone.players.push(player);

		player.Zone = zone;
	}

	RebuildZone(zone);
	return true;

}
function setSubscribtion(player)
{
	var playerDiv = getPlayerDivByPlayer(player);
	//document.getElementById("playerSubscriptName"+player.GladiatorID).style.display = "inline";
	var subscription = document.getElementById("playerSubscriptName"+player.GladiatorID);
	with(subscription.style)
	{
		display = "inline";
		top = common.getPixels(playerDiv.style.top)+common.getPixels(playerDiv.parentNode.style.top)+20;
		left = common.getPixels(playerDiv.style.left)+common.getPixels(playerDiv.parentNode.style.left)-(subscription.clientWidth/2 - 11);
	}
}
function AddPlayerToZoneById(zone, GladiatorID)
{
	var player = getPlayerById(GladiatorID);



	if(!player)
		return;



	if(player.Injury > 0)
	{
		alert(player.name+" травмирован!");
		SetPlayerToBase(player.playerDiv);
		RebuildZone(zone);
		return false;
		
	}


	if(!containsPlayer(zone,player))
	{
		zone.players.push(player);
		player.Zone = zone;
	}
	//RefreshRoles(player,1);
	RebuildZone(zone);
	return true;
}


function RemovePlayerFromZone(playerDiv)
{


	for(var i=0;i<zonesCount; i++)
	{
		br = false;
		for(var j=0; j<zones[i].players.length; j++)
		{
			if(zones[i].players[j].playerDiv == playerDiv)
			{
				//RefreshRoles(zones[i].players[j],0);
				zones[i].players[j].Zone = null;

				zones[i].players.splice(j,1);
				br = true;
				break;
			}
		}
		if(br)
		{
			RebuildZone(zones[i]);
			break;
		}
	}
	
}
function RebuildZone(zone)
{
	var modWidth = (common.getPixels(zone.zoneDiv.style.width) / (zone.players.length+1))+5;
	var currPos = common.getPixels(zone.zoneDiv.style.left)+modWidth;

	for(var i = 0; i< zone.players.length; i++)
	{
		zone.players[i].playerDiv.style.left =  currPos-13;
		zone.players[i].playerDiv.style.top =  common.getPixels(zone.zoneDiv.style.top)+13;
		zone.players[i].playerDiv.style.zIndex = 10;
		if(zone.id.substring(0,2).toLowerCase() != "rp")
			setSubscribtion(zone.players[i]);
		currPos += modWidth;
	}
	zone.zoneDiv.style.zIndex = 9;

	count=0;
	sum=0;


	if(document.getElementById("LeaderID")) var select=document.getElementById("LeaderID");	
	if(select) var val=select.value;
	else var val=0;



	if(document.getElementById("LeaderID")) var leader=document.getElementById("LeaderID").value;
	else var leader=0;

	var sum=0;

	for(var i=0; i< zones.length; i++)
	{
			count += zones[i].players.length;
			if(zones[i].players.length) 
			{
					player=getPlayerByDiv(zones[i].players[0].playerDiv);

					if(player.GladiatorID==val) zones[i].zoneDiv.className="hightlightleader";

					sum += Math.round(player.Level);

			}

	}


if(document.getElementById('GladLimit').value>0)	document.getElementById('GladLeft').value=document.getElementById('GladLimit').value-count;
if(document.getElementById('SklLimit').value>0) document.getElementById('SklLeft').value=document.getElementById('SklLimit').value-sum;


}


	

var ZoneBackColor = "#ffffff";
var ZoneBackColorLight = "#ffffff";
var targetObject;
var targetStartX;
var targetStartY;
var targetObjectStartX;
var targetObjectStartY;
var offsetX,offsetY;
var captureZone;
var zonePlayers = new Array();


	function Drag(evt)
	{
		if(targetObject)
		{
			draging = true;
			var clientX,clientY;
	
			clientX = evt?evt.clientX:event.clientX;
			clientY = evt?evt.clientY:event.clientY;



			targetObject.style.left = (clientX-targetStartX)+targetObjectStartX;

			targetObject.style.top = (clientY-targetStartY)+targetObjectStartY;


			var zone = findZone(evt,getPlayerByDiv(targetObject))
			
			if(zone)
			{
				if(captureZone)
				{
					captureZone.className = "zone";
					var pl = getPlayerByDiv(targetObject);
					HighLightZones(pl);
					captureZone = null;
				}

					captureZone = zone;
					captureZone.className = "hilightZone";

			}
		}
	}



	
	function SetPlayerToBase(playerDiv, zone)
	{
		var pl = getPlayerByDiv(playerDiv);

		document.getElementById("playerSubscriptName"+pl.GladiatorID).style.display = "none";

		document.getElementById("playerSubscript"+pl.GladiatorID).className = "subscriptRight";
		var startX=0;
		var x = 0;
		var col=0;
		var colsFilled = 0;
		var maxX = 0;

		var matrixPos = "";
		


			startX = 23+forvTop;
			maxX = forvHeight+forvTop;
			matrixPos = "fw";
			pos="lf";

		for(i=0; i<playersCount; i++)
		{




			col =0;

			if(document.getElementById("player"+i) == playerDiv)			
			{	

				while(true)
				{
					if(col == 3)
						col = 0;
							

						if(square)
							square.appendChild(playerDiv);
						playerDiv.style.top = x*24+startX;
						playerDiv.style.left = 3;
						if(zone)
						{
							RemovePlayerFromZone(playerDiv)
						}
						CheckTasks(players[i]);
						CheckRoles(players[i]);
						CheckSubs(players[i]);
						break;


					col ++;
				}
			}

x ++;
			
		}
	}
	
	function EndDrag(evt)
	{
		draging = false;
		if(targetObject)
		{

			
			var xPos = evt?evt.clientX:event.clientX;

			if(common.getPixels(targetObject.style.left) < 300 || null == captureZone)
			{
				SetPlayerToBase(targetObject);
				if(captureZone)
				{
					//common.setOpacity(captureZone,10);
					captureZone.className="zone";
					
					RebuildZone(getZoneByDiv(captureZone));
				}
			}
			else
			{				
//if exist captured zone (zone to drop dragged player)	

				if(captureZone)				
				{					
					var pl = getPlayerByDiv(targetObject);
					UnhighLightZones(pl);


					captureZone.className="zone";
					targetObject.style.pixelLeft = common.getPixels(captureZone.style.left)+5;
					targetObject.style.pixelTop = common.getPixels(captureZone.style.top)+6;
					targetObject.style.zIndex = 10;
					captureZone.style.zIndex = 9;

					AddPlayerToZone(captureZone, targetObject);



					captureZone = null;

				}
			}


			var pl = getPlayerByDiv(targetObject);
			UnhighLightZones(pl);
			captureZone = null;
			targetObject = null;
		}

	}





	function findZone(evt,pl)
	{
		var zone = null;
		var x = (evt?evt.clientX:event.clientX) - targetStartX+targetObjectStartX;
		var y = (evt?evt.clientY:event.clientY) - targetStartY+targetObjectStartY;
		zone = getZoneByXY(x,y);
		if(null != zone && ValidZone(zone,pl))
			return zone.zoneDiv;
		else
			return null;
	}

    function SetTargetObject(evt)
     {
		  if(document.getElementById("schemas")) document.getElementById("schemas").selectedIndex = 0;

          for(i=0; i<playersCount; i++)
          {
               srcEl = evt?evt.target:event.srcElement;


               while(null != srcEl)
               {

                    if(srcEl.id == "player"+i)
                         break;
                    srcEl = srcEl.parentNode;

               }
               

               if(null != srcEl)
               {
			   
                    targetObject = srcEl;
					

		var pl = getPlayerByDiv(targetObject);
		HighLightZones(pl);
		document.getElementById("playerSubscriptName"+pl.GladiatorID).style.display = "none";
		document.getElementById("playerSubscript"+pl.GladiatorID).className = "subscriptRight";
					
               		
                    targetObject.style.zIndex = 11;
                    targetStartX = evt?evt.clientX:event.clientX;

                    targetStartY = evt?evt.clientY:event.clientY;
                    targetObjectStartX = common.getPixels(targetObject.style.left);
                    targetObjectStartY = common.getPixels(targetObject.style.top);
                    RemovePlayerFromZone(targetObject);
                    offsetX = evt?evt.layerX:event.offsetX;
                    offsetY = evt?evt.layerY:event.offsetY;

					Drag(evt);
               }
          }
     }

	var currZoneIdx = 0;




function closeTactics(event)
{
  var target=event.target?event.target:event.srcElement;
  var Parent=target.parentNode;
  Parent.style.display="none";
  var s=findSlider("attackTrB");
  Parent.player.attack=s.GetValue();
  s=findSlider("powerTrB");
  Parent.player.power=s.GetValue();
  s=findSlider("blockTrB");
  Parent.player.block=s.GetValue();
  s=findSlider("courageTrB");
  Parent.player.courage=s.GetValue();
  hintMode=true;  
}  
function makePlayersAndZones()
{
	var x = 0;
	var col = 0;


	for(var i=0; i<playersCount; i++)
	{

		document.write("<div id=\"player"+i+"\" class=\"player\"  unselectable='on'></div>");
		var player = document.getElementById("player"+i);
		player.style.width = 15;
		player.style.height = 15;
		player.style.cursor = "hand";



		if(players[i].Injury > 0)
			player.style.border = "1px solid red";


		var typeid = players[i].TypeID;

		var splitName = players[i].name.split(' ');
		var shortName = players[i].name;
		if(splitName.length > 1)
			shortName =splitName[splitName.length-1];

		if(players[i].injury>0) 
		shortName='<font color=blue>'+shortName+'</font>';

		var imgFile ="../../images/types/"+typeid+".gif";
		
		player.innerHTML = "<center unselectable='on'><center>"
				+"</font><img src='"+
				imgFile+"' style='width:15;height:15' unselectable='on'></img></center></center>";
				
				
		

		document.write("<div id=playerSubscriptName"+players[i].GladiatorID+" class='playerSubscriptName' >"+"<font id=playerSubscript"+players[i].GladiatorID+"></font></div>");
		
		
		var hintHtml = "<table border=1 bordercolor=3B484C width=100% cellspacing=0 cellpadding=4 class=black>";
		hintHtml += "<tr><td colspan=2><img src=step-14.gif><b>"+players[i].name+" ["+Math.round(players[i].Level)+"] </td></tr>";

		hintHtml += "<tr><td>Возраст: </td><td><nobr>"+players[i].Age+"</td></tr>";

		hintHtml += "<tr><td>Физготовность: </td><td><nobr>"+getStripe(players[i].Stamina,true)+" "+players[i].Stamina+"</td></tr>";
		hintHtml += "<tr><td>Мораль: </td><td><nobr>"+getStripe(players[i].Morale,true,5)+" "+players[i].Morale+"</td></tr>";

		hintHtml += "<tr><td>"+getAbilityName('Vit')+": </td><td>"+getStripe(players[i].Vit)+" "+Round(players[i].Vit,1)+"</td></tr>";
		hintHtml += "<tr><td>"+getAbilityName('Dex')+": </td><td>"+getStripe(players[i].Dex)+" "+Round(players[i].Dex,1)+"</td></tr>";
		hintHtml += "<tr><td>"+getAbilityName('Acc')+": </td><td>"+getStripe(players[i].Acc)+" "+Round(players[i].Acc,1)+"</td></tr>";
		hintHtml += "<tr><td>"+getAbilityName('Str')+": </td><td>"+getStripe(players[i].Str)+" "+Round(players[i].Str,1)+"</td></tr>";
		hintHtml += "</table>";


		players[i].playerDiv = player;
		/*
		var tacticsHtml="<table border=1>";
		tacticsHtml+="<TR>";
		tacticsHtml+="<TD style='color:red'>Defence</TD>";
		tacticsHtml+="<TD>"+createSliderHtml('attackTrB','123')+"</TD>";
		tacticsHtml+="<TD style='color:red'>Attack</TD>";
		tacticsHtml+="</TR>";
		tacticsHtml+="<TR>";
		tacticsHtml+="<TD style='color:red'>Speed</TD>";
		tacticsHtml+="<TD>"+createSliderHtml('powerTrB','123')+"</TD>";
		tacticsHtml+="<TD style='color:red'>Power</TD>";
		tacticsHtml+="</TR>";
		tacticsHtml+="<TR>";
		tacticsHtml+="<TD style='color:red'>Dodge</TD>";
		tacticsHtml+="<TD>"+createSliderHtml('blockTrB','123')+"</TD>";
		tacticsHtml+="<TD style='color:red'>Block</TD>";
		tacticsHtml+="</TR>";
		tacticsHtml+="<TR>";
		tacticsHtml+="<TD style='color:red'>Courage</TD>";
		tacticsHtml+="<TD>"+createSliderHtml('courageTrB','123')+"</TD>";
		tacticsHtml+="<TD style='color:red'>Courage</TD>";
		tacticsHtml+="</TR>";
		
		tacticsHtml+="<TR>";
		tacticsHtml+="<TD>Tactics</TD><TD COLSPAN=2>";
		tacticsHtml+=createComboboxHtml(new Array('super','bad','gandalf','test'));
		tacticsHtml+="</TD>";
		
		
		tacticsHtml+="</TR>";
		tacticsHtml+="</table>";
		tacticsHtml+="<input type='button' value='close' onclick='closeTactics(event);'>";
		*/
		addHint(player,players[i],hintHtml,hintHtml);
		
//		createSlider("123","sdfds");
//		processSliders();
		
		
		
		
		SetPlayerToBase(player,null);
		x++;
	}

	LoadZones();
			var tacticsHtml="<table border=0 bgcolor=78746C cellspacing=1 cellpadding=4 style='height:23px'>";
		tacticsHtml+="<TR bgcolor=#545E61 style='height:23px'>";
		tacticsHtml+="<TD align=right>Защита</TD>";
		tacticsHtml+="<TD width=100>"+createSliderHtml('attackTrB','123')+"</TD>";
		tacticsHtml+="<TD>Атака</TD>";
		tacticsHtml+="</TR>";
		
		tacticsHtml+="<TR bgcolor=#3B484C style='height:23px'>";
		tacticsHtml+="<TD align=right>Скорость</TD>";
		tacticsHtml+="<TD>"+createSliderHtml('powerTrB','123')+"</TD>";
		tacticsHtml+="<TD>Сила</TD>";
		tacticsHtml+="</TR>";
		
		tacticsHtml+="<TR bgcolor=#545E61 style='height:23px'>";
		tacticsHtml+="<TD align=right>Уклоны</TD>";
		tacticsHtml+="<TD>"+createSliderHtml('blockTrB','123')+"</TD>";
		tacticsHtml+="<TD>Блоки</TD>";
		tacticsHtml+="</TR>";
		
		tacticsHtml+="<TR bgcolor=#3B484C style='height:23px'>";
		tacticsHtml+="<TD colspan=3 align=center><div style='margin-bottom:5px'>Храбрость</div>";
		tacticsHtml+=createSliderHtml('courageTrB','123')+"</TD>";

		tacticsHtml+="</TR>";
		
		tacticsHtml+="<TR bgcolor=#545E61>";
		tacticsHtml+="<TD align=right>Тактика</TD><TD COLSPAN=2>";
		tacticsHtml+=createComboboxHtml(new Array('Атаковать','Прикрывать','Обороняться'));
		tacticsHtml+="</TD>";
		
		
		tacticsHtml+="</TR>";
		tacticsHtml+="</table>";
//		tacticsHtml+="<input type='button' value='close' onclick='closeTactics(event);'>";
		
//	tacticsDiv.innerHTML=tacticsHtml;
	var el=document.getElementById("rpLabel4");
	el.innerHTML=tacticsHtml;
	el.style.display="none";
//	alert(el);
//	el.style.display=block;
//	alert(document.getElementById("rpLabel4"));
//	processSliders();
		
}
function HighLightZones(player)
{

	if(player)
	{
		for(var i=0; i< zones.length; i++)
		{
			//if((zones[i].id.toLowerCase() === player.Position.toLowerCase()) ||
				//zones[i].id.toLowerCase() === player.Combination.toLowerCase())
				//{

					zones[i].zoneDiv.className = "hilight2Zone";
				//}


				
		}
	}
}
function UnhighLightZones(player)
{

	if(document.getElementById("LeaderID")) var leader=document.getElementById("LeaderID").value;
	else var leader=0;

		for(var i=0; i< zones.length; i++)
		{
					if(zones[i].players.length)  zones[i].zoneDiv.className = "hilightZone";
					else zones[i].zoneDiv.className = "zone";

			if(zones[i].players.length) 
			{
					player=getPlayerByDiv(zones[i].players[0].playerDiv);

					if(player.GladiatorID==leader) zones[i].zoneDiv.className="hightlightleader";

			}
		}

}




function onPlayerDown(evt)
{
	var playerDiv = evt?evt.target:event.srcElement;
	
	var player = getPlayerByDiv(playerDiv);
	UnhighLightZones(player);
}
//END player Icon EVENTS

function getStripe(value, colorMake, koef)
{
	var result = "";
	if(!colorMake)
	{
		for(i=0;i<((value*100)/84);i++)
		{
			var color = "rgb("+i*4*3+","+i*4*3+","+(155+i*4)+")";
			result += "<span style='font-size:7px;background-color:"+color+"'>&nbsp</span>";
		}
	}
	else
	{
		if(koef)
		{
			value = Math.round(value*koef);
		}


		var color = "red";
		if(value >0 && value <= 40)
			color = "red";
		if(value >40 && value <= 60)

			color = "orange";
		if(value >60 && value <= 80)
			color = "yellow";
		if(value >80 && value <= 90)
			color = "lightgreen";
		if(value >90 && value <= 100)
			color = "green";
		result += "<div  style='float:left; margin-top: 3px;margin-right: 5px; background-color:"+color+";width:"+(value)+"px; font-size:7px'>&nbsp;</div>";
	}
	return result;
}
function Round(value, precision)
{
	var tens = Math.pow(10,precision);
	var val = Math.round(value*tens);
	return val/tens;
}






function RemoveOptionByValue(select, optionValue)
{
	
	for(var i=0; i<select.childNodes.length; i++)
	{
		if(select.childNodes[i] && select.childNodes[i].tagName && select.childNodes[i].tagName.toLowerCase() == "option")
		{
			if(select.childNodes[i].value == optionValue)
			{
				select.removeChild(select.childNodes[i]);
				break;
			}
		}
	}
}
function RemoveRole(select,player)
{
	
	RemoveOptionByValue(select,player.GladiatorID);
}
function AddRole(select, player)
{
	var option = new Option();
	option.value = player.GladiatorID;
	option.innerHTML = player.name;
	select.appendChild(option);
}

function RefreshSubs(player, move, type)
{
	for(var i=0; i<subsCounter; i++)
	{
		var subs = document.getElementById("subs"+((type=="in")?"In":"Out")+i);
		if(subs)
		{
			if(move == "in")
			{
				var option = new Option();
				option.value = player.GladiatorID;
				option.innerHTML = player.name+"("+player.Number+")";
				subs.appendChild(option);
			}
			else if(move == "out")
			{
				if(subs.value != player.GladiatorID)
				{
					RemoveOptionByValue(subsIn, player.GladiatorID);
				}
				else
				{
					if(window.confirm("Для игрока "+player.name+" назначена замена, удалить ее?"))
					{
						/*var btnRem = document.getElementById("remove_task"+i);
						taskContainer.removeChild(btnRem.parentNode);*/
					}
				}
			}
		}
	}
}
function RefreshSubsOut(player, move)
{
	
}
function CheckTasks(player)
{
/*
	for(var i=0; i<taskCounter; i++)
	{
		var taskPlayer = document.getElementById("task_player"+i);
		if(taskPlayer && taskPlayer.value == player.GladiatorID)
		{
			var task = document.getElementById("task_task"+i);
			if(window.confirm("Для игрока "+player.name+" имеется задание \""+task.options[task.selectedIndex].innerHTML+"\"\n удалить его?"))
			{
				var btnRem = document.getElementById("remove_task"+i);
				taskContainer.removeChild(btnRem.parentNode);
			}
		}
	}
*/
}
function CheckSubs(player)
{
	for(var i=0; i<subsCounter; i++)
	{
		var subsIn = document.getElementById("subsIn"+i);
		if(subsIn)
		{
			var subsOut = document.getElementById("subsOut"+i);
			
			if(subsIn.value == player.GladiatorID || subsOut.value == player.GladiatorID)
			{
				if(window.confirm("Для игрока "+player.name+" назначена замена удалить ее?"))
				{
					var btnRem = document.getElementById("subs_deleteButton"+i);
					subsContainer.removeChild(btnRem.parentNode);
				}
			}
		}
	}

}
function CheckRoles(player)
{
	
	if(document.getElementById("role_Captain"))
	{
		var name = new Array();
		var id = new Array();
		if(document.getElementById("role_Captain").value == player.GladiatorID)
		{
			name.push("Капитан");
			id.push("role_Captain");
		}
		if(document.getElementById("role_LeftCorners").value == player.GladiatorID)
		{
			name.push("Левые угловые");
			id.push("role_LeftCorners");
		}
		if(document.getElementById("role_RightCorners").value == player.GladiatorID)
		{
			name.push("Правые угловые");
			id.push("role_RightCorners");
		}
		if(document.getElementById("role_FreeKicks").value == player.GladiatorID)
		{
			name.push("Штрафные");
			id.push("role_FreeKicks");
		}
		if(document.getElementById("role_Penalties").value == player.GladiatorID)
		{
			name.push("Пенальти");
			id.push("role_Penalties");
		}
		
		if(name.length > 0)
		{
			var allNames = "";
			for(var i=0; i<name.length; i++)
				allNames += name[i]+" ";
			if(window.confirm("Для игрока "+player.name+" назначены роли ("+allNames+") удалить их?"))
			{
				for(var i=0; i<id.length; i++)
				{
					RemoveRole(document.getElementById(id[i]),player);
				}
			}
		}
	}
}
function RefreshRoles(player, inOut)
{
	
 if(inOut)
 {
	AddRole(document.getElementById("role_Captain"), player);
	AddRole(document.getElementById("role_LeftCorners"), player);
	AddRole(document.getElementById("role_RightCorners"), player);
	AddRole(document.getElementById("role_FreeKicks"), player);
	AddRole(document.getElementById("role_Penalties"), player);
 }
 else
 {
	RemoveRole(document.getElementById("role_Captain"), player);
	RemoveRole(document.getElementById("role_LeftCorners"), player);
	RemoveRole(document.getElementById("role_RightCorners"), player);
	RemoveRole(document.getElementById("role_FreeKicks"), player);
	RemoveRole(document.getElementById("role_Penalties"), player);

 }
}
function LoadZones()
{


	for(i = 0; i< zonesCount; i++)
	{
		var isRP = (zones[i].id.substring(0,2).toLowerCase() == "rp")?true:false;
		var rp = (isRP)?"background-color:white":"";
		document.write("<div style='"+rp+"' class=zone id=zone"+i+" unselectable='on'><center unselectable='on'></center></div>");
		var zoneDiv = document.getElementById("zone"+i);
		trueLeft = 309+convertZoneX(zones[i].x1);
		trueTop = (ZonesHeigth-(convertZoneY(zones[i].y1)))-convertZoneY(zones[i].y2);

		trueWidth = convertZoneX(zones[i].x2)+((document.all)?1:-1)-2;
		trueHeigth = convertZoneY(zones[i].y2)+((document.all)?1:-1)-2;

		zoneDiv.style.left = trueLeft;
		zoneDiv.style.top = trueTop;
		zoneDiv.style.width = trueWidth;
		zoneDiv.style.height = trueHeigth;
		zoneDiv.style.zIndex = 10;
		zones[i].zoneDiv = zoneDiv;

	}


	document.write("<span style='position: absolute' id=rpLabel  >Лимит гладиаторов: <input id=GladLeft type=text size=2 value=7 readonly style='border:0;'></span>");
	document.write("<span style='position: absolute' id=rpLabel2  >Лимит уровня: <input id=SklLeft type=text size=2  readonly style='border:0;'></span>");

	document.write("<span style='position: absolute' id=rpLabel3  >Специальные типы: ");

	if(document.getElementById("Extra").value==1) document.write("<img src=/images/icons/smallgreen.gif width=14 height=14> разрешены");
	else document.write("<img src=/images/icons/smallred.gif width=14 height=14> запрещены");


	document.write("</span>");

	document.write("<div style='position: absolute' id=rpLabel4  >");
	document.write("</div>");

	var rpLabel = document.getElementById("rpLabel");
	rpLabel.style.top = ZonesHeigth+14;
	rpLabel.style.left = 310;
	
	rpLabel2.style.top = ZonesHeigth+34;
	rpLabel2.style.left = 310;
	
	rpLabel3.style.top = ZonesHeigth+54;
	rpLabel3.style.left = 310;

	rpLabel4.style.top = ZonesHeigth+74;
	rpLabel4.style.left = 310;

	
}
