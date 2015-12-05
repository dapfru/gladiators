
var replacements = new Array();
//sostav
function Player()
{
  this.attack=50;
  this.power=50;
  this.block=50;
  this.courage=100;
}

function Replacement(base_player, reserve_player, condition, condition_value)
{
	this.id = 0;
	this.out_player = base_player;
	this.in_player = reserve_player;
	this.playerOutTag = null;
	this.playerInTag = null;
	this.condition = condition;
	this.condition_value = condition_value;
}
Replacement.prototype.OnPlayerChanged = function()
{
	alert("hello world");
}
