<?
$form->Draw();

if($act=="select")
{
	//table();
	print "<br><table border=0 bordercolor=78746C width=100% bgcolor=78746C cellspacing=2 cellpadding=3>";
	print "<tr class=header align=center><td><b>Инфраструктура</td><td><b>Мастера</td><td><b>Арены</td></tr><tr bgcolor=545E61>";
	
	print "<td width=33% valign=top>";

	//$res=runsql("select concat(i.Name_$lang,'-',b.Level) as Name from tm_buildings b join fn_buildings_info i on b.BuildingID=i.BuildingID and b.Level=i.Level where b.userID='$user'");

$res=runsql("select concat(i.Name_$lang,'-',a.Level),a.BuildingID from
(select b.BuildingID,max(b.Level) as Level from tm_buildings b where userID='$user' group by b.BuildingID) a
join fn_buildings_info i on i.BuildingID=a.BuildingID and i.Type=0 and i.Level=a.Level order by i.BuildingID");

	while($r=mysql_fetch_array($res))
	{
		print "» <a href=\"$site_url"."xml/residence/buildings.php?id=$r[1]\">".$r[0]."</a><br>";
	}

	print "</td>";

	print "<td width=33% valign=top>";

	$res=runsql("select concat_ws('-',i.Name_$lang,t.Level) as Name,t.StaffID from tm_staff t  join fn_staff_info i on i.StaffID=t.StaffID and t.Level=i.Level  and t.userID='$user'  order by t.Date");

	while($r=mysql_fetch_array($res))
	{
		print "» <a href=\"$site_url"."xml/residence/staff.php?id=$r[1]\">".$r[0]."</a><br>";
	}


	print "</td>";

	print "<td width=33% valign=top>";

$res=runsql("select concat(i.Name_$lang,'-',a.Level),a.BuildingID from
(select b.BuildingID,max(b.Level) as Level from tm_buildings b where userID='$user' group by b.BuildingID) a
join fn_buildings_info i on i.BuildingID=a.BuildingID and i.Type=1 and i.Level=a.Level order by i.BuildingID");

	while($r=mysql_fetch_array($res))
	{
		print "» <a href=\"$site_url"."xml/residence/stadium.php?id=$r[1]\">".$r[0]."</a><br>";
	}


	print "</td>";
	print "</table>";
}


?>