var zonesCount = 0;
var ZonesWidth = 200;
var ZonesHeigth = 200;
function convertZoneX(procent)
{
	x = ZonesWidth * (procent/100);
	return x;
}
function convertZoneY(procent)
{
	y = ZonesHeigth * (procent/100);
	return y;
}
function Zone(id,x1,y1,x2,y2)
{
	this.id = id;
	this.x1 = x1;
	this.X1 = 309+convertZoneX(x1);
	this.y1 = y1;
	this.Y1 = ZonesHeigth-convertZoneY(y1);
	this.x2 = x2;
	this.X2 = this.X1+convertZoneX(x2);
	this.y2 = y2;
	this.Y2 = this.Y1-convertZoneY(y2);
	this.players = new Array();
}
function getZoneById(zoneId)
{	
	var zone = null;
	for(var z = 0; z< zonesCount; z++)
	{
		if(zones[z].id.toLowerCase() == zoneId.toLowerCase())
		{
			zone = zones[z];
			break;
		}
	}
	return zone;
}
function ValidZone(zone,pl)
{


	result = true;
	count = 0;
	skl =0;
	for(var i=0; i< zones.length; i++)
	{
			count += zones[i].players.length;

			if(zones[i].players.length)
			{
				player = getPlayerByDiv(zones[i].players[0].playerDiv);
				//alert(player.GladiatorID);
				skl+=Math.round(player.Level);
			}
	}
	
//макс. число гладиаторов
	if(count == 7 || (Math.round(document.getElementById("GladLimit").value)>0  && count >= Math.round(document.getElementById("GladLimit").value)) ) 
	{
		alert('Лимит гладиаторов исчерпан');
		result = false;
	}



	if(Math.round(document.getElementById("SklLimit").value)>0 && Math.round(document.getElementById("SklLimit").value)<Math.round(skl)+Math.round(pl.Level))
	{	
		alert('Лимит уровня гладиаторов исчерпан');
		result = false;
	}
	
	if(zone.players.length>=1)
	{
		result = false;

	}

	
		
	return result;
}