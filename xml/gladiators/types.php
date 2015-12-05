<?
require('../../config.php');
//$form_width=170;
require($engine_path."cls/auth/session.php");


$leftcontent="<img src=\"/images/ut_gladiator_types/image/$id.jpg\" width=\"195\">";

require($site_path."up.php");

require($site_path."left.php");



$r=select("select *,Name_$lang as Name,Description_$lang as Description,Headline_$lang as Headline from ut_gladiator_types where TypeID='$id'");

	print"<br><h3>".$r[Name].":<br></h3><br>";
	if($r[Headline]) print settags($r[Headline]);
	if($r[Description]) print"<br><br>".settags($r[Description]);

$res=runsql("select TypeID,Name_$lang Name from ut_gladiator_types  order by Coefficient");
print "<h3>Типы гладиаторов</h3>";

while($r=mysql_fetch_array($res))
{
	print "<img src=\"/images/types/$r[0].gif\"> <a href=\"types.php?id=$r[0]\">$r[1]</a><br><img src=\"/images/hr2.gif\" height=10px><br>";
}



require($site_path."bottom.php");
?>