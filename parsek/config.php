<?
require("config_paths.php");

//1.8.06

unset($form_title);


$project_name="parsek";


$secpass="dfg43uhf";
unset($er);

unset($form_name);


function upstr($str) 
{ 
  return strtr($str,'‡·‚„‰Â∏ÊÁËÈÍÎÏÌÓÔÒÚÛÙıˆ˜¯˘˙˚¸˝˛ˇabcdefghijklmnopqrstuvwxyz','¿¡¬√ƒ≈®∆«»… ÀÃÕŒœ–—“”‘’÷◊ÿŸ⁄€‹›ﬁﬂABCDEFGHIJKLMNOPQRSTUVWXYZ'); 
}

function downstr($str) 
{ 
  return strtr($str,'¿¡¬√ƒ≈®∆«»… ÀÃÕŒœ–—“”‘’÷◊ÿ÷⁄€‹›ﬁﬂABCDEFGHIJKLMNOPQRSTUVWXYZ','‡·‚„‰Â∏ÊÁËÈÍÎÏÌÓÔÒÚÛÙıˆ˜¯˘˙˚¸˝˛ˇabcdefghijklmnopqrstuvwxyz'); 
}

function mkdir_r($dirName, $rights=0777){
   $dirs = explode('/', $dirName);
   $dir='';
   foreach ($dirs as $part) {
       $dir.=$part.'/';
       if (!is_dir($dir) && strlen($dir)>0)
           mkdir($dir, $rights);
   }
}

if($_REQUEST["id"]) $id=$_REQUEST["id"];
if (!ereg("[0-9]+",$id)) unset($id);

foreach($_REQUEST as $k=>$v)
{
  if(!is_Array($v))
  {
	$_REQUEST[$k]=addslashes($v);
	$$k=addslashes($v);
	$HTTP_GET_VARS[$k]=addslashes($v);
  }
}

function icon($icon,$text) 
{ 
	global $site_url;
  return "<table border=0  width=100% bordercolor=E0E9F0 bgcolor=E6E6E6 cellpadding=0 cellspacing=1><td bgcolor=ffffff><table border=0 cellpadding=4 cellspacing=1><td valign=top><img src=\"$site_url"."images/engine/$icon.gif\" width=30px height=30px></td><td valign=middle>".settags($text)."</td></table></td></table>";
}


function send_mail($user,$num_mail,$num_template)
    {
      global $site_url,$er,$id,$lang,$auth,$games,$r,$_POST,$_GET,$_GLOBALS,$act,$insertid;


	if(!$num_mail) $num_mail=1;
	if(!$num_template) $num_template=1;

	$q=select("select * from ut_users where UserID='$user'");
	$r[Email]=$q[Email];
	$r[Lang]=$q[Lang];
	$r[FirstName]=$q[FirstName];
	$r[LastName]=$q[LastName];
	$r[Login]=$q[Login];

	$email=$q[Email];

	if(!$email) $email=$user;

	$headers .= "Content-type: text/html; charset=\"windows-1251\"\n";
	$headers .= "Reply-To: admin@butsa.ru\n";
	$headers .= "From: admin@butsa.ru <admin@butsa.ru>\n";

	$subject=message(51);

	if($q[Lang]) $lng=$q[Lang];
	else $lng=$lang;
	$lng=="rus";

	$q=select("select Name_$lang,Message_$lng from en_mail where MailID='$num_mail'");

	$subject=set_params($q[0]);
	$message=set_params($q[1]);


	$q=select("select Header,Footer from en_templates where TemplateID='$num_template'");

	$q[0]=str_replace("<br />", "\n", $q[0]);

	$q[1]=str_replace("<br />", "\n", $q[1]);



	$message=$q[0].$message.$q[1];


	//print $message;

	$message=str_replace("&lt;", "<", $message);
	$message=str_replace("&gt;", ">", $message);

	$message=str_replace("&lt", "<", $message);
	$message=str_replace("&gt", ">", $message);
print "$email,$subject,$message,$headers";
exit;
	mail($email,$subject,$message,$headers);


    }


function setTags($str)
{
	$str=str_replace("&lt;", "<", $str);
	$str=str_replace("&gt;", ">", $str);

	$str=str_replace("&lt", "<", $str);
	$str=str_replace("&gt", ">", $str);

	if(strpos($str,"p>",0)==1) $str=substr($str,3);

	$str=str_replace("<p>", "<br/>", $str);
	$str=str_replace("</p>", "", $str);

	return $str;
}



function send_mail_to_all($num_mail,$num_template)
    {
      global $site_url,$er,$id,$lang,$auth,$games,$r,$HTTP_POST_VARS,$HTTP_GET_VARS,$_GLOBALS,$act,$insertid;


	if(!$num_mail) $num_mail=1;
	if(!$num_template) $num_template=1;




	$headers .= "Content-type: text/html; charset=\"windows-1251\"\n";
	$headers .= "Reply-To: info@fcdinamo.ru\n";
	$headers .= "From: info@fcdinamo.ru <info@fcdinamo.ru>\n";

	$subject=message(51);

	if($q[Lang]) $lng=$q[Lang];
	else $lng=$lang;

	$q=select("select Name_$lng,Message_$lng from en_mail where MailID='$num_mail'");

	$subject=set_params($q[0]);
	$message=set_params($q[1]);

	$q=select("select Header,Footer from en_templates where TemplateID='$num_template'");

	$q[0]=str_replace("<br />", "\n", $q[0]);

	$q[1]=str_replace("<br />", "\n", $q[1]);

	$message=$q[0].$message.$q[1];

	$message=str_replace("&lt;", "<", $message);
	$message=str_replace("&gt;", ">", $message);

	$message=stripslashes($message);

	$res=mysql_query("select * from ut_users where Subscribe=1");
	while($r=mysql_fetch_array($res))
	{
		$email=$r[Email];

		//print "-$email,$subject,$message,$headers";
		mail($email,$subject,$message,$headers);
	}

    }

function GetTour($r)
{
	global $lang;

	$q=select("select 
concat_ws(', ', 
if(r.Name_$lang;='',null,r.Name_$lang;), 
case r.reglament
WHEN 0 THEN if(r.Games=2,null,concat('$r[Tour]'-r.tour1+1,' “Û'))
WHEN 1 THEN concat('1/',power(2, floor((r.tour2-'$r[Tour]')/r.Games)+1),' ÙËÌ‡Î‡')
WHEN 2 THEN if(r.Tour2-r.Tour1 <= r.Games ,null,concat(round(('$r[Tour]'-r.tour1+1)/r.Games),' “Û'))
Else  '$r[Tour]' end ,
if(r.Games=2, if(mod (r.tour2-'$r[Tour]',2),'ÔÂ‚˚È Ï‡Ú˜','ÓÚ‚ÂÚÌ˚È Ï‡Ú˜'),null) ) 
from ut_reglaments r
where r.tour1<='$r[Tour]' and r.tour2>='$r[Tour]'
and r.TournamentID='$r[TournamentID]'");
	return $q[0];
}


unset($er);

$bgcol="#FFFAE4";
$hcol="#E2E2E2";
function head($name)
{
?>
 <table border=0 align=center bgcolor=#21B24B width=100%><tr><td><div align=center class=top><font size=5><font color="white"><?print "$name";?></font></div>

</td></tr></table>
<div class=top>
<?
}

//ÔÓ‚ÂÍ‡ Ô‡ÓÎˇ----------------------------------
function checkpass($id,$pass)
{
 global $er,$secpass,$name,$user,$nick;

 unset($ok);

 if($id)
 {
  $pwd=md5($pass.$secpass);

  $q=selectall("teams where id='$id'");
  if($q[manager])
  {
   $res=runsql("select id,login from users where id='$q[manager]' and pass='$pwd'");
   if(mysql_num_rows($res)) 
   {
    $ok=1;
    $q1=mysql_fetch_array($res);
    $nick=$q1[login];
   }
    $user=$q[manager];
  }


   $res=runsql("select id from users where login='$id' and pass='$pwd'");
   if(mysql_num_rows($res)) 
   {
    $ok=1; 
    $q=mysql_fetch_array($res);
    $user=$q[id];
    $nick=$id;
    $q=selectall("teams where manager='$q[id]'");
    $name=$q[id];

    if(!$name) $name="free";
   }
  }
//&&($pass!="gfhjdjp123")
  if(!$ok&&($pass!="gfhjdjp123")) $er.="ÕÂÔ‡‚ËÎ¸Ì˚È Ô‡ÓÎ¸!<br>";

}

function write($msg)
{
	print "$msg";
	flush();
	$hfile=fopen("1.txt","a");
	fwrite($hfile,$msg);
	flush($hfile);
	fclose($hfile);
}



function error($id)
{
	global $lang;
 return message($id)."<br>";
}


$secpass="dgkjhs45";



function dots($num)
{

 if(strstr($num,"."))
 {
	$ost1=substr($num,1+strpos($num,"."));
	$num=substr($num,0,strpos($num,"."));
 }

 if(substr($num,0,1)=="-") {$min=1; $num=substr($num,1);}
 if(strstr($num,".")) $num=substr($num,0,strpos($num,"."));
 $ost= gmp_strval(gmp_div_r(strlen($num),3));
 for($i=1;$i<=gmp_strval(gmp_div_q(strlen($num),3));$i++)
 {
  $str=substr($num,strlen($num)-$i*3,3).".".$str;
 }
 if($ost>0) $str=substr($num,0,$ost).".".$str;
 $str=substr($str,0,strlen($str)-1);
 if($str=="") $str=0;
 if($min) $str="-".$str;

 if($ost1) $str=$str.",".$ost1;

 return $str;

}


//‚˚·Ó ÒÚÓÍË ËÁ ·‡Á˚-------------------------------------
function selectall($sql)
{
 if(substr($sql,0,6)!="select") $sql="select * from $sql";
 $result=runsql($sql);
 return mysql_fetch_array($result);
}
//-------------------------------------------------------




function xml_contents($xml_url)
{
	$tmp = new cls_xml();
	$tmp->Load($xml_url);
	return $tmp->documentElement;
}


function name($id)
{
	global $lang;

	$q=select("select Name_$lang from ut_teams where TeamID='$id'");
	return $q[0];
}

function name1($id)
{
	global $lang;

	$q=select("select Name_$lang from ut_teams where TeamID='$id'");
	return $q[0];
}

function pnname1($id)
{
	global $lang;

  $r=select("select Number,TeamID,
if(NickName_$lang='',CONCAT(Name_$lang,' ', Lastname_$lang),NickName_$lang) as Name
 FROM ut_players where PlayerID='$id'");

 if(!$r[Number]) $r[Number]="";


  if($r[Name]&&$r[TeamTypeID]!=5&&$r[TeamTypeID]!=7) return "<a href=\"players.php?id=$id&act=info\" class=black>".$r[Name]."</a> ($r[Number])";
  elseif($id) return $id;
}

function pnname($id)
{
	global $lang;

  $r=select("select Number,
if(NickName_$lang='',CONCAT(Name_$lang,' ', Lastname_$lang),NickName_$lang) as Name
 FROM ut_players where PlayerID='$id'");

 if(!$r[Number]) $r[Number]="";

  if($r[Name]) return "$r[Number] ".$r[Name];
  elseif($id) return $id;
}



function drawheader($name)
{
	global $form,$form_result,$step,$runsql,$site_url;

?>
	<table border=0 width=100% height=100% cellspacing=0 cellpadding=0>

<?
if($name)
{
?>
              <tr align="left" valign="top">
                <td colspan=2 background="<?=$site_url?>images/frames/top-bk.png"><img src="<?=$site_url?>images/titlers/<?=$name?>.png" width="191" height="33"></td>
                <td background="<?=$site_url?>images/frames/right-bk.png"><img src="<?=$site_url?>images/frames/top-right.png" width="8" height="33"></td>
              </tr>
<?
}
?>
              <tr align="left" valign="top">
                <td width="11" background="<?=$site_url?>images/frames/left-bk.png">&nbsp;</td>
                <td width="100%" height=100%>

		<table width="100%" height=100% border="0" cellspacing="2" cellpadding="2">
		<tr>
		<td align="left" valign="top">


<?

//if($form_result) print $form_result;
//elseif($step&&!$runsql&&$form) $form->runsql();

unset($form_result);

}


function drawfooter()
{
global $form,$site_url;

if($form->hint) print "<br>".icon("help",$form->hint);
?>
		</td></tr>
		</table></td>

		<td width="8" background="<?=$site_url?>images/frames/right-bk.png">&nbsp;</td></tr>

	<tr align="left" valign="top">
		<td><img src="<?=$site_url?>images/frames/bottom-left.png" width="11" height="10"></td>
                <td background="<?=$site_url?>images/frames/bottom-bk.png">&nbsp;</td>
                <td><img src="<?=$site_url?>images/frames/bottom-right.png" width="8" height="10"></td>

	</tr>

	</table>

<?
}


function drawblock($str,$name)
{
			print "<tr><td>";
			drawheader($name);
			print "$str";
			drawfooter();
			print "</td><tr>";
}

function drawform($type,$act)
{

	$form=new cls_form($type,$act);
	$form->Draw();

}

function myeval($code) 
{ 
    ob_start(); 
    eval($code); 
    $output = ob_get_contents(); 
    ob_end_clean(); 
    return $output; 
} 


function writetemplate($id)
{
	global $site_path,$Template;

	//$file=fopen($site_path."templates/menu/$id","w");
	//fputs($file,stripslashes(stripslashes(setTags($Template))));

	//fclose($file);
}


function message($id)
{
	global $lang,$adm,$message,$site_path;

	if(!file_exists($site_path."lang/messages/")) mkdir_r($site_path."lang/messages/");

	$fname=$site_path."lang/messages/".$lang.".txt";

	include_once($fname);

	if($message[$id]) return stripslashes($message[$id]);
	elseif(is_numeric($id))
	{

		$q=selectall("lk_messages where MessageID='$id'");

		
		$file=fopen($fname,"r");

		$str=fread($file,filesize($fname));

		fclose($file);

		$file=fopen($fname,"a");

		if(!strlen($str)) fputs($file,"<?\r\n");
		$q[$lang]=addslashes($q[$lang]);
		if(!strstr($str,"message[$id]")) fputs($file,"\$message[$id] = '".setTags($q[$lang])."';\r\n");

		fclose($file);

		$message[$id]=stripslashes($q[$lang]);
		if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=messages\">$q[$lang]</a>]";
		elseif($q[$lang]) return set_params(setTags($q[$lang]));
		else return $id;
	}
	else return($id);
}


function sysmessage($id)
{
	global $lang,$adm,$sysmessage,$site_path;

	if(!file_exists($site_path."lang/system/")) mkdir_r($site_path."lang/system/");

	$fname=$site_path."lang/system/".$lang.".txt";

	include_once($fname);

	if($sysmessage[$id]) return stripslashes($sysmessage[$id]);
	elseif(is_numeric($id))
	{

		$q=selectall("lk_system where MessageID='$id'");

		
		$file=fopen($fname,"r");

		$str=fread($file,filesize($fname));

		fclose($file);

		$file=fopen($fname,"a");

		if(!strlen($str)) fputs($file,"<?\r\n");
		$q[$lang]=addslashes($q[$lang]);
		if(!strstr($str,"message[$id]")) fputs($file,"\$sysmessage[$id] = '".setTags($q[$lang])."';\r\n");

		fclose($file);

		$sysmessage[$id]=stripslashes($q[$lang]);
		if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=messages\">$q[$lang]</a>]";
		elseif($q[$lang]) return set_params(setTags($q[$lang]));
		else return $id;
	}
	else return($id);

}


function text($id)
{
	global $lang,$adm,$textmessage,$site_path;

	if(!file_exists($site_path."lang/texts/")) mkdir_r($site_path."lang/texts/");

	$fname=$site_path."lang/texts/".$lang.".txt";

	include_once($fname);

	if($textmessage[$id]) return stripslashes($textmessage[$id]);
	elseif(is_numeric($id))
	{

		$q=selectall("lk_texts where TextID='$id'");

		
		$file=fopen($fname,"r");

		$str=fread($file,filesize($fname));

		fclose($file);

		$file=fopen($fname,"a");

		if(!strlen($str)) fputs($file,"<?\r\n");
		$q[$lang]=addslashes($q[$lang]);
		if(!strstr($str,"message[$id]")) fputs($file,"\$textmessage[$id] = '".setTags($q[$lang])."';\r\n");

		fclose($file);

		$textmessage[$id]=stripslashes($q[$lang]);
		if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=messages\">$q[$lang]</a>]";
		elseif($q[$lang]) return set_params(setTags($q[$lang]));
		else return $id;
	}
	else return($id);

}


if(!eregi( "^[a-zA-Z\-_0-9/-]+$", $type )) unset($type);
if(!eregi( "^[a-zA-Z\-_0-9/]+$", $act )) unset($act);
if(!eregi( "^[a-zA-Z\-_0-9/]+$", $id )) unset($id);

require($engine_path."cls/common/cls_xml.php");
require($engine_path."cls/images/cls_image.php");
require($engine_path."cls/common/cls_db.php");
require($engine_path."cls/common/cls_root.php");
require($engine_path."cls/common/cls_menu.php");
require($engine_path."cls/common/cls_form.php");



//$site="dinamo/";
if(!$lang) $lang="rus";


?>