<?require('../../config.php');
$form_width=170;
require($engine_path."cls/auth/session.php");

$type="players/transfer";

if(!$act) $act="first";

	$_POST['priv']=checkpriv("players/transfer","check");
require($site_path."up.php");
require($site_path."left.php");

if(0==1) {
print icon('green',"Трансфер временно закрыт для проведения профилактических работ. (до 10.06.06)");
} else {


print "<center><table border=0 cellspacing=1 bgcolor=B1B1B1 cellpadding=0><tr>";
 
$num=$form->numrows;
$bgcol="F1F4F7";
$q=select("select u.TrStatus as TrStatus, tr_fond($auth->team) as fond from ut_teams t left outer join ut_users u on u.UserID=t.UserID where t.TeamID='$auth->team'");



print "<td><table border=0 cellspacing=0 cellpadding=2 bgcolor=B1B1B1 height=20px><tr bgcolor=\"$bgcol\"  height=20px><td><img src=\"/images/icons/golden.gif\" height=15px title=\"".message(149)."\" width=15px border=0> </td><td><b>".message(141).":</b> ".dots($q[fond]).$gd."</td></table>";
print "<td><table border=0 cellspacing=0 cellpadding=2 bgcolor=B1B1B1 height=20px><tr bgcolor=\"$bgcol\"  height=20px><td height=15px><img src=\"/images/icons/transfer.gif\" height=15px title=\"".message(150)."\" width=15px border=0> </td><td><b>".message(142).":</b> ".$q[TrStatus]."</td></table>";
print "</td><td><table border=0 cellspacing=0 cellpadding=2 bgcolor=B1B1B1 height=20px><tr bgcolor=\"$bgcol\"  height=20px><td><img src=\"/images/icons/player.gif\" height=15px title=\"".message(151)."\" width=15px border=0> </td><td> <b>".message(143).":</b> ".$num."</td></table>";
print "</td>";
print "</table><br>";

print "<table border=0 cellspacing=1 bgcolor=B1B1B1 cellpadding=4><tr bgcolor=$bgcol>";
 
$q=select("select Tr_SenderPerc+Tr_LeaguesPerc as Tr_SenderPerc,Tr_ReceiverPerc+Tr_LeaguesPerc as Tr_ReceiverPerc,Tr_LegionerPerc FROM ut_leagues u");

print "<td><b>".message(144).":</b> </td>";
print "<td>".message(145).": <b><font color=EC9E10>$q[0]%</b></font></td>";
print "<td>".message(146).": <b><font color=green>$q[1]%</b></font>,";
print " ".message(147).": <b><font color=green>+$q[2]%</font></b></td>";
print "</table></center><br>";




if($act=="my")
{
	print "<center><b>".message(155).":</b><br><br>";
	$form->Draw();

	print "<br><center><b>".message(156).":</b><br><br>";
	$form=new cls_form($type,"my2");

}


$form->Draw();

if($act=="first") $act="select";

if(!$act||$act=="select"||$act=="search2")
{
	print "<hr>";
	$form=new cls_form($type,"search2");
	$form->Draw();

}


if($act=="history")
{
	print "<hr><center><font></center>";
	$form1=new cls_form($type,"search3");
	$form1->Draw();

}



}
require($site_path."bottom.php");?>