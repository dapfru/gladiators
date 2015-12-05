<?
require_once($engine_path.'cls/ajax/xajax.inc.php');

	$res = mysql_query("select UserID,isModerator from chat_users where userId=$auth->user");
	
	$displayChat = false;
	if($res)
	{
		if($data = mysql_fetch_row($res))
		{
			$displayChat = $data[0];
			//$isModerator = $data[1];

		}
	}
	
	$isModerator = checkpriv('chat/messages','');


$content = "";

$bantime=array('600'=>'10 мин','1800'=>'30 мин','3600'=>'час','21600'=>'6 часов','86400'=>'сутки','432000'=>'5 дней','864000'=>'10 дней','2592000'=>'30 дней');


function BanUser($userID,$time_ban)
{
	global $auth,$isModerator,$bantime,$_SESSION;

	if(!$isModerator) return 0;

	$objResponse =  new xajaxResponse();




   mysql_query("insert into chat_settings(UserID,BanTime,AdminID) values ($userID,unix_timestamp()+$time_ban,'$auth->user')
on duplicate key update BanTime=unix_timestamp()+$time_ban,AdminID='$auth->user'");

$t2=substr(mktime(),0,strlen(mktime())-3);




$q=select("select Login from ut_users where UserID=$userID");

$message="<i>".$q[0]." забанен на ".$bantime[$time_ban]."</i>";

$message = iconv('windows-1251','utf-8',$message);


mysql_query("insert into chat_messages (UserID,Message,MessageTime,PrivateUserID,MessageTime2) 
values($auth->user,'$message',unix_timestamp(),0,'$t2')");


			$login=$auth->nick;
			$login = iconv('windows-1251','utf-8',$login);

			$str = date("H:i",mktime())." <a href='javascript:addUserToMessage(\"$login\", 0)' class=nickName".(($privateId)?"Private":"").">".$login."</a>: <span class=chatMessage".(($privateId)?"Private":"").">".$message."</span><br />";

			$objResponse->addAppend("chatContent","innerHTML",$str);

			$_SESSION['chatcontent'].=$str;

			$objResponse->addScript("chatContent.scrollTop=1000000");

	$objResponse->addAlert(mysql_error()."User banned");

	return $objResponse;
}



function UnBanUser($userID)
{
	global $auth,$isModerator,$bantime,$_SESSION;

	if(!$isModerator) return 0;

	$objResponse =  new xajaxResponse();




   mysql_query("insert into chat_settings(UserID,BanTime) values ($userID,0)
on duplicate key update BanTime=0");

$t2=substr(mktime(),0,strlen(mktime())-3);


$q=select("select Login from ut_users where UserID=$userID");

$message="<i>".$q[0]." разбанен</i>";

$message = iconv('windows-1251','utf-8',$message);


mysql_query("insert into chat_messages (UserID,Message,MessageTime,PrivateUserID,MessageTime2) 
values($auth->user,'$message',unix_timestamp(),0,'$t2')");


			$login=$auth->nick;
			$login = iconv('windows-1251','utf-8',$login);

			$str = date("H:i",mktime())." <a href='javascript:addUserToMessage(\"$login\", 0)' class=nickName".(($privateId)?"Private":"").">".$login."</a>: <span class=chatMessage".(($privateId)?"Private":"").">".$message."</span><br />";

			$objResponse->addAppend("chatContent","innerHTML",$str);

			$_SESSION['chatcontent'].=$str;

			$objResponse->addScript("chatContent.scrollTop=1000000");

	$objResponse->addAlert("User unbanned");

	return $objResponse;
}


function DeleteMessage($message_id,$num)
{
	global $auth,$isModerator;

	if(!$isModerator) return 0;

	$objResponse =  new xajaxResponse();

	mysql_query("delete from chat_messages where Id='".$message_id."'");


	$objResponse->addAssign("lastChatMessageID","innerHTML",0);
	$objResponse->addAlert("Message deleted");

	return $objResponse;
}


function addMessage($message,$userID,$Color)
{
	global $isModerator,$auth,$_SESSION;

	$userID=$auth->user;


	$objResponse =  new xajaxResponse();
	$message = htmlspecialchars($message);


	$q=select("select BanTime from chat_settings where UserID=$userID");
	if($q[0]>mktime()) 
	{
		$message="Вы забанены до ".date("d.m.Y H:i",$q[0]);
		$message = iconv('windows-1251','utf-8',$message);
		$objResponse->addAlert($message);
		return $objResponse;
	}


	$message = preg_replace('=([^\s]*)\@(.*)\.([^\s]*)=','<a href=mailto:\\1@\\2.\\3>\\1@\\2.\\3</a>',$message);

	if(!strstr($message,"www.")) 	$message = preg_replace('=([^\s]*)(http://)([^\s]*)=','<a href=\\2\\3 target=\'_new\'>\\2\\3</a>',$message);
	$message = preg_replace('=([^\s]*)(www.)([^\s]*)=','<a href=http://\\2\\3 target=\'_new\'>\\2\\3</a>',$message);


	$message=addslashes($message);

	if(trim($message))
	{
		$privateId = 0;
		//check for private

		$m=substr($message,0,strpos($message,":")).": ";

		preg_match("%\[private\s([^\]]+)\]:(.*)%",$message,$tmp);
		if(isset($tmp[2]))
		{

			$tmp[1]=trim($tmp[1]);

			$tmp[1] = iconv('utf-8','windows-1251',$tmp[1]);

			$res = mysql_query("select UserID from ut_users where Login='$tmp[1]'");
			$data = mysql_fetch_row($res);
			if($data)
			{
				$privateId = $data[0];
			}
			$message = $tmp[2];
		}

	  $q=mysql_query("select * from chat_messages where UserID='$userID' order by MessageTime desc limit 0,1");
	  $q=mysql_fetch_array($q);



	  if(trim($message)&&$message!=$q[Message])
	  {
		

		if($Color&&$message) $message="<font color=$Color>$message</font>";

		//if($FontSize==2) $message="<font size=2pt>$message</font>";
		//elseif($FontSize==3) $message="<font size=2pt><b>$message</b></font>";

		$t2=substr(mktime(),0,strlen(mktime())-3);
		mysql_query("insert into chat_messages (UserID,Message,MessageTime,PrivateUserID,MessageTime2) values($userID,'$message',unix_timestamp(),$privateId,'$t2')");

		if(!mysql_error())
		{
			$login=$auth->nick;
			$login = iconv('windows-1251','utf-8',$login);

			$str = date("H:i",mktime())." <a href='javascript:addUserToMessage(\"$login\", 0)' class=nickName".(($privateId)?"Private":"").">".$login."</a>: <span class=chatMessage".(($privateId)?"Private":"").">".$message."</span><br />";
 			//if($isModerator) $str = "<a href='javascript:DeleteMessage(".mysql_insert_id().")' class=nickName>[X]</a> ".$str;

			$objResponse->addAppend("chatContent","innerHTML",$str);

			$_SESSION['chatcontent'].=$str;



			if($privateId) $objResponse->addScript("chatInput.value = '$m';");
			else $objResponse->addScript("chatInput.value = '';");

			$objResponse->addScript("chatContent.scrollTop=1000000");
		}
		//else $objResponse->addAlert(mysql_error());

	   }	
	}

	return $objResponse;
	
	
}
function refreshUser($userID)
{
	global $auth;

	$userID=$auth->user;

	if($userID) mysql_query("insert into chat_users (UserID, LastRefresh,isModerator) values ('$userID', Now(),(select if(count(PermissionID)=0,0,1) from en_permissions
where (Type='chat/messages' or Type='*')
and (UserID='$userID' or TypeID in
(select p.TypeID from ut_posts p where p.TypeID=TypeID and UserID='$userID')))) on duplicate key update LastRefresh=Now()");

}
function logOutChat($userID)
{
	global $auth;

	$userID=$auth->user;

	$objResponse =  new xajaxResponse();
	if($userID)
	{
		mysql_query("delete from chat_users where userId=$userID");
	}
	return $objResponse;
}


function updateSettings($userID,$FontSize,$Height,$MessagesCount,$Color)
{
	global $auth;

	$userID=$auth->user;


	$objResponse =  new xajaxResponse();
	if($userID)
	{
		mysql_query("insert into chat_settings(UserID,FontSize,Height, MessagesCount,Color) values('$userID','$FontSize','$Height', '$MessagesCount','$Color') 
on duplicate key update Fontsize='$Fontsize',Height='$Height',MessagesCount='$MessagesCount',Color='$Color'");
	}
	return $objResponse;
}

function refreshContent($lastID,$userID,$num)
{
	global $_SESSION,$auth,$isModerator;

if(!$num) $num=20;

	$userID=$auth->user;


	$objResponse = new xajaxResponse();
	refreshUser($userID);
	$res = mysql_query("
			select chat_messages.ID,ut_users.Login, chat_messages.Message, chat_messages.MessageTime, chat_messages.PrivateUserID,chat_messages.UserID
				from chat_messages,ut_users 
				where ut_users.UserID = chat_messages.UserID and chat_messages.ID>'$lastID' and (chat_messages.PrivateUserID='$userID' or chat_messages.UserID='$userID' or chat_messages.PrivateUserID=0) and chat_messages.UserID<>'$userID' order by chat_messages.ID desc limit $num");
	$newLastID = $lastID;
	
	$str = "";
	
	while($data = mysql_fetch_array($res))
	{
		if($newLastID == $lastID)
			$newLastID = $data[0];
		$date = split(' ',$data[3]);
		$login = iconv('windows-1251','utf-8',$data[1]);

		$message = $data[2];
		if(!$data[4] || ($data[4] && ($data[4] == $userID || $data[5] == $userID)))
		{
			

			$str = date("H:i",$data[3])." <a href='javascript:addUserToMessage(\"$login\", 0)' class=nickName".(($data[4])?"Private":"").">".$login."</a>: <span class=chatMessage".(($data[4])?"Private":"").">".$message."</span><br />".$str;

 			//if($isModerator) $str = "<a href='javascript:DeleteMessage(".$data[0].")' class=nickName>[X]</a> ".$str;

		}
	}
	

if($str)
{


	$res2 = mysql_query("
			select chat_messages.ID,ut_users.Login, chat_messages.Message, chat_messages.MessageTime, chat_messages.PrivateUserID,chat_messages.UserID
				from chat_messages,ut_users 
				where ut_users.UserID = chat_messages.UserID  and (chat_messages.PrivateUserID='$userID' or chat_messages.UserID='$userID' or chat_messages.PrivateUserID=0) order by chat_messages.ID desc limit $num");
	$str2 = "";
	while($data = mysql_fetch_array($res2))
	{
		if($newLastID == $lastID)
			$newLastID = $data[0];
		$date = split(' ',$data[3]);
		$login = iconv('windows-1251','utf-8',$data[1]);
		$message = $data[2];
		if(!$data[4] || ($data[4] && ($data[4] == $userID || $data[5] == $userID)))
		{
			
			$str2 = date("H:i",$data[3])." <a href='javascript:addUserToMessage(\"$login\", 0)' class=nickName".(($data[4])?"Private":"").">".$login."</a>: <span class=chatMessage".(($data[4])?"Private":"").">".$message."</span><br />".$str2;

 			//if($isModerator) $str2 = "<a href='javascript:DeleteMessage(".$data[0].")' class=nickName>[X]</a> ".$str2;
		}
	}

	if($str2) $_SESSION['chatcontent']=$str2;
}

	//if($auth->user==455) $objResponse->addAlert("-- $isModerator");

	if($newLastID)
		$objResponse->addAssign("lastChatMessageID","innerHTML",$newLastID);

	if($lastID) $objResponse->addAppend("chatContent","innerHTML",stripslashes($str));
	else $objResponse->addAssign("chatContent","innerHTML",stripslashes($str2));
	
	$userList="";
	$res = mysql_query("select u.Login,u.UserID,c.LastRefresh,u.Rang,if(c.isModerator=1,1,0) isModerator ,s.BanTime ,
u.GuildID,u.GuildStatusID from ut_users u,chat_users c left outer join chat_settings s on s.UserID=c.UserID where c.UserID=u.UserID");	

	while($data = mysql_fetch_array($res))
	{
		$data1 = strtotime($data[2]);
		$data2 = time();

		$seconds = $data2 - $data1;
		if($seconds > 600)
		{
			mysql_query("delete from chat_users where UserId=$data[1]");
			continue;
		}


		$data[Login] = iconv('windows-1251','utf-8',htmlspecialchars($data[Login]));
		$nameUser=$data[Login];

		$login=$nameUser;
		//$login=username($data,0);

		if($data[GuildID]&&$data[GuildStatusID]==1) $login=guildlogo($data[GuildID],0)." ".$login;

		if($data[isModerator]) $login="<b>".$login."</b>";

		$userList .=  (($data[3]>0)?"<img src='http://www.butsa.ru/images/vip/$data[3].gif' />&nbsp;":"")."<a href='javascript:addUserToMessage(\"$nameUser\", 0)'>$login</a> 
		<a href='/users/$data[1]' >
			<img style='border:none;' src='/images/icons/profile.gif' align=absmiddle title='Info' alt='Info'></a>
		<a href='javascript:addUserToMessage(\"$nameUser\",1)' >
			<img style='border:none;' src='/images/icons/mail.gif' align=absmiddle  title='Private' alt='Private'></a>";

		if($isModerator)
		{
			if(mktime()>$data[BanTime]) $userList .= " <a href='javascript:BanUser(\"".$data[UserID]."\",\"$nameUser\",ban_time.value)' >[ban]</a><br>";
			else $userList .= " ".date("d.m.Y H:i",$data[BanTime])." - "."<a href='javascript:UnBanUser(\"".$data[UserID]."\",\"$nameUser\")' >[unban]</a><br>";

		}
		else $userList .= "<br>";

	}
			

	if($userList) $_SESSION['chatusers']=$userList;
	$objResponse->addAssign("chatUsersList","innerHTML",$userList);
	$objResponse->addScript("scrollDown()");
	$objResponse->addScript("chatRefreshInterval = window.setInterval(\"refreshContent()\",3000);");
	
	$chatData = select("select count(*) from chat_users");
	$chatersCount = ($chatData)?$chatData[0]:0;
	$objResponse->addAssign("chatersCount","innerHTML",$chatersCount);
	

	if(!$lastID) 		$objResponse->addScript("chatContent.scrollTop=1000000;");
	
	return $objResponse;
}

function test($addedWord)
{
	
}
$xajax = new xajax(); 
$xajax->registerFunction("addMessage",XAJAX_GET);
$xajax->registerFunction("updateSettings",XAJAX_GET);
$xajax->registerFunction("refreshContent",XAJAX_GET);
$xajax->registerFunction("logOutChat",XAJAX_GET);
$xajax->registerFunction("DeleteMessage",XAJAX_GET);
$xajax->registerFunction("BanUser",XAJAX_GET);
$xajax->registerFunction("UnBanUser",XAJAX_GET);


//$xajax->processRequests();
//$xajax->printJavascript("http://".$_SERVER["SERVER_ADDR"].'/cls/ajax/');






?>