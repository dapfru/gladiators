<?
require('../../../config.php');
require($engine_path."cls/auth/session_lite.php");

?>
<html>
<head></head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<link href="<?=$site_url?>css.css" rel="stylesheet" type="text/css"/>
<center>

  <table width=85% height=100% bgcolor=515E64 align="center" valign="top" border=0
 cellpadding=0 cellspacing=0>
  <!--verhnii>

  <!--sredni>
  <tr>

<td width=8px background="chain.gif" valign=top><img src=chain.gif width=4px height=6px></td>

<td width=100% style='padding:12'>
	<center>
<?

$res=runsql("select Name_$lang as Name, Rule_$lang as Rule from ut_rules where TypeID='4' order by Rang");

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

       </td>
<td width=8px background="chain.gif" valign=top><img src=chain.gif width=4px height=6px></td>
</tr>
  <!--nizhnij>

  </table>

</body>
</html>