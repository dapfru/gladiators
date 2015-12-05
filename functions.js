
function hidehint(type,pageid,act,user)
{

	document.getElementById('hintbutton1').style.display=(document.getElementById('hintbutton1').style.display=='none')?'block':'none';
	document.getElementById('hintbutton2').style.display=(document.getElementById('hintbutton2').style.display=='none')?'block':'none';
	document.getElementById('hint').style.display=(document.getElementById('hint').style.display=='none')?'block':'none';

	xajax_hidehint(type,pageid,act,user);
}


function getElementByName(id)
{
	var ar=document.getElementsByName(id);
	return ar[0];	
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
if(window.event)
{
  var key = window.event.keyCode; 
  if (key <48 || key >57) 
    window.event.returnValue = false; 
}
}



function FocusIN(obj)
{
  obj.style.backgroundColor="#B5AFA7";
}
function FocusOUT(obj)
{
  obj.style.backgroundColor="#BAAE9C";
}