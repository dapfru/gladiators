<?
require('../../../config.php');

require($engine_path."cls/auth/session.php");

$type="premium/rangs";


require($site_path."admin/up.php");

require($site_path."left.php");

if($form->checkPermission(''))
{


if($step)
{

$ar=explode("\n",$vipstr);
foreach($ar as $a)
{

 $b=explode("\t",$a);
 if($b[1]) {

 $q=select("select UserID from ut_teams where ShortName='$b[1]'");
 $user=$q[0];

 $q=select("select TypeID from vp_rang_types where Level='$b[2]'");
 $type=$q[0];


 runsql("delete from vp_rangs where UserID ='$user'");

 $t=explode(".",$b[4]);
 $t1=mktime(18,0,0,$t[1],$t[0],$t[2]);
 $t2=$t1+3600*24*$b[3]*31;

 if($t2>mktime()) mysql_query("update ut_users set Rang='$b[2]' where UserID='$user'");

 mysql_query("insert into vp_rangs(UserID,TypeID,Start,End,Term) values ('$user','$type','$t1','$t2','$b[3]')");

 print "$b[1] - ".date("d.m.Y H:i",$t1)."- ".date("d.m.Y H:i",$t2)."<br>";
 }
}

}


?>
<table border=0 cellspacing=0 cellpadding=4>
<form name="register" method="post" action="<?="$PHP_SELF?step=1"?>">
<input type="hidden" name="step" value="1">
<?
print "<tr bgcolor=$bgcol><td><textarea name=\"vipstr\" wrap cols=30 rows=3 class=border maxlength=1000></textarea></td></tr>";
?>
<tr><td><input type="submit" value="Загрузить" class=button></td></tr>
</form>
</table>
</div>
<?

}

require($site_path."bottom.php");
?>
