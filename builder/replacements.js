var subsCounter = 0;
var replacementsID = 1;
var subsContainer = null;

function test(evt)
{
	var select = (evt)?evt.target:event.srcElement;
	//check for exist player in other subs
	for(var i=0; i< subsCounter; i++)
	{
		var subsIn = document.getElementById("subsIn"+i);
		if(subsIn)
		{
			var subsOut = document.getElementById("subsOut"+i);
			if(subsIn != select && subsOut != select && (subsIn.value == select.value || subsOut.value == select.value))
			{
				alert("этот игрок уже используется в других заменах!");
				select.value = -1;
				return;
			}
		}
	}
}
function getPlayersTag(type)
{
	var select = null;
	select = document.createElement("select");
	select.onchange = test;
	//select.id = ((type == 1)?"subsIn":"subsOut")+subsCounter;
	with(select.style)
	{
	//	fontSize = "10";
	}
	var option = document.createElement("Option");
	option.value = -1;
	option.innerHTML = "-";
	select.appendChild(option);
	for(var i=0; i<zonesCount; i++)
	{
		for(var j = 0; j < zones[i].players.length; j++)
		{
 			var option = document.createElement("Option");
			option.value = zones[i].players[j].PlayerID;
			option.innerHTML = zones[i].players[j].name+"("+zones[i].players[j].Number+" - "+zones[i].players[j].Position+
			((zones[i].players[j].Combination)?("/"+zones[i].players[j].Combination):"")+")";
			var isReplace = (zones[i].id.toLowerCase().substring(0,2)=="rp");
			if((isReplace && type==2) || (!isReplace && type==1) || type==0)
				select.appendChild(option);
		}
	}
	return select;
}
function removesub(evt)
{
	var button = (evt)?evt.target:event.srcElement;
	subsContainer.removeChild(button.parentNode);
}

function clearSubs()
{
	for(var i=0;i<subsCounter; i++)
	{
		var item = document.getElementById("subsDiv"+i);
		if(item && item.parentNode)
		{
			subsContainer.removeChild(item);
		}
	}
	subsCounter = 0;
}

function newsubs()
{


	if(null == subsContainer)
		subsContainer = document.getElementById("dynContainer2");
	var item = document.createElement("div");
	item.id = "subsDiv"+subsCounter;
	with(item.style)
	{
		border = "1px solid #78746C";
		padding = "5px";
		backgroundColor = "#3B484C";
		margin = "2px";
		position= "relative";
	}
	
	//add close button
	var button = document.createElement("div");
	
	button.innerHTML = getLocaleString("rem");
	with(button.style)
	{
		cursor = "pointer";
		marginLeft = "85%";
	}
	addHint(button,getLocaleString("delSubs"));
	button.id = "subs_deleteButton"+subsCounter;
	
	//add player In/Out:
	var playerInLabel = document.createElement("span")
	playerInLabel.innerHTML = getLocaleString("PlayerIn")+":";
	var playerOutLabel = document.createElement("span")
	playerOutLabel.innerHTML = getLocaleString("PlayerOut")+":";
	
	item.appendChild(playerInLabel);
	var playerIn = getPlayersTag(1);
	playerIn.id = "subsIn"+subsCounter;
	
	item.appendChild(playerIn);
	item.appendChild(playerOutLabel);
	var playerOut = getPlayersTag(2);
	playerOut.id = "subsOut"+subsCounter;
	item.appendChild(playerOut);
	
	item.appendChild(document.createElement("br"));
	


	item.appendChild(button);
	button.onclick = removesub;
	
	subsContainer.appendChild(item);
	subsCounter ++;

}
function getSubType(i)
{
	var injury = document.getElementById("subs_injury_checked"+i);
	var time = document.getElementById("subs_time_checked"+i);
	var goals = document.getElementById("subs_goals_checked"+i);
	if(!injury || !time || !goals)
		return 0;
		
	if(injury.checked && !time.checked && !goals.checked)return 1;
	if(!injury.checked && time.checked && !goals.checked)return 2;
	if(injury.checked && time.checked && !goals.checked)return 3;
	if(!injury.checked && !time.checked && goals.checked)return 4;
	if(injury.checked && !time.checked && goals.checked)return 5;
	if(!injury.checked && time.checked && goals.checked)return 6;
	if(injury.checked && time.checked && goals.checked)return 7;
}







