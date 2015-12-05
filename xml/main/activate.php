<?
require('../../config.php');

$form_width=170;

require($engine_path."cls/auth/session_lite.php");


$form_title=message(44);

$rg=selectall("rg_activation where UserID='$user' and Code='$code'");

$cur=2;

$menus=array(message(40),message(41),message(42),message(43));

$i=0;

foreach($menus as $m)
{
	$i++;

	if($i==$cur) $class="current";
	else $class="blue";

	$menu[$i-1]="<font class='$class'>$i. $m</font>";
}



if(!$act) $act="insert";

require($site_path."up.php");

require($site_path."left.php");


if(!$rg[0]) 
{
	print icon('error',message(45));
}
else 
{
	mysql_query("update ut_users set Active='1' where UserID='$user'");
	print icon('ok',message(46));
}

require($site_path."bottom.php");
?>
