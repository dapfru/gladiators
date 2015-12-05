<?
require('../../config.php');

require($engine_path."cls/auth/session.php");

$type="residence/staff";

if($id&&!$act) $act="hire";

if(!$act) $act="list";

require($site_path."up.php");

if($fire) unset($form_result);

unset($menu);
$i=0;

$res=runsql("select StaffID,Name_$lang as Name from fn_staff_info group by StaffID order by Name");
while($r=mysql_fetch_array($res))
{
	if($id==$r[0])  $menu[$i]="<a href=\"$PHP_SELF?id=$r[0]\"><font class='current'>$r[1]</font></a>";
	else $menu[$i]="<a href=\"$PHP_SELF?id=$r[0]\">$r[1]</a>";

	$i++;
}




require($site_path."left.php");

if($act=="hire2") $act="hire";

if($act=="list")
{

	$res=runsql("select i.StaffID,i.InfoID,i.Salary,t.Date,i.Price,concat_ws('-',i.Name_$lang,t.Level) as Name, i.Comments_$lang as Comment from tm_staff t  join fn_staff_info i on i.StaffID=t.StaffID and t.Level=i.Level  and t.UserID='$auth->user;'  order by t.Date");

	if(!mysql_num_rows($res)) print icon('green',$form->empty);
	else
	{

		print "<table border=0 bordercolor=\"#78746C\" width=100% bgcolor=\"#78746C\" cellpadding=4 cellspacing=1>";
		
		$money=0;

		while($r=mysql_fetch_array($res))
		{
			print "<tr bgcolor=\"#515E64\"><td height=10px bgcolor=\"#3B484C\"><b><a href=\"$PHP_SELF?id=$r[StaffID]\">$r[Name]</a></td>";

			if(file_exists($site_path."images/fn_staff_info/small/$r[InfoID].jpg")) print "<td rowspan=2 valign=middle ><a href=\"staff.php?id=$r[StaffID]\"><img src=\"/images/fn_staff_info/small/$r[InfoID].jpg\" border=0 style=\"align-right:10px\"></a></td>";

			print "<tr bgcolor=\"#515E64\"><td width=100% valign=middle height=90px>$r[Comment]<br>";

			print "<br>".message(207).": ".date("d.m.Y",$r[Date])."</b>
			<br> ".message(208).": ".dots($r[Salary]);	

			$money+=$r[Salary];

			print "</td></tr>";
		}

		if($money) print "<tr><td colspan=2 align=center bgcolor=3B484C><b>Суммарная зарплата (в день): $money</td></tr>";


	print "</table>";
	}
}
elseif($id)
{



if($act=="hire") $r=select("select *,Name_$lang as Name, Comments_$lang as Comments from fn_staff_info where StaffID='$id' and Level = COALESCE((select b.Level from tm_staff b LEFT OUTER JOIN fn_staff_info i on  i.StaffID=b.StaffID where UserID='$auth->user' and  b.StaffID='$id'  order by b.level desc limit 0,1),1)");

$q=select("select * from tm_staff where StaffID='$id' and UserID='$auth->user;'");

print "<table border=0 width=500px cellspacing=0 cellpadding=4>";

if(!$q[Level]&&$act=="hire"||$act!="hire")
{

	$left=0;

	$len=round(strlen($r["Name_$lang"]." ".message(66))*7.6+12);
	if($len<195) $left=round((195-$len)/2);

	if($act=="hire"&&file_exists($site_path."images/fn_staff_info/small/$r[InfoID].jpg")) print "<td valign=top><div  style = \"position:relative\"><center><table border=1 cellspacing=0 cellpadding=4 bordercolor=E5CEA6 bgcolor=515E64 style='position:absolute; left:$left; top:160'><td><font size=-1><center><b>".$r["Name_$lang"]." ".message(66)."</td></table><img src=\"/images/fn_staff_info/img/$r[InfoID].jpg\"></div></td>";
	print "<td valign=top width=100%S>";

		unset($r[Level]);

		if($auth->user) 
		{
			$form=new cls_form($type,$act);
			$form->Draw();
		}
		else print sysmessage(16);


}
else
{

	if($act=="hire"&&file_exists($site_path."images/fn_staff_info/small/$r[InfoID].jpg")) print "<td valign=top><div  style = \"position:relative\"><center><img src=\"/images/fn_staff_info/img/$r[InfoID].jpg\"></div></td>";
	print "<td valign=top width=100%>";

	$form=new cls_form($type,'info');
	$form->Draw();


	if($r[0])
	{

		$r[HaveLevel]=$r[Level];

		unset($r[Level]);

		print "<br>";

		if($auth->user) 
		{
			$form=new cls_form($type,$act);
			$form->Draw();
		}
		else print message(32);
	}

}


print "<div id=staffinfo></div><br>";

print "</td></table>";

}

if($act!="list") print "<br></center><div align=right><a href=$PHP_SELF?act=list>вернуться к списку</a> <img src=\"/images/marker3.gif\" width=11 height=11 border=0></center>";

require($site_path."bottom.php");
?>
