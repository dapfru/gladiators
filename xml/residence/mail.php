<?

require('../../config.php');

require($engine_path."cls/auth/session.php");

$type="residence/mail";
if(!$act&&!$id) $act="inbox";
if($id&&$act!="remove") $act="respond";

if(checkpriv('control/support','')) $_GET['support']=1;
else $_GET['support']=0;



if($act=="inbox"&&!$ok) unset($form_ok);

if($id) 
{
	mysql_query("update ut_messages set Status=1 where Status=0 and MessageID='$id' and UserID2='$auth->user'");
}


if(!$act)  $act="select";


require($site_path."up.php");

$inbox=select("select count(*) from ut_messages where UserID2=$auth->user and Status<2 and Support<>1");

$unread=select("select count(*) from ut_messages where UserID2=$auth->user and Status=0  and Support<>1");

$sent=select("select count(*) from ut_messages where UserID1=$auth->user and Status=2 and Support<2");



$str=$inbox[0];
if($unread>0) $str="<b>$unread[0]</b>/".$str;

$menu[0]="<a href=\"$PHP_SELF?act=inbox\">".message(167).": "."##<font class=blue>$str</a>";
$menu[1]="<a href=\"$PHP_SELF?act=sent\">".message(168).": ##<font class=blue>$sent[0]</a>";
$menu[2]="<a href=\"$PHP_SELF?act=write\">".message(169)." </a>";
$menu[3]="<a href=\"$PHP_SELF?act=support\">".message(170)." </a>";

require($site_path."left.php");





if($id)
{
	$f=new cls_form($type,"message");
	$f->Draw();
	print "<br>";

}


if($user&&!$id&&$user!=$auth->user)
{
	$q=select("select Login from ut_users where UserID='$user'");
	$r[Login]=$q[0];
}


unset($r[Body]);
if($r[Subject]&&!strstr($r[Subject],"Re:")) $r[Subject]="Re:$r[Subject]";

if($type&&$act!="delete"&&$r[UserID1]!=$auth->user) $form->Draw();



if($id)
{


function rec($id)
{
	global $_GET,$type,$_POST;

	$q=select("select AnswerID from ut_messages where MessageID='$id'");
	$row=runsql("select * from ut_messages where  MessageID='$q[0]'");
	if(mysql_num_rows($row))
	{

		while($r1=mysql_fetch_array($row))
		{
			print "<img src=/images/hr.gif height=10px width=473px style=\"margin-top:5px;margin-bottom:5px\">";

			$_GET['id']=$r1[MessageID];

			$f=new cls_form($type,"message");
			$f->Draw();
		}

		rec($q[0]);
	}

}

rec($id);

}



function printmenu($r)
{
	global $site_url;

	$r[Url]=set_params($r[Url]);

	if(!strstr($r[Url],"http://")) $r[Url]="$site_url".$r[Url];

	if($r[Target]) $r[Target]=" target=\"_$r[Target]\"";
	else unset($target);

	return $r;

}



require($site_path."bottom.php");
?>