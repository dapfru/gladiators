function taskplayer_changed()
{
	var player = document.all["task_player"].options[document.all["task_player"].selectedIndex].player;
	document.all["task"].value = player.task;
	
}
function task_changed()
{
	var player = document.all["task_player"].options[document.all["task_player"].selectedIndex].player;
	player.task = document.all["task"].value;
}
function makeTaskTab()
{
	for(i=0; i<players.length; i++)
	{
		players[i].task = 1;
		var opt = new Option(players[i].name,players[i]);
		opt.player = players[i];
		document.all["task_player"].add(opt);
	}
}
