<?
require('../../config.php');
$form_width=170;
require($engine_path."cls/auth/session.php");
$type="residence/profile";

$act="distribution";

$rst=$auth->rst;

unset($r);


$r[Points]=$rst['Points'];
$r[c1]=$rst['Charisma'];
$r[c2]=$rst['Command'];
$r[c3]=$rst['Commerce'];
$r[m1]=$rst['Management'];


function update_chars($v1,$v2,$v3,$v4)
{
	global $rst,$auth;

	$rst[Charisma]+=$v1;
	$rst[Command]+=$v2;
	$rst[Management]+=$v3;
	$rst[Commerce]+=$v4;
	$rst[Points]-=($v1+$v2+$v3+$v4);

	if($rst[Points]>=0&&($v5==$c||!$c)) write_rst($auth->user,$rst);
}


require($site_path."up.php");
require($site_path."left.php");

$form->Draw();

require($site_path."bottom.php");

?>