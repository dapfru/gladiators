<?
require('../../config.php');

require($engine_path."cls/auth/session_lite.php");

$hide_menu=1;

$fname=gampath($id)."/".$id.".gam";

function repairHash($array)
{
  foreach ($array as $k => $v)
{

    $result[$k]=$v;
}
  return $result;    
}




require($site_path."up.php");

$hide_finances=1;


if($id&&file_exists($fname))
{

$file=fopen($fname,"r");
$str=fread($file,filesize($fname));
$ar=explode("RST",$str);

$game=unserialize(substr($ar[0],39,strlen($ar[0])-4-39));

$ar2=explode("ORD",$ar[1]);
$rst1=unserialize(substr($ar2[0],36));
$ord1=unserialize(substr($ar2[1],36));

$ar2=explode("ORD",$ar[2]);
$rst2=unserialize(substr($ar2[0],36));
$ord2=unserialize(substr($ar2[1],36));


$rst1[Gladiators]=repairHash($rst1[Gladiators]);
$rst2[Gladiators]=repairHash($rst2[Gladiators]);


$file=fopen(gampath($id)."/$id.rep","r");

$str=fread($file,filesize(gampath($id)."/$id.rep"));



$ar=unserialize($str);

}


require($site_path."left.php");

	require("online_core.php");


require($site_path."bottom.php");
?>