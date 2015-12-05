<?
require('../../config.php');
require($engine_path."cls/auth/session_lite.php");


function repairHash($array)
{
  foreach ($array as $k => $v)
{

    $result[$k]=$v;
}
  return $result;    
}


$fname=gampath($id)."/".$id.".gam";


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
?>
<html>
<head>
<title><?="$rst1[Login] vs $rst2[Login]"?></title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<link href="<?=$site_url?>css.css" rel="stylesheet" type="text/css"/>
<center>

  <table width=85% height=100% bgcolor=515E64 align="center" valign="top" border=0
 cellpadding=0 cellspacing=0>
  <!--verhnii>

  <!--sredni>
  <tr>

<td width=8px background="chain.gif" valign=top><img src=chain.gif width=4px height=6px></td>

<td width=100% style='padding:12' valign=top>
	<center>


<?
	require("online_core.php");
?>

       </td>
<td width=8px background="chain.gif" valign=top><img src=chain.gif width=4px height=6px></td>
</tr>
  <!--nizhnij>

  </table>

</body>
</html>