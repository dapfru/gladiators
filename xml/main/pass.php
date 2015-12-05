<?
require('../../config.php');

require($engine_path."cls/auth/session_lite.php");


$form_width=170;


if($act!="pass2") $act="pass";




$type="main/register";

if($step)
{

	$_POST['pwd']=md5($_POST['Password'].$secpass);
	$_POST['RealCode']=substr(md5($_POST['SecretCode']."hgfjdj"),0,6);

}

require($site_path."up.php");



$cur=3;

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


if($code) {


$rg=selectall("rg_pass where UserID='$user' and Code='$code'");

if(!$rg[0]) 
{
	print icon('error',message(202))."<br>";
}
else 
{
	print icon('help',message(203))."<br>";
		$act="pass2";
}

$form=new cls_form($type,$act);

}

if(!$form_ok) $form->Draw();



require($site_path."bottom.php");
?>
