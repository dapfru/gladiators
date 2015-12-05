<?
require('../../config.php');
require($engine_path."cls/auth/session_lite.php");


if(is_numeric($id)&&$id)
{

$user=select("select g.UserID,u.Login from ut_gladiators g left outer join ut_users u using(UserID) 
where g.GladiatorID='$id'");


get_gladiators($user[0],1);


$r=$serialized[$id];
$r[Login]=$user[Login];

$r[Owner]="<a href=/users/".$user[UserID].">".$user[Login]."</a>";
//$leftcontent="<img src=\"/images/ut_gladiator_types/image/$r[TypeID].jpg\" width=\"195\">";

$tmpr=$r;
}

$type="gladiators/info";
if(!$act) $act="info";

$menu[0]="<a href='/xml/gladiators/'>Вернуться в отряд</a>";


if($r[StatusID]==1) $menu[1]="<a href='/xml/gladiators/info.php?id=$id&act=sell'>Продать гладиатора</a>";
elseif($r[StatusID]==2) $menu[1]="<a href='/xml/gladiators/info.php?id=$id&act=fire'>Уволить наемника</a>";

require($site_path."up.php");



require($site_path."left.php");



$r=$tmpr;

if($r[GladiatorID])
{


if($act=="info")
{

print "<table border=0 cellspacing=0 cellpadding=0 width=100%>";



print"<td valign=top width=100%>";




print "<table border=0 width=100% bgcolor=#78746C cellspacing=2 cellpadding=6><td bgcolor=\"#3B484C\">";

print"<a href=\"/xml/gladiators/types.php?id=$r[TypeID]\" title=\"$r[Type]\"><img src=\"/images/types/$r[TypeID].gif\" align=\"absmiddle\" border=\"0\"></a> $r[Gladiator]";

print"<tr><td bgcolor=\"#515E64\"><table cellspacing=2 cellpadding=0 border=0  width=100%>";

print"<tr><td valign=top>";


$form->Draw();


print"</td>";
print"</table>";


print "</td></tr>";

print"</table></td>";



print "<td valign=top style='padding-left:20px'><img src=\"/images/ut_gladiator_types/image/$r[TypeID].jpg\" width=\"195\">";

if($r[Login])
{

print "<br><br><table border=0 width=100% bgcolor=#78746C cellspacing=2 cellpadding=4><td bgcolor=\"#3B484C\"><form method=post action=$PHP_SELF>";

print "<select name=\"id\"><option value=\"$id\">".message(89)."...</option>";


foreach($serialized as $k=>$r)
{
	print "<option value=\"$k\"";

	print ">$r[Gladiator] ($r[TypeName])</option>";
}

print "</select>";


print "<tr><td bgcolor=\"#515E64\"><input type=\"submit\" value=\"".message(107)."\" class=button>";
print "</form></td></table>";



}


print "</td>";

print "</table>";


}
else $form->Draw();

}

require($site_path."bottom.php");
?>