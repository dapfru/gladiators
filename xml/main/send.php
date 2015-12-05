<?
require('../../config.php');

$form_width=170;

require($engine_path."cls/auth/session_lite.php");

$type="main/register";
$act="sendagain";
if($id) $step=1;

if($step)
{

	$_POST['RealCode']=substr(md5($_POST['SecretCode']."hgfjdj"),0,6);
}

require($site_path."up.php");
$cur=1;
if(($form_ok||$step)&&!$er) $cur=2;

$i=0;
$menus=array(message(40),message(41),message(42),message(43));

foreach($menus as $m)
{
	$i++;

	if($i==$cur) $class="current";
	else $class="blue";

	$menu[$i-1]="<font class='$class'>$i. $m</font>";
}

require($site_path."left.php");
$form->Draw();

require($site_path."bottom.php");
?>
