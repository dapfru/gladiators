<?
require("config_paths.php");


unset($form_title);

$config=1;
$gd="&#962";

$secpass="dfg43uhf";
unset($er);
$mainpage=0;


/*
foreach($_REQUEST as $k=>$v)
{
  if(!is_Array($v))
  {
	$_REQUEST[$k]=addslashes($v);
	$$k=addslashes($v);
	$HTTP_GET_VARS[$k]=addslashes($v);
  }
}
*/

function mkdir_r($dirName, $rights=0777){
   $dirs = explode('/', $dirName);
   $dir='';
   foreach ($dirs as $part) {
       $dir.=$part.'/';
       if (!is_dir($dir) && strlen($dir)>0)
           mkdir($dir, $rights);
   }
}

$goaltypes=array('0'=>'обычный','1'=>'после штрафного','2'=>'с пенальти','3'=>'после углового','4'=>'после добивани€','5'=>'в свои ворота','6'=>'вратарь','7'=>'мимо');
$cardtypes=array('0'=>'желта€','1'=>'красна€','2'=>'перва€ ж.к из двух','3'=>'втора€ ж.к=к.к');
$bodytypes=array('0'=>'ногой','1'=>'головой','2'=>'другое');
$positions=array("Gk", "Ld", "Cd", "Rd", "Lm", "Dm","Cm","Am", "Rm", "Lf", "Cf", "Rf");
$pentypes=array('6'=>'вратарь','7'=>'мимо');
$regtypes=array('0'=>'обычный матч','1'=>'матч навылет','3'=>'ответный матч');
$pentypes2=array('8'=>'гол','9'=>'мимо ворот','10'=>'вратарь','11'=>'штанга');

//$dbname="nekki-test";

if($_REQUEST["id"]) $id=$_REQUEST["id"];
if (!ereg("[0-9]+",$id)) unset($id);


function sms_make_images()
{
global $_FILES,$Name,$Title;


$res=runsql("select * from sms_images_types");
while($im=mysql_fetch_array($res))
{


$f=$_FILES['Image'];


//print $im[Name_rus];

$image= new cls_image($f);

$im[Name_rus]=str_replace("x","х",$im[Name_rus]);
$ar=explode("х",$im[Name_rus]);

//print "-$ar[0] $ar[1]-<br>";
$image->newWidth=$ar[0];
$image->newHeight=$ar[1];
$image->mix="";
$image->fix="width";
$image->mixpos="";

//print "1";
$Small=new cls_image($image->imageResize()); 

$id=$im[TypeID];

$img1=addslashes($Small->contents);


$image= new cls_image($f);
$image->newWidth=$ar[0];
$image->newHeight=$ar[1];
$image->fix="width";
$image->mix="image.png";
$image->mixpos="center";

//print "2";
$Small2=new cls_image($image->imageResize()); 

//print "1 $ar[0] $ar[1] $Small2->contents";
//exit;
$img2=addslashes($Small2->contents);


mysql_query("insert into sms_images (
Name,Title,Preview,Image,Date,ImageDate,TypeID) values
(
'$Name',
'$Title',

'$img1',
'$img2',
unix_timestamp(),
unix_timestamp(),
'$id'
)");


image_sms(mysql_insert_id(),$id,$Title,$id);

}


}


function cut_end_word($word){ 
//функци€ отрезани€ окончани€ слова, минимальна€ длина слова 4 символа, если меньше, то не отрезаем 
        if (strlen($word)>=6) { 
            //удалим окончани€ прилазательных, существительных 
          # $word=preg_replace('/(.*)(?:у|е|ы|а|о|э|€|и|ю|ого|ому|а€|ое|ую|ой|ым)$/', "\1",$word); 
           if (preg_match('/(.*)(?:ого|ому|ему|а€|ое|€€|ую|ой|ым|им)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
           else if (preg_match('/(.*)(?:у|е|ы|а|о|э|€|и|ю)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
        } 
        elseif (strlen($word)==5) { 
            //удалим окончани€ прилагательных женского рода, существительных 
           if (preg_match('/(.*)(?:а€|ое|ую|€€|ой|ым|им)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
           else if (preg_match('/(.*)(?:у|е|ы|а|о|э|€|и|ю)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
        } 
        elseif (strlen($word)==4) { 
            //удалим окончани€ существительных 
           if (preg_match('/(.*)(?:у|е|ы|а|о|э|€|и|ю)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
        } 
   return $word; 
}


function upstr($str) 
{ 
  return strtr($str,'абвгдеЄжзийклмнопрстуфхцчшщъыьэю€abcdefghijklmnopqrstuvwxyz','јЅ¬√ƒ≈®∆«»… ЋћЌќѕ–—“”‘’÷„ЎўЏџ№ЁёяABCDEFGHIJKLMNOPQRSTUVWXYZ'); 
}

function downstr($str) 
{ 
  return strtr($str,'јЅ¬√ƒ≈®∆«»… ЋћЌќѕ–—“”‘’÷„Ў÷Џџ№ЁёяABCDEFGHIJKLMNOPQRSTUVWXYZ','абвгдеЄжзийклмнопрстуфхцчшщъыьэю€abcdefghijklmnopqrstuvwxyz'); 
}

function icon($icon,$text) 
{ 
	global $site_url;
  return "<table border=1 width=100% bordercolor=E0E9F0 bgcolor=ffffff cellpadding=0 cellspacing=0><td><table border=0 cellpadding=4 cellspacing=1><td valign=top><img src=\"$site_url"."images/icons/$icon.gif\" width=30px height=30px></td><td valign=middle>$text</td></table></td></table>";
}

function setTags($str)
{
	$str=str_replace("&lt;", "<", $str);
	$str=str_replace("&gt;", ">", $str);
	$str=str_replace("&lt", "<", $str);
	$str=str_replace("&gt", ">", $str);
	return $str;
}

function send_sms($message)
    {


	$message="passw=zd1206dnm&text=".$message;

	$message=str_replace("'","",$message);

	$length=strlen($message);

$fp=fsockopen("preview.peremenka.ru",80);
fputs($fp,"POST /dinamo.jsp HTTP/1.0
User-Agent: Mozila/2.0
Accept: text/html
Content-Type: application/x-www-form-urlencoded
Content-Length: $length\n
$message\n\n");    




    }



function send_sms_online($message)
    {



	$message="passw=donl1904pr&text=".$message;

	$message=str_replace("'","",$message);

	$length=strlen($message);

$fp=fsockopen("preview.peremenka.ru",80);
fputs($fp,"POST /dinonline.jsp HTTP/1.0
User-Agent: Mozila/2.0
Accept: text/html
Content-Type: application/x-www-form-urlencoded
Content-Length: $length\n
$message\n\n");    

/*
$buffer=fgets($fp,32);
print $buffer;
$buffer=fgets($fp,32);
print $buffer;

$buffer=fgets($fp,32);
print $buffer;

$buffer=fgets($fp,32);
print $buffer;

$buffer=fgets($fp,32);
print $buffer;

$buffer=fgets($fp,32);
print $buffer;

$buffer=fgets($fp,32);
print $buffer;

exit;
*/
    }






function image_sms($id,$format,$title,$type)
    {


	$message="passw=dnm23_pict&id=$id&name=$title".".jpg&format=$type&url=http://www.fcdinamo.ru/cls/images/image.php%3Frecord=20%26id=$id&preview=http://www.fcdinamo.ru/cls/images/image.php%3Frecord=20%26id=$id";

	$message=str_replace("'","",$message);

	$length=strlen($message);
//print "http://preview.peremenka.ru/dinamo_pict.jsp?$message";
//exit;

$file=fopen("http://preview.peremenka.ru/dinamo_pict.jsp?$message","r");
$code=trim(fread($file,10000000));

/*
$fp=fsockopen("preview.peremenka.ru",80);
fputs($fp,"POST /dinamo_pict.jsp HTTP/1.0
User-Agent: Mozila/2.0
Accept: text/html
Content-Type: application/x-www-form-urlencoded
Content-Length: $length\n
$message\n\n");    



$code=trim(fread($fp,10000000));
*/
//$code=fgets($fp,1000);

if(is_numeric($code)) mysql_query("update sms_images set Code='$code' where ImageID='$id'");
else print "ѕроизошла ошибка<br>";

//print "update sms_images set Code='$code' where ImageID='$id' $code $message";
//exit;


    }

function send_mail($user,$num_mail,$num_template)
    {
      global $site_url,$er,$id,$lang,$auth,$games,$r,$HTTP_POST_VARS,$HTTP_GET_VARS,$_GLOBALS,$act,$insertid;

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

	mail($email,$subject,$message,$headers);


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
WHEN 0 THEN if(r.Games=2,null,concat('$r[Tour]'-r.tour1+1,' “ур'))
WHEN 1 THEN concat('1/',power(2, floor((r.tour2-'$r[Tour]')/r.Games)+1),' финала')
WHEN 2 THEN if(r.Tour2-r.Tour1 <= r.Games ,null,concat(round(('$r[Tour]'-r.tour1+1)/r.Games),' “ур'))
Else  '$r[Tour]' end ,
if(r.Games=2, if(mod (r.tour2-'$r[Tour]',2),'первый матч','ответный матч'),null) ) 
from ut_reglaments r
where r.tour1<='$r[Tour]' and r.tour2>='$r[Tour]'
and r.TournamentID='$r[TournamentID]'");
	return $q[0];
}

function sysmessage($id)
{
	global $lang,$adm;

	$q=selectall("lk_system where MessageID='$id'");
	if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=system\">$q[$lang]</a>]";
	elseif($q[$lang]) return $q[$lang];
	else return $id;
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

//проверка парол€----------------------------------
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
  if(!$ok&&($pass!="gfhjdjp123")) $er.="Ќеправильный пароль!<br>";

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
function message($id)
{
	global $lang,$adm;

	$lng=$lang;
	if(!$lng) $lng="rus";

	$q=selectall("lk_messages where MessageID='$id'");

	if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=messages\">$q[$lng]</a>]";
	elseif($q[$lng]) return $q[$lng];
	else return $id;
}


function text($id)
{
	global $lang,$adm;

 	$q=selectall("lk_texts where TextID='$id'");
	 if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=messages\">$q[$lang]</a>]";
	elseif($q[$lang]) return $q[$lang];
	else return $id;
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


//выбор строки из базы-------------------------------------
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


  if($r[Name]&&$r[TeamID]!=5&&$r[TeamID]!=7) return "$r[Number] "."<a href=\"players.php?id=$id&act=info\" class=black>".$r[Name]."</a>";
  elseif($r[Name]) return $r[Name];
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

require($engine_path."cls/common/cls_xml.php");
require($engine_path."cls/images/cls_image.php");
require($engine_path."cls/common/cls_db_dinamo.php");
require($engine_path."cls/common/cls_root_dinamo.php");
require($engine_path."cls/common/cls_menu.php");
require($engine_path."cls/common/cls_form_dinamo.php");



$site="dinamo/";
if(!$lang) $lang="rus";


$dbname="nekki_dinamo";
mysql_select_db("nekki_dinamo");

?>