<?
require('config.php');

//require($engine_path."cls/auth/session.php");


$q=select("select avg(DATE_FORMAT(DATE_SUB(FROM_DAYS(TO_DAYS(NOW()) -
TO_DAYS(BirthDate)), INTERVAL 1 MONTH ), '%y')) Age
 from ut_users
where BirthDate <> '0000-00-00'");
print "Средний возраст: ".$q[0]."<br>";



$q=select("select count(*) from ut_users");
print "Число игроков: ".$q[0]."<br>";



print "<h2>Регистрации</h2>";

$d=date("d",mktime());
$m=date("m",mktime());

$prev=mktime();

//$prev=mktime(0,0,0,$m,$d,date("Y",mktime()));

//print date("d.m.Y H:i",1143101959);

for($i=$d;$i>$d-6;$i--)
{
if($d==0) {$d=31;$m--;}

$day=mktime(0,0,0,$m,$i,date("Y",mktime()));
print date("d.m.Y",$day)."<br>";


$r=select("select count(*) from ut_users where Date<$prev and Date>=$day");


$r3=select("select avg(Year(BirthDate)) from ut_users u where Year(BirthDate)>1940 and Year(BirthDate)<1997 and u.Date<$prev and u.Date>$day");
print "Зарегистрировались: <b>$r[0]</b> (средний возраст <b>".round(date("Y",mktime())-$r3[0])."</b>)<br>";


print "В процентах: ".round(100*$r1[0]/$r[0],0)."%<br><br>";

$prev=$day;

}




exit;


$type="office/organizer";
$act="panel";

require($site_path."up.php");

$form_title="Дерево сайта";

function printmenu($r)
{
	$r[Url]=set_params($r[Url]);

	if(!strstr($r[Url],"http://")) $r[Url]="$site_url".$r[Url];

	if($r[Target]) $r[Target]=" target=\"_$r[Target]\"";
	else unset($target);

	return $r;

}

require($site_path."left.php");


function drawpanel($id,$blocks)
{
global $auth,$lang;

print "<center><table border=0 cellspacing=0 cellpadding=5><td valign=top width=160px>";





$res=runsql("select m1.*,m1.Name_$lang as name,count(m2.MenuID) as cnt from en_menu m1

left outer join en_menu m2 on m2.Parent=m1.MenuID
where m1.Parent='$id'
group by m1.MenuID
 order by Rang");

$num=0;

while($r=mysql_fetch_array($res))
{

if($r[cnt]>0)
{
	if($num>0&&$num%$blocks==0&&$num<$blocks*3) print "</td><td valign=top width=160px>";
	$num++;

	print "<table border=0 width=100% cellspacing=1 cellpadding=3 bgcolor=d3d3d3 ><td class=header>";
	$r=printmenu($r);
	print "<center><b>$r[name]</b></a></center>";

	print "</td></table>";

	$res1=runsql("select m1.*,m1.Name_$lang as name,count(m2.MenuID) as cnt from en_menu m1

left outer join en_menu m2 on m2.Parent=m1.MenuID
where m1.Parent='$r[MenuID]'
group by m1.MenuID
 order by Rang");

	while($r1=mysql_fetch_array($res1))
	{

		print "<table border=0 width=100% cellspacing=1 cellpadding=3  bgcolor=d3d3d3 ><td bgcolor=FFFAE4>";

		$r1=printmenu($r1);
		if(!$r1[cnt]) print "» <a href=\"$r1[Url]\" $r1[Target]>$r1[name]</a><br>";
		else print "» $r1[name]<br>";

			$res2=runsql("select *,Name_$lang as name from en_menu where Name_$lang<>'$r1[Name]' and Parent='$r1[MenuID]' order by Rang");

			while($r2=mysql_fetch_array($res2))
			{

				$r2=printmenu($r2);
				print "&nbsp;&nbsp; -  <a href=\"$r2[Url]\" $r2[Target]>$r2[name]</a><br>";
			}
		print "</td></table>";
	}


	print "<br>";
}

}	

print "</table>";

}



drawpanel(2,2);
drawpanel(49,3);


require($site_path."bottom.php");

$db->close();
?>