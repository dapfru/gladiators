<?
require('../../config.php');


require($engine_path."cls/auth/session.php");

$type="residence/buildings";

if($id&&!$act) $act="upgrade";

if(!$act) $act="list";

if($act=="list") unset($id);

require($site_path."up.php");


unset($menu);
$i=0;

$res=runsql("select BuildingID,Name_$lang as Name from fn_buildings_info where Type=0 group by BuildingID order by Name");
while($r=mysql_fetch_array($res))
{
	if($id==$r[0])  $menu[$i]="<a href=\"$PHP_SELF?id=$r[0]\"><font class='current'>$r[1]</font></a>";
	else $menu[$i]="<a href=\"$PHP_SELF?id=$r[0]\">$r[1]</a>";

	$i++;
}






require($site_path."left.php");

$Typ=0;

require("build.php");

if($act!="list") print "<br></center><div align=right><a href=$PHP_SELF?act=list>вернуться к списку</a> <img src=\"/images/marker3.gif\" width=11 height=11 border=0></center>";

require($site_path."bottom.php");
?>
