<?
require('config.php');
require($engine_path."cls/auth/session_lite.php");

$form_title=message(35);

require("up.php");



$page="first";

require("left.php");
?>
<img src="<?=$site_url?>images/ut_screenshots/screenshotfile/<?=$id?>.jpg" border=0>
<?

$q1=select("select ScreenshotID from ut_screenshots where ScreenshotID>'$id' order by ScreenshotID asc limit 0,1");
$q2=select("select ScreenshotID from ut_screenshots where ScreenshotID<'$id' order by ScreenshotID desc limit 0,1");

print "<br><br><table border=0 cellspacing=0 cellpadding=0 width=100%><td><div style=margin-left:";

if($q2[0]) print "168";
else print "247";

print "px>";

if($q2[0]) print "<a href=screen.php?id=$q2[0]>« предыдущий</a>";
print " <img src=\"/images/marker3.gif\" width=11 height=11 border=0> ";
if($q1[0]) print "<a href=screen.php?id=$q1[0]>следующий »</a>";

print "</td><td><div align=right> <a href=screenshots.php>вернуться к списку</a> <img src=\"/images/marker3.gif\" width=11 height=11 border=0></td></table>";

require("bottom.php")
?>
