<?
require('config.php');
require($engine_path."cls/auth/session_lite.php");

$form_title="Демонстрация";

$first_page=1;
require("up.php");

require("left.php");
?>
<center>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="500" height="313" id="gladiators_34" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="demo.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#666666" /><embed src="demo.swf" quality="high" bgcolor="#666666" width="500" height="313" name="demo" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

<?

print "<br><br>".icon('green','В демонстрации показан пример 2d-боя один на один. В скором времени будут показаны также примеры массовых боев. Для просмотра требуется Macromedia Flash.');


require("bottom.php")
?>
