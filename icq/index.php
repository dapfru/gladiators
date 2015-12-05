<?
error_reporting(0);
include("settings.php");

function login()
{
 global $login, $password, $cook_file;	
 $post="&url=%2Fedit%2F&login=".$login."&pass=".$password."&auth_type=1&subm=1"; 
 $head="POST /login/?url=%2Fedit%2F HTTP/1.0\r\n";
 $head.="Accept: */*\r\n";
 $head.="Referer: http://passport.bigmir.net/login/\r\n";
 $head.="Content-Type: application/x-www-form-urlencoded\r\n";
 $head.="User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)\r\n";
 $head.="Host: passport.bigmir.net\r\n";
 $head.="Content-Length: ".strlen($post)."\r\n\r\n";
 $head.=$post;
 if(!$sock=fsockopen("passport.bigmir.net",80)) return "0";
 fputs($sock, $head);
 unset($res);
 while(!feof($sock)) $res.=fgets($sock, 1024);
 fclose($sock);
 if(strpos($res,"302 Found")!=0)
 	{
 	 $res=substr($res,strpos($res,"BMS=")+4,16);
 	 $fp=fopen($cook_file,"w");
 	 flock($fp,2);
	 fputs($fp,"<? \$bms=\"".$res."\"; ?>");
	 flock($fp,3);
 	 fclose($fp);
 	 return 1;
 	}
 else return 0;
}

function get_id()
{
 global $cook_file;
 if(file_exists($cook_file)) include($cook_file);
 $head="GET /icq HTTP/1.0\r\n";
 $head.="Accept: */*\r\n";
 $head.="Referer: http://passport.bigmir.net/login/\r\n";
 $head.="User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)\r\n";
 $head.="Host: passport.bigmir.net\r\n";
 $head.="Cookie: BMS=".$bms."\r\n\r\n";
 if(!$sock=fsockopen("passport.bigmir.net",80)) return "0";
 fputs($sock, $head);
 $res="";
 while(!feof($sock)) $res.=fgets($sock, 1024);
 fclose($sock);
 if(strpos($res,"302 Found")) return "302";
 $tpos=strpos($res,"http://ui.bigmir.net/gen/rnd/");
 return substr($res,$tpos,strpos($res,"\"",$tpos)-$tpos); 	
}

function reg_icq($code)
{
 global $login, $password, $cook_file, $uins_file, $save_mail, $save_nick;	
 if(file_exists($cook_file)) include($cook_file);
 $n=file("names.txt");
 $nick=eregi_replace("\r\n","",$n[rand(0,count($n)-1)]);
 $post="&have_icq=2&icq_nick=".urlencode($nick)."&code=".$code."&icq_save=1&subm=1";
 $head="POST /icq/ HTTP/1.0\r\n";
 $head.="Accept: */*\r\n";
 $head.="Referer: http://passport.bigmir.net/icq/\r\n";
 $head.="Content-Type: application/x-www-form-urlencoded\r\n";
 $head.="User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)\r\n";
 $head.="Host: passport.bigmir.net\r\n";
 $head.="Cookie: BMS=".$bms."\r\n";
 $head.="Content-Length: ".strlen($post)."\r\n\r\n";
 $head.=$post;
 if(!$sock=fsockopen("passport.bigmir.net",80)) return "0";
 fputs($sock, $head);
 unset($res);
 while(!feof($sock)) $res.=fgets($sock, 1024);
 fclose($sock);	
 if(strpos($res,"302 Found")!=0)
 	{
 	 $head="GET /reg_ok HTTP/1.0\r\n";
 	 $head.="Accept: */*\r\n";
 	 $head.="Referer: http://passport.bigmir.net/icq/\r\n";
 	 $head.="User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)\r\n";
 	 $head.="Host: passport.bigmir.net\r\n";
 	 $head.="Cookie: BMS=".$bms."\r\n\r\n";	
 	 if(!$sock=fsockopen("passport.bigmir.net",80)) return "0";
 	 fputs($sock, $head);
 	 unset($res);
 	 while(!feof($sock)) $res.=fgets($sock, 1024);
 	 fclose($sock);
  	 if(strpos($res,"Ваш <b>ICQ")!=0) 
 	 	{
 	 	 $res=substr($res,strpos($res,"Ваш <b>ICQ")+17,9);
 	 	 $fp=fopen($uins_file,"a");
 	 	 flock($fp,2);
 	 	 $res.=";".$password;
 	 	 if($save_mail) $res.=";".$login."@bigmir.net";
 	 	 if($save_nick) $res.=";".$nick; 	 	 
	 	 fputs($fp,$res."\r\n");
	 	 flock($fp,3);
 	 	 fclose($fp);
 	 	 return 1;
 	 	}
 	} 
 return 0;
}

if($_GET["clear"]==1)
	{
	 $fp=fopen($uins_file,"w");
 	 flock($fp,2);
 	 flock($fp,3);
 	 fclose($fp);
	 header("Location: ./");
	}

if(strlen($_POST["code"])==4) reg_icq($_POST["code"]);

while(true) 
	{
	 $pic=get_id();
	 if(strlen($pic)>=20) break;
	 if($pic=="302") $login_ret=login();
	}
?>	
<html><head><title>bigmir)net - ICQ Regger by k1der</title>
<meta http-equiv=pragma content=no-cache>
<meta http-equiv="expires" content="Mon, 01 Jan 1990 00:00:00 GMT">
<meta http-equiv=Content-Type content="text/html; charset=windows-1251"></head>
<body bgcolor="#FFFFFF" text="black" onload="document.check.code.focus()">
<script language="javascript">
function auto_submit(ct)
{ 
 if(ct.length==4) enter();
}
function enter()
{ 
 if(document.check.code.disabled==false&&document.check.code.value.length==4)
 { 
  document.check.submit();
  document.check.code.disabled=true;
 }
 return false;
}
</script>
<table width="75%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td align="left" valign="top">
<?
echo "<b>Uins file:</b><br>".$uins_file."<br>";
if(file_exists($uins_file))
	{
	 echo "<a href=\"?clear=1\"><small>[clear]</small></a>";
	 echo "  <a href=\"".$uins_file."\"><small>[download]</small></a>";
	 echo "<br><br>";
	 $uins=file($uins_file);
	 echo "<b>Uins count:</b><br><font size=\"2\" face=\"Georgia\">".count($uins)."</font><br><br>";
	 if(count($uins)>0)
	 	 {
	 	  echo "<b>Last 5 uins:</b><br>";
	 	  for($a=count($uins)-1;$a>=count($uins)-5;$a--)
	 	 	 {
	 	 	  if($a<0) break;
	 	 	  echo "<font size=\"2\" face=\"Georgia\">".substr($uins[$a],0,strpos($uins[$a],";"))."</font><br>";
	 	 	 }
	 	 }	 
	}
?>
</td><td align="center" valign="top"><br><br>
<table border="0" cellspacing="0" cellpadding="0" align="center">
<tr align="center"><td><img src="images/main.png" width="302" height="22" border="0" vspace="0" hspace="0">
</td></tr><tr><td><br>
<?
echo "<img src=\"images/picture.php?code=".base64_encode(substr($pic,20,strlen($pic)-20))."\" width=\"300\" height=\"150\" border=\"1\" vspace=\"0\" hspace=\"0\">";
?>
</td><tr><td><br><table border="0" cellspacing="0" cellpadding="0" align="left">
<tr><td width="302" align="center" valign="top">
<form name="check" method="post" action="" onsubmit="return enter()">
<input name="code" type="text" value="" maxlength="4" onkeyup="auto_submit(this.value);" style="border-right: 1px solid Black; border-top: 1px solid Black; border-bottom: 1px solid Black; border-left: 1px solid Black; height:22px; width:100px;">
</form></td></tr></table></td></tr></table></td></tr></table></body></html>
<!--- Script by k1der ---!>