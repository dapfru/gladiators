
		function checkSubMenus(anchor)
		{
		
			
			if(navigator.userAgent.toLowerCase().indexOf("opera")==-1)
		
			{
			var subMenusExist = false;
			var anchors = document.getElementsByTagName("tr");
			var parentId = (/menu(\d+)parent(\d+)/).exec(anchor.id)[1];

			for(var i=0; i<anchors.length; i++)
			{
				if(anchor.id != anchors[i].id)
				{
					var currId = anchors[i].id;
					var regEx = (/menu(\d+)parent(\d+)/).exec(currId);
					if(regEx)
					{
						var currParentId = regEx[2];
						if(currParentId == parentId)
						{
							subMenusExist = true;
							anchors[i].style.display = ("none" == anchors[i].style.display)?
								"block":"none";
						}
					}
				}
			
			}
			if(subMenusExist)
				anchor.style.marginTop = (anchor.style.marginTop == "3px")?"0px":"3px";
			return !subMenusExist;
			}

		}


function dots(str1)
{
	str1 = String(str1);

	 var razrNum = Math.round( str1.length / 3 + 0.5 );
	 var len = str1.length;
	 var str2 = "";
	 if ( len > 3 ) {
	 	 str2 = str1.substr( len - 3, 3 );
	 } else {
	 str2 = str1;
	 }
	 
	 for ( var i = 2; i < razrNum; i++ ) {
	 str2 = str1.substr( len - i * 3, 3 ) + '.' + str2;
	 }
	 
	 if ( ((i - 1) * razrNum < len) && (len > 3) ) {
	 str2 = str1.substr( 0, len - (i - 1) * 3 ) + '.' + str2;
	 }

	return str2;
}

function checknumeric()
{
  var key = window.event.keyCode; 
  if (key <48 || key >57) 
    window.event.returnValue = false; 
}



function FocusIN(obj)
{
  obj.style.backgroundColor="#FFFAEC";
}
function FocusOUT(obj)
{
  obj.style.backgroundColor="#FFFFFF";
}