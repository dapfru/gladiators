<?
require('../../config.php');

require($engine_path."cls/auth/session.php");

$type="misc/guilds";

/*
Посчитать число пользователей в гильдиях

update gd_guilds g, (select GuildID,count(GuildID) Num from ut_users  where GuildStatusID=1 group by GuildID) u
set g.NumMembers=u.Num
where g.GuildID=u.GuildID
*/


//unset($act);
if(!$act) $act="select";

require($site_path."up.php");

require($site_path."left.php");

if($form_ok&&$act=="insert") {$form=new cls_form($type,"select");$act="select";}

if(!$id)
{


//print icon('green','Начинается предварительный прием заявок на регистрацию гильдий. У гильдии должен быть свой сайт, устав, логотип. Администрация имеет право отказать в регистрации гильдии без объяснения причин.')."<br>";

print "<center>";

//$f=new cls_form($type,"select");
$form->draw();

print "</center><br>";


if($act=="select")
{

$q=select("select * from gd_guilds where UserID='$auth->user'");

if($q[StatusID]==0&&$q[GuildID]) print "<center><b>Заявка на регистрацию гильдии рассматривается</b></center>";
elseif($q[StatusID]>0) print "<center><b>Вы являетесь владельцем гильдии <a href=/guilds/$q[ShortName]>$q[Name]</a><br><a href=/guild/>[перейти в администрирование]</a></b></center>";
else print "<center><b><a href=$PHP_SELF?act=insert>Зарегистрировать гильдию</a></b></center>";

}

}
else
{

	if(!is_numeric($id)) $q=select("select * from gd_guilds where ShortName='$id'");
	else $q=select("select * from gd_guilds where GuildID='$id'");

	$guild=$q[GuildID];
	$_GET['guild']=$guild;

	print "<center><font size=+1><img src=/images/gd_guilds/small/$q[GuildID].jpg> $q[Name]</center></font><br>";
	print "Дата регистрации: ".date("d.m.Y",$q[Date])."<br>";

	$q1=select("select Login from ut_users where UserID='$q[UserID]'");

	if($q[UserID]!=$q[FounderID]) 	$q1=select("select Login from ut_users where UserID='$q[FounderID]'");
	else $q2[Login]=$q1[Login];

	print "Владелец: <a href=/users/$q[UserID]>".$q1[Login]."</a><br>";
	print "Основатель: <a href=/users/$q[FounderID]>".$q2[Login]."</a><br>";
	print "Адрес сайта: <a href=$q[Url] target=_blank>$q[Url]</a><br>";

	$gd=select("select GuildID,GuildStatusID from ut_users where UserID='$auth->user'");

	if($gd[GuildID]==$guild&&$gd[GuildStatusID]==1) print "<a href=$PHP_SELF?id=$guild&act=leave&step=1 onclick=\"return confirm('Вы действительно хотите отказаться от членства в гильдии?')\">Покинуть гильдию</a><br>";
	elseif($gd[GuildID]==$guild) print "<i>Заявка на вступление в гильдию рассматривается</i><br>";
	elseif((!$gd[GuildID]||!$gd[GuildStatusID])&&$q[Newbies]==0) print "<b>Прием членов в данную гильдию закрыт</b>";
	elseif(!$gd[GuildID]||!$gd[GuildStatusID]) print "<a href=$PHP_SELF?id=$guild&act=join&step=1><b>Вступить в гильдию</b></a><br>";	

	if($q[Description]) print "<br><i>$q[Description]</i><br>";

	print "<br>";

	$f=new cls_form($type,"members");
	$f->draw();

	print "</center><div align=right><a href=$PHP_SELF>вернуться к списку</a> <img src=\"/images/marker3.gif\" width=11 height=11 border=0></center><br>";
}


require($site_path."bottom.php");
?>