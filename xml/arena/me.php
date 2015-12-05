<?
require('../../config.php');

require($engine_path."cls/auth/session.php");

$type="arena/arena";


if(!$_GET[typeid]&&$id&&$form_ok) $_GET[typeid]=$id;
if(!$_GET[typeid]) $_GET[typeid]=1;


if($_GET[typeid]==1) $act1="battles";
elseif($_GET[typeid]==2) $act1="duels";
elseif($_GET[typeid]==3) $act1="series";
elseif($_GET[typeid]==4) $act1="survival";

$typeid=$_GET[typeid];

if(!$act) $act=$act1;

$type_level="arena/$act1";



if($step)
{
	$skl=0;
	$cnt=0;
	$extra=0;

	$glad=get_gladiators($auth->user);

	$max=0;
	$min=1000;
	foreach($glad as $k=>$v)
	{
		if(!$v[Injury]) 
		{
			if($cnt<7) $skl+=$v[Level];
			if($v[Level]>$max) $max=$v[Level];
			if($v[Level]<$min) $min=$v[Level];
			$cnt++;
		}
	}


	if(!$cnt) $er= 'У Вас нет здоровых гладиаторов';
	elseif($_GET[LimitSkl]&&$min>$_GET[LimitSkl]) $er= "У Вас нет здорового гладиаторов уровнем не выше $_GET[LimitSkl]";
	elseif($act=="seriesapp"&&$cnt<$_GET[LimitGlad]) $er= 'У Вас недостаточно здоровых гладиаторов';

}


if($cancel)
{
	$q=select("select RecordID,Approved from ft_agreements where (UserID2='$auth->user' or UserID1='$auth->user') and StatusID=0");
	if(!$q[Approved]) runsql("update ft_agreements set UserID2=null where (UserID2='$auth->user' or UserID1='$auth->user') and StatusID=0");
}

if($approve)
{
	runsql("update ft_agreements set Approved=1,Date=unix_timestamp(),StatusID=2 where UserID1='$auth->user' and UserID2>0 and StatusID=0 and Approved=0");	
	$q=select("select RecordID from ft_agreements where UserID1='$auth->user' and UserID2>0 and StatusID=2 and Approved=1");
	header("Location:/builder/?id=$q[0]");
}



require($site_path."up.php");

require($site_path."left.php");



if($act=="fullhistory")
{
	//$history=new cls_form($type,"history");
	
	$form->draw();
}
else
{

print icon("green","В настоящее время бои находятся в разработке. В ближайшее время будет продолжаться усовершенствование процесса генерации и введение 2d показа.");

?>
<script>

document.write("<scr"+"ipt lang"+"uage=\"Java"+"Script\" src=\"load/jshttp.js\"></scr"+"ipt>");
function refresh()
{
	if (timer>=0) clearTimeout(timer);
	timer=setTimeout('refresh()',15000);
	GetBattles();
}

function GetBattles(type) {
	if(type) document.getElementById('battles').innerHTML = "Обновление списка...";
	var req = new Subsys_JsHttpRequest_Js();
	req.onreadystatechange = function() {
		
		if (req.readyState == 4) {
			if (req.responseJS) {
				if(req.responseJS.redirect) document.location.href=req.responseJS.redirect;
				if(req.responseText||type) document.getElementById('battles').innerHTML = req.responseText;
			}
		}
	}
	req.open('POST', 'get_battles.php?do=<?=$do?>&typeid=<?=$typeid?>&rand='+Math.floor(Math.random() * 1000000), true);
	req.send(null);
}

<?
if(!$do)
{
?>timer=setTimeout('refresh()',15000);<?
}
?>
</script>

<?

if($step&&($act=="battles"||$act=="duels"||$act=="series"&&$act=="survival")&&$id)
{

	$q=select("select RecordID,UserID2,LimitGlad,LimitSkl from ft_agreements where RecordID='$id' and StatusID=0");


	$skl=0;
	$cnt=0;
	$extra=0;

	$glad=get_gladiators($auth->user);

	$max=0;
	$min=1000;
	foreach($glad as $k=>$v)
	{
		if(!$v[Injury]) 
		{
			if($cnt<7) $skl+=$v[Level];
			if($v[Level]>$max) $max=$v[Level];
			if($v[Level]<$min) $min=$v[Level];
			$cnt++;
		}
	}

	//if($typeid!=2) $_GET[GladSkl]=round($skl);
	//else $_GET[GladSkl]=round($max);

	if(!$cnt) print icon('error','У Вас нет здоровых гладиаторов');
	elseif($q[LimitSkl]&&$min>$q[LimitSkl]) print icon('error',"У Вас нет здорового гладиаторов уровнем не выше $q[LimitSkl]");
	elseif($act=="series"&&$cnt<$q[LimitGlad]) print icon('error','У Вас недостаточно здоровых гладиаторов');
	elseif(!$q[0]) print icon('error','Заявка не найдена');
	elseif($q[UserID2]!=$auth->user&&$q[UserID2]) print icon('error','Игрок уже вызван');
	else
	{
		mysql_query("update ft_agreements set UserID2='$auth->user' where RecordID=$id");
		mysql_query("update ft_agreements set StatusID=1 where UserID1='$auth->user' and StatusID=0");

		$myrecord=select("select f.*,u.Login from ft_agreements f left outer join ut_users u on u.UserID=f.UserID2 where f.UserID1='$auth->user' and f.StatusID=0");
		$hisrecord=select("select * from ft_agreements where UserID2='$auth->user' and StatusID=0");

	}

	$form=new cls_form($type,$act);

}

print "<br><font size=4pt>";

$f_type[1]= "Сражения";
$f_type[2]= "Поединки";
$f_type[3]= "Серии поединков";
$f_type[4]= "Бои на выживание";

print $f_type[$_GET[typeid]];

print "</font><br><br>";

if(!$typeid) $typeid=$_GET[typeid];

$myrecord=select("select f.*,u.Login from ft_agreements f left outer join ut_users u on u.UserID=f.UserID2 where f.UserID1='$auth->user' and (StatusID=0 or StatusID=2)");
$hisrecord=select("select * from ft_agreements where UserID2='$auth->user' and (StatusID=0 or StatusID=2)");

	print "[<a href=\"javascript:GetBattles(1)\">Обновить список</a>] ";


if(!$myrecord[UserID2]&&!$hisrecord[UserID2])
{

if(!$myrecord[0]&&$do)
{

	//print "<br><br>";

	$skl=0;
	$cnt=0;
	$extra=0;

	$glad=get_gladiators($auth->user);

	foreach($glad as $k=>$v)
	{
		if(!$v[Injury]) 
		{
			$skl+=$v[Level];
			if($v[Level]>$max) $max=$v[Level];
			$cnt++;
			if($v[TypeID]>8) $extra=1;
		}

	}

	if($typeid!=2) $_GET[LimitSkl]=round($skl);
	else $_GET[LimitSkl]=round($max);


	$_GET[LimitGlad]=$cnt;

	if($_GET[typeid]>2&&$_GET[LimitGlad]>5) $_GET[LimitGlad]=5;
	if($_GET[typeid]==3&&$_GET[LimitGlad]%2==0&&$_GET[LimitGlad]) $_GET[LimitGlad]--;

	$_GET[ExtraGlad]=$extra;
	if($_GET[LimitGlad]>7) $_GET[LimitGlad]=7;
 
	$app=new cls_form($type,"$act1"."app");


	$app->draw();
}
elseif($myrecord[0]&&($act!="my"||!$step)&&!$myrecord[UserID2])
{

	print "<br><br>";

	$app=new cls_form($type,"my");
	$app->draw();
	
}
elseif(!$myrecord[UserID2])
{
	print "[<a href=arena.php?typeid=$typeid&do=1>Подать заявку</a>] ";
}



}

print "<br><br>";


print "<div id=battles>";

if($act!="battles") $form=new cls_form($type,"battles");

$show=1;
require("get_battles.php");

print "</div>";


print "<br><font size=4pt>";

print "Предыдущие ".downstr($f_type[$_GET[typeid]]);

print "</font><br><br>";

unset($sort);
	
	$history=new cls_form($type,"history");
	$history->draw();

print "<div align=right><a href=$PHP_SELF?typeid=$typeid&act=fullhistory>Все ".downstr($f_type[$_GET[typeid]])." »</a></div>";

}

require($site_path."bottom.php");
?>