<?


if($act=="list")
{

	$res=runsql("select i.BuildingID,i.InfoID,a.Level,
i.Comments_$lang; as Comment,
concat_ws('-',i.Name_$lang,a.Level) as Name from
(select b.BuildingID,max(b.Level) as Level,Date from tm_buildings b where UserID='$auth->user' group by b.BuildingID) a
join fn_buildings_info i on i.BuildingID=a.BuildingID and i.Type=$Typ and i.Level=a.Level order by a.Date,i.BuildingID");





		print "<table border=0 bordercolor=78746C bgcolor=78746C cellpadding=4 cellspacing=1><input type=\"hidden\" name=\"numrows\" value=\"".mysql_num_rows($res)."\">";
	
		$money=0;
		$i=0;
		while($r=mysql_fetch_array($res))
		{

//, if(coalesce(100-pow((unix_timestamp()-Date)/3600/24/7.863,1.2),0)<=0,0,CEILING(100-pow((unix_timestamp()-Date)/3600/24/7.863,1.2))); as Condition

			$q=select("select b.*, round(i.Price/100) Cond  from tm_buildings b join fn_buildings_info i on i.BuildingID=b.BuildingID and b.Level=i.Level where b.BuildingID='$r[BuildingID]' and b.Level='$r[Level]' and b.UserID='$auth->user'");


			print "<tr bgcolor=\"#515E64\"><td rowspan=2 bgcolor=3B484C valign=top><a href=\"$PHP_SELF?id=$r[BuildingID]\">";
			if(file_exists($site_path."images/fn_buildings_info/small/$r[InfoID].jpg")) print "<img src=\"/images/fn_buildings_info/small/$r[InfoID].jpg\" border=0>";
			print "</a></td><td height=10px  bgcolor=3B484C><a href=\"$PHP_SELF?id=$r[BuildingID]\"><b>$r[Name]</a></td>";


			print "<tr bgcolor=\"#515E64\"><td valign=top height=50px width=100%>$r[Comment]<br>";


			$money+=$q[Cond];

			print "<br><u>".message(209)."</u>: ".date("d.m.Y",$q[Date])."</b>";	
			print "<br><u>".message(212)."</u>: $q[Cond]</b><input type=\"hidden\" name=\"building[".$i."]\" value=\"$q[BuildingID]\"> ";

			if($auth->rang) 
			{
				print "<input name=\"repair[".$i."]\" type=\"checkbox\"";
				if($q[AutoRepair]) print " checked";
				print "> ".message(213);
			}


				//if($q1[0]) print "<img src=\"/images/icons/orn.gif\" width=22 height=15> <a href=\"$PHP_SELF?id=$q[BuildingID]\" class=\"boldlink\">".message(214)."</a>";
			

			print "</td></tr>";






			$i++;
		}


		if($money) print "<tr><td colspan=2 align=center bgcolor=3B484C><b>Суммарная стоимость содержания (в день): $money</td></tr>";

	print "</table>";


	//unset($form);

	if(mysql_num_rows($res)<2) print "<br>".icon('green',$form->empty);

}
elseif($act=="info"&&$form_ok)
{
}
elseif($id)
{



if($act=="upgrade") $r=select("select *,Name_$lang as Name, Comments_$lang as Comments from fn_buildings_info where BuildingID='$id' and Level = COALESCE((select b.Level from tm_buildings b where UserID='$auth->user' and  b.BuildingID='$id'  order by b.level desc limit 0,1),1)");

$q=select("select * from tm_buildings where BuildingID='$id' and UserID='$auth->user;' order by Level desc limit 0,1");

if(!$q[Level]&&$act=="upgrade"||$act!="upgrade")
{


	if($act=="upgrade"&&!$er&&file_exists($site_path."/images/fn_buildings_info/img/$r[InfoID].jpg")) print "<div  style = \"position:relative\"><center><table border=1 cellspacing=0 cellpadding=4 bordercolor=E5CEA6 bgcolor=515E64 style='position:absolute; left:180; top:150'><td><font size=-1><b>".message(65)."</td></table><img src=\"/images/fn_buildings_info/img/$r[InfoID].jpg\"></div><br>";

		$form=new cls_form($type,$act);
		$form->Draw();


}
else
{

	if($act=="upgrade"&&!$er&&file_exists($site_path."/images/fn_buildings_info/img/$r[InfoID].jpg")) print "<div  style = \"position:relative\"><center><img src=\"/images/fn_buildings_info/img/$r[InfoID].jpg\"></div><br>";


	$form=new cls_form($type,'info');
	$form->Draw();

	$r=select("select *,Name_$lang as Name, Comments_$lang as Comments from fn_buildings_info where BuildingID='$id' and Level = 1+'$q[Level]'");
	if($r[0])
	{
		print "<br>";

		if($auth->user) 
		{
			$form=new cls_form($type,$act);
			$form->Draw();
		}

	}

}

}
else $form->Draw();
?>
