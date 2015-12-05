var interval = 0;
function save_data()
{
	document.getElementById('savedialog').style.display='none';
	document.getElementById('savedialogtour').style.display='none';
	ShowSystemMessage("Saving...");

	var data_form = document.getElementById("saving_form");
	data_form.load.value = 0;


	var input_leader = data_form.leader;
	var input_tactic = data_form.tactic;
	var input_zones = data_form.zones;
	var input_players = data_form.players;


	if(document.getElementById("LeaderID")) input_leader.value = document.getElementById("LeaderID").value;

	if(document.getElementById("Tactic")) input_tactic.value = document.getElementById("Tactic").value;

	input_zones.value = zones.length;


	input_players.value = "";


	var basePlayersCount = 0;

	for(var i = 0; i<zones.length; i++)
	{
			input_zones.value += ";"+zones[i].players.length;

		for(var j = 0; j<zones[i].players.length; j++)
		{

				input_players.value += ";"+zones[i].players[j].GladiatorID;
				basePlayersCount ++;

		}
	}
	input_players.value = basePlayersCount+input_players.value;

}
function load_data()
{
	document.getElementById("filelist").style.display="none";
	ShowSystemMessage("Loading...");

	var data_form = document.getElementById("saving_form");
	data_form.load.value = 1;

}
function appendNewFileName(filename, orderID)
{
	

	var orderListContainer = document.getElementById("orderListContainer");
	var orderSaveListContainer = document.getElementById("orderSaveListContainer");
	var savingDialog = document.getElementById("savedialog");
	var contains = false;

	//load add
	{

		var tr = (!document.all)?document.createElement('tr'):orderListContainer.insertRow();
		

		tr.id = "ordertr"+orderID;
		var td = (!document.all)?document.createElement('td'):tr.insertCell();
		td.innerHTML = "<a class='fileListItem' onclick='javascript:send_data(1,\""+filename+"\")'>"+filename+"</a>";
		var td2 = (!document.all)?document.createElement('td'):tr.insertCell();
		td2.align="right";
		td2.innerHTML = "<img style='cursor:pointer;' onclick=\"delete_order("+orderID+")\" src=\""+site_url+"images/icons/drop.png\" width=16px height=16px border=0 alt=\"Удалить\" title=\"Удалить\">";
		if(!document.all)
		{
			tr.appendChild(td);
			tr.appendChild(td2);
			orderListContainer.appendChild(tr);
		}	
	}
	//save add
	{
		tr = (!document.all)?document.createElement('tr'):orderSaveListContainer.insertRow();
		tr.id = "orderSavingName"+orderID;
		td = (!document.all)?document.createElement('td'):tr.insertCell();
		td.innerHTML = "<a class='fileListItem' onclick='javascript:send_data(1,\""+filename+"\")'>"+filename+"</a>";
		td2 = (!document.all)?document.createElement('td'):tr.insertCell();
		td2.align="right";
		td2.innerHTML = "<img style='cursor:pointer;' onclick=\"delete_order("+orderID+")\" src=\""+site_url+"images/icons/drop.png\" width=16px height=16px border=0 alt=\"Удалить\" title=\"Удалить\">";
		if(!document.all)
		{
			tr.appendChild(td);
			tr.appendChild(td2);
			orderSaveListContainer.appendChild(tr);
		}
	}
	
}
function ValidateData()
{

	var playersC = 0;
	var playersRP = 0;
	for(var i = 0; i<zones.length; i++)
	{
		for(var j = 0; j<zones[i].players.length; j++)
		{
			if(zones[i].id.substring(0,2).toLowerCase() != "rp")
			{
				playersC ++;
			}
			else
			{
				playersRP ++;
			}
		}
	}
	var subsCount = 0;

/*
	for(var i=0; i<subsCounter; i++)
	{
		var subsDiv = document.getElementById("subsDiv"+i);
		if(subsDiv && subsDiv.parentNode)
		{
			subsCount ++;
			var playerIn = document.getElementById("subsIn"+i);
			var playerOut = document.getElementById("subsOut"+i);
			var substime = document.getElementById("subs_time"+i);
			var substimeChecked =  document.getElementById("subs_time_checked"+i);
			if(!playerIn.value || !playerOut.value || playerIn.value <= 0 || playerOut.value <= 0)
				return "одна из замен не коректна";
			if(!playerIn.value || !playerOut.value || playerIn.value <= 0 || playerOut.value <= 0)
				return "одна из замен не коректна";
			if(substimeChecked.checked)
			{
				
				if(!substime.value || (substime.value < 1 || substime.value > 120) || isNaN(substime.value))
					return "одна из замен не коректна (время замены)";
			}
		}
	}

	for(var i=0; i<taskCounter; i++)
	{
		var player = document.getElementById("task_player"+i);
		if(player)
		{
			var task = document.getElementById("task_task"+i);
			if(!player.value || player.value <= 0 || !task.value || task.value <= 0)
				return "одно из заданий сформировано неправильно \n(не выбран игрок или задание)";
		}
		
	}
*/

	if(playersC == 0)
		return "Вы должны выбрать хотя бы одного гладиатора!";

}
function send_data(load,filename,id,tourId)
{
	var data_form = document.getElementById("saving_form");
	data_form.filename.value = filename;
	if(id) data_form.id.value = id;


	if(load)
	{
		load_data();
	}
	else
	{
		var validateMessage = ValidateData();
		if(validateMessage)
		{
			alert(validateMessage);
			return;
		}
		save_data();
		
	}
	data_form.submit();

	var iframe = document.getElementById("saving_frame");
	if(iframe.contentWindow && iframe.contentWindow.document)
	{
		if(iframe.contentWindow.document.getElementById("isloaded"))
		{
			iframe.contentWindow.document.body.removeChild(iframe.contentWindow.document.getElementById("isloaded"));
		}
	}
	interval = window.setInterval("check()",10);

	
}
function check()
{
	var iframe = document.getElementById("saving_frame");
	if(iframe.contentWindow && iframe.contentWindow.document)
	{

		if(iframe.contentWindow.document.getElementById("isloaded"))
		{
			ShowSystemMessage("Done");
			window.clearInterval(interval);


			HideSystemMessage();
		}
	}


}