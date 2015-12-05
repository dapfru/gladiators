<?
require('../../config.php');


require($engine_path."cls/auth/session.php");

$type="players/hospital";


require($site_path."up.php");

$r=select("select BuildingID,Name_$lang as Name from fn_buildings_info where BuildingID=3 group by BuildingID order by Name");

$menu[0]="<a href=\"$site_url"."xml/team/buildings.php?id=3\">$r[1]</a>";

$r=select("select StaffID,Name_$lang as Name from fn_staff_info where StaffID=5 group by StaffID order by Name");

$menu[1]="<a href=\"$site_url"."xml/team/staff.php?id=5\">$r[1]</a>";

$r=select("select StaffID,Name_$lang as Name from fn_staff_info where StaffID=6 group by StaffID order by Name");

$menu[2]="<a href=\"$site_url"."xml/team/staff.php?id=6\">$r[1]</a>";

require($site_path."left.php");

if($auth->team)
{

$form->Draw();


if(!$act)
{

	$res=runsql("select i.BuildingID,i.InfoID,i.Comments_$lang; as Comment,concat_ws('-',i.Name_$lang,a.Level) as Name from
(select b.BuildingID,max(b.Level) as Level from tm_buildings b where TeamID='$auth->team' group by b.BuildingID) a
join fn_buildings_info i on i.BuildingID=a.BuildingID and i.Level=a.Level and i.BuildingID=3 order by i.BuildingID");

	if($r=mysql_fetch_array($res))
	{
		
		print "<br><table border=1 bordercolor=E0E9F0 width=100% bgcolor=F5F8FA cellpadding=4 cellspacing=0>";
	
		print "<tr><td rowspan=2 bgcolor=E0E9F0 valign=top ><a href=\"/xml/team/buildings.php?id=$r[BuildingID]\"><img src=\"$img_url?id=$r[InfoID]&record=8\" border=0></a></td><td height=10px class=header><b>$r[Name]</td>";
		print "<tr><td valign=top height=80px width=100%>$r[Comment]</td></tr>";

		print "</table>";
	}
	else print "<br>".icon("error",message(124));

	$res=runsql("select i.StaffID,i.InfoID,concat_ws('-',i.Name_$lang,t.Level) as Name, i.Comments_$lang as Comment from tm_staff t  join fn_staff_info i on i.StaffID=t.StaffID and t.Level=i.Level  and t.TeamID='$auth->team;' and i.StaffID=5 order by t.StaffID");

	if($r=mysql_fetch_array($res))
	{


		print "<br><table border=1 bordercolor=E0E9F0 width=100% bgcolor=F5F8FA cellpadding=2 cellspacing=0>";
	

		print "<tr><td height=10px class=header><b>$r[Name]</td><td rowspan=2 valign=top ><a href=\"/xml/team/staff.php?id=$r[StaffID]\"><img src=\"$img_url?id=$r[InfoID]&record=10\" border=0></a></td>";
		print "<tr><td width=100% valign=top height=86px>$r[Comment]</td></tr>";
		
		print "</table>";
	}
	else print "<br>".icon("error",message(125));

	$res=runsql("select i.StaffID,i.InfoID,concat_ws('-',i.Name_$lang,t.Level) as Name, i.Comments_$lang as Comment from tm_staff t  join fn_staff_info i on i.StaffID=t.StaffID and t.Level=i.Level  and t.TeamID='$auth->team;' and i.StaffID=6 order by t.StaffID");

	if($r=mysql_fetch_array($res))
	{


		print "<br><table border=1 bordercolor=E0E9F0 width=100% bgcolor=F5F8FA cellpadding=2 cellspacing=0>";
	

		print "<tr><td height=10px class=header><b>$r[Name]</td><td rowspan=2  valign=top ><a href=\"/xml/team/staff.php?id=$r[StaffID]\"><img src=\"$img_url?id=$r[InfoID]&record=10\" border=0></a></td>";
		print "<tr><td width=100% valign=top height=86px>$r[Comment]<br><br>";


		$form=new cls_form($type,"operate");
		
		$form->Draw();

		print "</td></tr>";
		
		print "</table>";
	}
	else print "<br>".icon("error",message(126));



}

}
else print icon("error",sysmessage(16));

require($site_path."bottom.php");
?>
