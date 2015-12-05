<?
include("../config.php");
require("up.php");

if($type=="engine/menu"&&(!$act||$act=="select"))
	{

		print "<table border=0 width=100% id='table0' cellspacing=0 cellpadding=0>";

		$start=0;

		print "<tr><td valign=middle><img src=\"/images/engine/home.gif\" align=absmiddle width=15 height=18 > ".sysmessage(19)."</td></tr>";

		if(!menurec(0,0,'','')) print "<tr><td colspan=10><img src=\"/images/engine/line3.gif\" width=20 height=20 align=absmiddle> <img src=\"/images/engine/new.gif\" border=0 align=absmiddle> <a href=\"$PHP_SELF?act=insert&type=engine/menu&Parent=0&Rang=1\">Добавить</a></td></tr> ";

		print "</table>";

	}
	elseif($type=="engine/tags"&&(!$act||$act=="select"))
	{

		print "<table border=0 width=100% id='table0' cellspacing=0 cellpadding=0>";

		$start=0;

		print "<tr><td valign=middle><img src=\"/images/engine/tree.gif\" align=absmiddle  > ".sysmessage(23)."</td></tr>";

		tagrec(0,0,'','');

		print "</table>";

	}
	else if($type) $form->Draw();


//$form->width="100%";
//if($act!="delete") $form->Draw();


require('bottom.php');
?>