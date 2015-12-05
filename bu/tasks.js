//
var taskContainer = null;
var taskCounter = 0;
function clearTasks()
{
	for(var i=0;i<taskCounter; i++)
	{
		var item = document.getElementById("task_div"+i);
		if(item && item.parentNode)
		{
			taskContainer.removeChild(item);
		}
	}
	taskCounter = 0;
}
function taskPlayerChange(evt)
{
	var select = (evt)?evt.target:window.event.srcElement;
	for(var i=0;i<taskCounter; i++)
	{
		var player = document.getElementById("task_player"+i);
		if(player && player != select && player.value == select.value)
		{
			alert("одному и тому же игроку нельзя назначать несколько заданий!");
			select.value = -1;
		}
	}
}
function addTask()
{
	var validateSquad = ValidateSquad();
	if(validateSquad)
	{
		alert(validateSquad);
		return;
	}
	if(null == taskContainer)
		taskContainer = document.getElementById("tasksContainer");
	var item = document.createElement("div");

	with(item.style)
	{
		border = "1px solid";
		height = "30px";
		padding = "5px";
		backgroundColor = "#EEF4FA";
		margin = "2px";
	}
	
	//add close button
	var button = document.createElement("span");
	button.innerHTML = getLocaleString("rem");
	with(button.style)
	{
		cssText = "float:right;";
		cursor = "pointer";
		display = "block";
	}
	addHint(button,getLocaleString("delTask"));
	button.onclick = removetask;
	button.id = "remove_task"+taskCounter;
	
	//get Players
	var playerLabel = document.createElement("span")
	playerLabel.innerHTML = getLocaleString("player")+":";
	var players = getPlayersTag(0);
	players.id = "task_player"+taskCounter;
	players.onchange = taskPlayerChange;
	
	item.appendChild(playerLabel);
	item.appendChild(players);
	
	//get Tasks
	var playerTaskLabel = document.createElement("span")
	playerTaskLabel.innerHTML = getLocaleString("task")+":";
	item.appendChild(playerTaskLabel);
	var tasks = document.createElement("select");
	tasks.id = "task_task"+taskCounter;
	var option = document.createElement("option");
	option.value = -1;
	option.innerHTML = "-";
	tasks.appendChild(option);
	option = document.createElement("option");
	option.value = 1;
	option.innerHTML = getLocaleString("PlayMaker");
	tasks.appendChild(option);
	option = document.createElement("option");
	option.value = 2;
	option.innerHTML = getLocaleString("Dribling");
	tasks.appendChild(option);
	option = document.createElement("option");
	option.value = 3;
	option.innerHTML = getLocaleString("LongBlow");
	tasks.appendChild(option);
	option = document.createElement("option");
	option.value = 4;
	option.innerHTML = getLocaleString("Dispatcher");
	tasks.appendChild(option);
	option = document.createElement("option");
	option.value = 5;
	option.innerHTML = getLocaleString("Flangs");
	tasks.appendChild(option);
	option = document.createElement("option");
	option.value = 6;
	option.innerHTML = getLocaleString("Violation");
	tasks.appendChild(option);
	item.id = "task_div"+taskCounter;
	item.appendChild(tasks);

			
	item.appendChild(button);
	
	taskContainer.appendChild(item);
	taskCounter ++;
}
function removetask(evt)
{
	var button = (evt)?evt.target:event.srcElement;
	taskContainer.removeChild(button.parentNode);
}