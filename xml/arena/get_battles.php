<?
//header ("Cache-Control: no-cache"); 
//header ("Last-Modified: ".gmdate("L, d M Y H:i:s")." GMT"); 
header("Content-type: text/html;charset=windows-1251");


if(!$show) 
{

require('../../config.php');



if($_GET[typeid]==1) $act1="battles";
elseif($_GET[typeid]==2) $act1="duels";
elseif($_GET[typeid]==3) $act1="series";
elseif($_GET[typeid]==4) $act1="survival";


require_once $engine_path."xml/arena/load/jshttp.class.php";
$JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");

require($engine_path."cls/auth/session.php");

$result['answer'] = "";
//header("Content-type: text/html;charset=windows-1251");
$type="arena/arena";


$myrecord=select("select f.*,u.Login from ft_agreements f left outer join ut_users u on u.UserID=f.UserID2 where f.UserID1='$auth->user'");
$hisrecord=select("select * from ft_agreements where UserID2='$auth->user'");

}


if($myrecord[Approved]==1)
{
	if(mktime()<60*$myrecord[Timeout]+$myrecord[Date]) $result["redirect"] = "/builder/?id=$myrecord[RecordID]"; //header("Location:/builder/?id=$myrecord[RecordID]");
	else unset($myrecord);

}
elseif($hisrecord[Approved]==1)
{

	if(mktime()<60*$hisrecord[Timeout]+$hisrecord[Date]) $result["redirect"] = "/builder/?id=$hisrecord[RecordID]"; //header("Location:/builder/?id=$hisrecord[RecordID]");
	else unset($hisrecord);
}




if($myrecord[UserID2])
{
	if(!$myrecord[Approved]) print icon('green',"Вас вызвал <a href=\"/xml/gladiators/?user=$myrecord[UserID2]\" target=_blank>$myrecord[Login]</a>. [<a href=arena.php?approve=1>Подтвердить</a>] [<a href=arena.php?cancel=1&typeid=$typeid>Отказаться</a>]")."<br>";
}
elseif($hisrecord[UserID2])
{
	if(!$hisrecord[Approved]) print icon('green','Ожидание подтверждения от соперника. [<a href=arena.php?cancel=1&typeid='.$typeid.'>Отменить</a>]')."<br>";
}




if($act!="battles") $form=new cls_form($type,"battles");
if($form->numrows) print "<font size=4pt>Ищут соперника</font><br><br>";
$form->draw();
$_RESULT = $result;
?>