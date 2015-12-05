<?

$settings=select("select * from chat_settings where UserID='$auth->user'");
if(!$settings[Height]) $settings[Height]=130;


?>
<style>
#chatContent, #chatUsersList, #chatControlPanel
{
}
#chatContainer
{
	position:relative;
	display:none;
}
#chatContainerTable
{
	width:772px;

}
#chatContent
{
	font-family: Tahoma;
	font-size: 11px;
	border: 1px solid #78746C;
	overflow:auto;
	height:100%;
	padding: 5px 5px 5px 5px;
}	

#banSettings
{
	padding: 5px 5px 5px 5px;
	font-family: Tahoma;
	font-size: 11px;
	overflow:auto;
}
			  
#chatUsersList
{
	padding: 5px 5px 5px 5px;
	font-family: Tahoma;
	font-size: 11px;
	border: 1px solid #78746C;
<? if(!$isModerator) print "height:100%;";
   else print "height:".($settings[Height]-20).";";
?>
	overflow:auto;
}				  

.nickName
{
	font-weight: bold;
	text-decoration: none;
}
.nickName:hover
{
	font-weight: bold;
	text-decoration: underline;
}
.nickNamePrivate
{
	font-weight: bold;
	color: #FF5A5A;
}
#chatButtonSay
{
	width: 50px;
	height: 20px;
	border: 0px solid;
	cursor: pointer;
}
#inputContainer
{

	padding:2px 5px 2px 5px ;
	height:25px;
}
#inputContainer2
{

	padding:3px 5px 0px 5px ;
	height:25px;
}

#chatSettings
{
	padding: 5px 5px 5px 5px;
	font-family: Tahoma;
	font-size: 11px;
	color: #456f97;
	border: 1px solid #78746C;
<? if(!$isModerator) print "height:100%;";
   else print "height:".($settings[Height]-20).";";
?>

	overflow:auto;
}

#moderatorWork
{
   padding: 5px 5px 5px 5px;
   font-family: Tahoma;
   font-size: 11px;
   color: #456f97;
   border: 1px solid;
   height:100%;
   background-color:ffffff;
   overflow:auto;
}

 </style>
  <tr> 
	<td colspan=3>
		<div id=chatContainer><center>


			<table id=chatContainerTable >
			<tr>
				<td id=chattd height=<?=$settings[Height]?>px style="padding:5px 0px 0px 5px;">
					<div id=chatContent><?if($_SESSION['chatcontent']) print iconv('utf-8','windows-1251',stripslashes($_SESSION['chatcontent'])); else print '<center>загрузка...</center>';?></div>
				</td>
				<td id=chattd2 width=30% height=<?=$settings[Height]?>px style="padding:5px 5px 0px 0px;">

<?
if($isModerator)
{


?><div id=banSettings>
                  Период бана
                  <SELECT id=ban_time>
<?
foreach($bantime as $k=>$v)
{
	print "<option value=$k>$v</option>";
}
?>
                  </SELECT>
&nbsp;&nbsp;<a href=/moderate>[модерация]</a>
</div>
<?
}
?>
					<div id=chatUsersList style="display:block">
<?


if($_SESSION['chatusers']) print iconv('utf-8','windows-1251',stripslashes($_SESSION['chatusers'])); else print '<center>загрузка...</center>';?></div>
					<div id=chatSettings style="display:none">
<table border=0 cellspacing=0 cellpadding=4>
<tr><td>Цвет</td><td>


               <SELECT id=Color style='background-color:4C595F'>

<?


$ar['rus']=array(
'FFFFFF'=>'Белый',
'F379F3'=>'Пурпурный',
'49E149'=>'Зеленый',
'FFC000'=>'Оранжевый',
'E5CEA6'=>'Оливковый',
'CB63F7'=>'Фиолетовый',
'F44D4D'=>'Красный',
'C0C0C0'=>'Серебряный',
'87CEFA'=>'Небесно-голубой'
);

foreach($ar[$lang] as $k=>$v)
{
	print "<option value=$k style='color:$k' ";
	if($settings[Color]==$k||(!$settings[Color]&&$k=='E5CEA6')) print "selected";
	print ">$v</option>";
}
?>

               </SELECT>
</td></tr>
<input type=hidden name=FontSize value=1>
<?
/*

<tr><td colspan=2>Размер шрифта 
               <SELECT id=FontSize>
<?
$ar=array(1,2,3);
foreach($ar as $a)
{
	print "<option value=$a ";
	if($settings[FontSize]==$a) print "selected";
	print ">$a</option>";
}
?>

               </SELECT>
</td></tr>
*/
?>

<tr><td colspan=2>Высота чата 
               <SELECT id=Height>
<?
$ar=array(80,100,130,150,200,250,300,350,400);
foreach($ar as $a)
{
	print "<option value=$a ";
	if($settings[Height]==$a||(!$settings[Height]&&$a==130)) print "selected";
	print ">$a</option>";
}
?>
               </SELECT>
</td></tr>
<tr><td colspan=2>Сообщений на странице 
               <SELECT id=MessagesCount>
<?
$ar=array(10,15,20,25,30,35,40,45,50);
foreach($ar as $a)
{
	print "<option value=$a ";
	if($settings[MessagesCount]==$a||(!$settings[MessagesCount]&&$a==20)) print "selected";
	print ">$a</option>";
}
?>
               </SELECT>
</td></tr>
<tr><td colspan=2><input type=button class=blackbutton value=Сохранить onclick='updateSettings();'></td></tr>
</table>
					</div>



				</td>
			</tr>
			<tr  class="index2-menu3">
				<td valign=middle style="padding:0px 0px 5px 5px; " colspan=2>

<table border=0 cellspacing=0 cellpadding=0 width=100%>
<tr>
<td width=100%>
		<div id=inputContainer>			
						<input style="width: 350px;background:16191C;color:E5CEA6;border:1px solid #53585B;height:20px;background-image:url('/images/formbg.gif');" id=chatInput />
						<input type=button class=blackbutton  value="Отправить [Enter]" id=sendbutton  onclick="this.disabled = true; this.className='disabledbutton'; sendMessage(chatInput.value,<?echo $auth->user;?>);" />

			</div>		
</td><td align=right style='padding-right:5px;'>
		

		
						<input type=button id=settingsbutton class=blackbutton onclick="document.getElementById('chatUsersList').style.display='none';
document.getElementById('chatSettings').style.display='block';
document.getElementById('usersbutton').style.display='block';
document.getElementById('settingsbutton').style.display='none';" value="Настройки" /> 

						<input type=button id=usersbutton class=blackbutton value=Пользователи style='display:none' class=blackbutton onclick="document.getElementById('chatSettings').style.display='none';
document.getElementById('chatUsersList').style.display='block';
document.getElementById('usersbutton').style.display='none';
document.getElementById('settingsbutton').style.display='block';">
				
</td><td align=right>		
						<input id=chatButtonClose type=button class=blackbutton value='Закрыть' onclick="logoutChat();"/>
					
</table>

				</td>
			</tr>
			</table>
		</div>
	</td>  
</tr>
				  
<script>

	var chatRefreshInterval = 0;
	var oldscroll=0;
	var oldheight=0;
	var chatheight=<?=$settings[Height]?>;
	
	var oldMessagesCount='<?=$settings[MessagesCount]?>';

	function chatInputKeyDown(evt)
	{
		var keyCode = (evt)?evt.keyCode:event.keyCode;
		if(keyCode == 13)
		{
			sendMessage(chatInput.value,<?echo $auth->user;?>);
			
		}
	}
	if(!document.all)
	{
		chatInput.addEventListener("keypress",chatInputKeyDown,false);
	}
	else
	{
		chatInput.attachEvent("onkeypress",chatInputKeyDown);
	}
	function sendMessage(message, user)
	{

		xajax_addMessage(message, user,document.getElementById("Color").value);


		
		chatInput.focus();

		document.getElementById("sendbutton").disabled = false; 
		document.getElementById("sendbutton").className='blackbutton';
	}
	function logoutChat()
	{
		window.clearInterval(chatRefreshInterval);
		xajax_logOutChat(<?echo $auth->user;?>);
		chatContainer.style.display = "none";
	}


	function loginChat()
	{
		if(chatContainer.style.display == "block")
		{
			logoutChat();
			return;
		}
		chatRefreshInterval = window.setInterval("refreshContent()",3000);
		chatContainer.style.display = "block";
		document.getElementById("chatContent").scrollTop=1000000;
	}
	function updateSettings()
	{
		xajax_updateSettings('<?=$auth->user?>',0,document.getElementById("Height").value,document.getElementById("MessagesCount").value,document.getElementById("Color").value)
		document.getElementById('chatSettings').style.display='none';
		document.getElementById('chatUsersList').style.display='block';

		if(document.getElementById("MessagesCount").value!=oldMessagesCount) document.getElementById("lastChatMessageID").innerHTML=0;
		oldMessagesCount=document.getElementById("MessagesCount").value;

		document.getElementById("chattd").style.height=document.getElementById("Height").value;
		document.getElementById("chattd2").style.height=document.getElementById("Height").value;
		chatheight=eval(document.getElementById("Height").value);

		document.getElementById('usersbutton').style.display='none';
		document.getElementById('settingsbutton').style.display='block';

		chatContent.scrollTop=1000000;
		//xajax_refreshContent(lastChatMessageID.innerHTML,<?echo $auth->user;?>);
	}

	function refreshContent()
	{

		oldscroll=chatContent.scrollTop;
		oldheight=chatContent.scrollHeight;

		window.clearInterval(chatRefreshInterval);

		xajax_refreshContent(lastChatMessageID.innerHTML,<?echo $auth->user;?>,document.getElementById("MessagesCount").value);

if (window.navigator.userAgent.indexOf ("Opera") >= 0)
  {
  	var plus=-5;
  }
else
if (window.navigator.userAgent.indexOf ("Gecko") >= 0) // (Mozilla, Netscape, FireFox)
  {       
  	var plus=10;
  }
else //explorer
//if (window.navigator.userAgent.indexOf ("MSIE") >= 0)
  {
  	var plus=-7;
  }


		if((!oldscroll&&!lastChatMessageID)||oldscroll+chatheight+plus>=oldheight)  chatContent.scrollTop=1000000;

	}
	function scrollDown()
	{

if (window.navigator.userAgent.indexOf ("Opera") >= 0)
  {
  	var plus=-5;
  }
else
if (window.navigator.userAgent.indexOf ("Gecko") >= 0) // (Mozilla, Netscape, FireFox)
  {       
  	var plus=10;
  }
else //explorer
//if (window.navigator.userAgent.indexOf ("MSIE") >= 0)
  {
  	var plus=-7;
  }

plus=plus+20;

//alert('test: '+oldscroll+'+'+chatheight+'+'+plus+'>='+oldheight);
		if((!oldscroll&&!lastChatMessageID)||oldscroll+chatheight+plus>=oldheight)  chatContent.scrollTop=1000000;
	}

   function BanUser(userID,userName,ban_time)
   {
	if(confirm('Забанить пользователя '+userName+'?')) xajax_BanUser(userID,ban_time);
   }

   function UnBanUser(userID,userName)
   {
	if(confirm('Разбанить пользователя '+userName+'?')) xajax_UnBanUser(userID);
   }

   function DeleteMessage(id_message)
   {
	xajax_DeleteMessage(id_message,document.getElementById("MessagesCount").value)
   }
   

	function addUserToMessage(user, priv)
	{

		chatInput.focus();
		if(!priv)
		{
			chatInput.value += user+", ";
			
		}
		else
		{
			chatInput.value = "[private "+user+"]: "+chatInput.value;
		}

	}
	<?echo ($displayChat)?"loginChat();":""; ?>
</script>
<span id=lastChatMessageID style="display:none">0</span>
