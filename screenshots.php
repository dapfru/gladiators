<?
require('config.php');
require($engine_path."cls/auth/session_lite.php");

$form_title=message(35);

require("up.php");



$first_page=1;
$type="main/screenshots";

require("left.php");
?>
		<table width="500" border="0" cellspacing="8" cellpadding="0" style="margin: 0px 0px 0px 10px;">
<?
$i=0;
srand();
$res=runsql("select ScreenshotID,Name_$lang as Name from ut_screenshots order by ScreenshotID asc");
while($r=mysql_fetch_array($res))
{
?>
                            <td width="33%" align="center" valign="top">

	<?
		print "<a href=\"screen.php?record=14&amp;id=$r[0]\" >";
		print "<img src=\"/images/ut_screenshots/small/$r[0].jpg\" border=0 ";
		if($r[Name]) print " alt=\"$r[Name]\" title=\"$r[Name]\"";
		print "> \n";
	?>
	</a></td>
<?

 $i++;
 if($i%3==0) print "<tr>";
}
print "</table>";


require("bottom.php")
?>
