<?
require('../../config.php');


require($engine_path."cls/auth/session_lite.php");

$type="main/rules";

require($site_path."up.php");

unset($menu);
$i=0;

if(!$id&&!$auth->user) $id=3;
elseif(!$id&&$auth->user) $id=1;

$res=runsql("select TypeID,Name_$lang as Name from ut_rules_types order by Rang");
while($r=mysql_fetch_array($res))
{
	if($id==$r[0])  $menu[$i]="<u>$r[1]</u>";
	else $menu[$i]="<a href=\"$PHP_SELF?id=$r[0]\">$r[1]</a>";

	$i++;
}




require($site_path."left.php");

?>
<style>
.rules {font-size:13px;}
.rules p {font-size:13px;}
.rules a {font-size:13px;}
</style>
<div class=rules>
<?
$n=0;


$res=runsql("select Name_$lang as Name, Rule_$lang as Rule from ut_rules where TypeID='$id' order by Rang");
if(mysql_num_rows($res)>1)	
{
print "<div class=blue><b>".upstr('Содержание')."</b></div><br>";

while($r=mysql_fetch_array($res))
{
	$n++;
	print "<a href=\"#$n\"><b>$n. ".upstr($r[Name])."</b></a>";

}

print "<br>";



}
$n=0;


$res=runsql("select Name_$lang as Name, Rule_$lang as Rule from ut_rules where TypeID='$id' order by Rang");
if(mysql_num_rows($res)==0) print icon('error',"Раздел ещё не заполнен");
while($r=mysql_fetch_array($res))
{


	if($n>0) print "<p><a name=\"$n\"></a><font size=4>$n. ".upstr($r[Name])."</font></p>";
	else print "<p><font size=4>".upstr($r[Name])."</font></p>";
	$n++;

	if(substr(settags($r[Rule]),0,2)!="<p") print "<p>";

	print "<div  style=\"text-align:justify;margin-right:6px\" >".settags(set_params($r[Rule]))."</div><br>";
	//print settags(set_params($r[Rule]))."<br>";
}

?>
</div>
<?
require($site_path."bottom.php");
?>
