<?
require('../../config.php');
//$form_width=170;
require($engine_path."cls/auth/session.php");

$type="misc/holidays";
unset($act);

//$leftcontent="<img src=\"/images/ut_gladiator_types/image/$id.jpg\" width=\"195\">";

require($site_path."up.php");

require($site_path."left.php");

print "<table border=0 width=\"500\" bordercolor=78746C  cellpadding=2 cellspacing=1>";

$res=runsql("select *,Name_$lang as Name,Description_$lang as Description,Day1,Month1,Day2,Month2 from ut_holidays order by Month1,Day1");
$months=array("€нвар€","феврал€","марта","апрел€","ма€","июн€","июл€","августа","сент€бр€","окт€бр€","но€бр€","декабр€");
//print"--".mysql_num_rows($res); exit;
while($r=mysql_fetch_array($res))
{	
	if($r[Month1]==$r[Month2]&&$r[Day1]==$r[Day2]) $date=$r[Day1]." ".$months[$r[Month1]-1];
	elseif($r[Month1]==$r[Month2]) $date=$r[Day1]."-".$r[Day2]." ".$months[$r[Month1]-1];
	else $date=$r[Day1]." ".$months[$r[Month1]-1]." - ".$r[Day2]." ".$months[$r[Month2]-1];

	print"<tr><td align=\"left\"><a name=\"$r[HolidayID]\"><font size=\"4pt\">$r[Name]</font>";
	print"<br><b>".$date."</b>";
	print"<br>".settags($r[Description])."</td>";
	print"<tr height=10><td><img src=\"/images/hr.gif\" height=10px></td>";
}
print"</table>"; unset($date);


require($site_path."bottom.php");
?>