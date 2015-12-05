<?require('../../config.php');

//нет перевода ошибок 14.7.06 D.T.


require($engine_path."cls/auth/session.php");if(!$act) $act="select";
$type="finance/report";

if($team&&checkpriv("control/support","")) setvar('team',$team);
else {setvar('team',$auth->team);$team=$auth->team;}


require($site_path."up.php");
function getmenurow($name,$value,$money)
{
	global $gd;

	if($value<0) $color="red";
	elseif($value>0) $color="green";
	else $color="black";

	if($money) $value="$value"."$gd";

	return "<font class=blue>$name:##<font color=$color>$value</b></font>";
}

$q=select("select Day from ut_leagues where LeagueID='$auth->league'");$menu[0]=getmenurow(message(229),$q[0],0);

$q=select("select Money from fn_accounts where AccountID='$team'");
$menu[1]=getmenurow(message(25),dots($q[0]),1);

$money=$q[0];
$summoney=$q[0];

$q=select("select Merchandise from tm_merchandise where AccountID='$team'");
if(!$q[0]) $q[0]=0;
$menu[2]=getmenurow(message(230),dots($q[0]),0);

$money=$money+$q[0]*25;

$q=select("select sum(money) from fn_payments where status=0 and receiverID='$team' and typeID=14 group by SenderID");

if($q[0]) $menu[3]=getmenurow(message(231),dots($q[0]),1);

$money=$money+$q[0];


$q=select("select Sponsors from ut_teams where TeamID='$team'");

$q1=select("select 10*max(Level) from tm_buildings where TeamID='$team' and BuildingID='11' group by BuildingID");

if($q1[0]) $q[0]=round($q[0]*(100+$q1[0])/100);


if($q[0]) $menu[4]=getmenurow('Спонсорские',dots($q[0]),1);

$q=select("select sum(money) from fn_payments where status=0 and senderID='$team' and typeID=23 group by SenderID");

if($q[0]) $menu[5]=getmenurow(message(232),"-".dots($q[0]),1);

$money=$money-$q[0];



if($summoney!=$money) $menu[6]=getmenurow(message(233),dots($money),1);

require($site_path."left.php");

if(checkpriv("control/support",""))
{
	$q1=select("select sum(Money) from fn_operations where SenderID='$team'");
	$q2=select("select sum(Money) from fn_operations where ReceiverID='$team'");
	$q3=select("select Money from fn_accounts where AccountID='$team'");
	$error=$q1[0]+$q3[0]-$q2[0];
	if($error) 
	{
		print "<font color=red>Error: ".dots($error)."<br></font>";
		print "<b>Outcome:</b> ".dots($q1[0])."<br>";
		print "<b>Income:</b> ".dots($q2[0])."<br>";
		print "<b>Balance:</b> ".dots($q3[0])."<br>";

		$q=select("select OperationID,SenderBalance from fn_operations where SenderID='$team' and OperationDate>unix_timestamp()-3*24*3600 order by OperationID asc limit 0,1");

		$q1=select("select sum(Money) from fn_operations where SenderID='$team' and OperationID>'$q[0]'");
		$q2=select("select sum(Money) from fn_operations where ReceiverID='$team' and OperationID>'$q[0]'");
		$q3=select("select Money from fn_accounts where AccountID='$team'");
		$error=-$q[1]+$q1[0]+$q3[0]-$q2[0];

		if($error) print "<font color=red>";
		else print "<font color=green>";
		print "<br>Three days error:  ".dots($error)."<br>";
		print "</font>";

		print "<b>Start balance:</b> ".dots($q[1])."<br>";
		print "<b>Outcome:</b> ".dots($q1[0])."<br>";
		print "<b>Income:</b> ".dots($q2[0])."<br>";
		print "<b>Balance:</b> ".dots($q3[0])."<br>";


		print "<br>";
	}
}
require($engine_path."cls/common/cls_catalog.php");
$catalog = new cls_catalog();

print "<table border=0 cellspacing=1 bgcolor=D3E1EC cellpadding=4><form action=\"$PHP_SELF\" method=\"post\"><tr><td><select name=\"id\" onchange=\"this.form.submit()\">";
print "<option value=''>".message(54)."</option>";
$catalog->Draw('fn_operation_types','TypeID','select',$id);

print "</select></td></form></table>";

print "<hr>";

$form->Draw();
require($site_path."bottom.php");?>