<?
require('../../config.php');

require($engine_path."cls/auth/session_lite.php");

if($act=="leave") unset($act);

$form_width=170;

$form_title=message(44);


function upfirst($name,$delimeter,$flag)
{
 if(strstr($name,$delimeter))
 {
	$nameArr = split( $delimeter, trim( $name ) ); 
	foreach( $nameArr as $namePart ) { 
	if (!$flag) $namePart = downstr( trim($namePart) ); 
	$finName .= upstr( substr( $namePart, 0, 1 ) ) . substr( $namePart, 1, strlen( $namePart ) - 1 ) . $delimeter; 
 } 
 $name = substr( $finName, 0,  strlen( $finName ) - 1); 


 }

	return $name;
}



if(!$act) $act="insert";

$type="main/register";

if($step)
{
	$_POST['pwd']=md5($_POST['Password'].$secpass);

	$_POST['RealCode']=substr(md5($_POST['SecretCode']."hgfjdj"),0,6);

$_POST['FirstName']=upfirst($_POST['FirstName'],"-",0);
$_POST['LastName']=upfirst($_POST['LastName'],"-",0);
$_POST['City']=upfirst($_POST['City']," ",0);
$_POST['City']=upfirst($_POST['City'],"-",1);


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

if((!$step&&!$form_ok)||$er)
{

print "* ".stripslashes(message(31))."<img src=\"/images/hr.gif\" height=10 width=473><br><br>";

if($type&&$act!="delete") $form->Draw();
//print icon('green','Регистрация временно закрыта');

}






require($site_path."bottom.php");
?>
