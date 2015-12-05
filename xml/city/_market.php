<?require('../../config.php');
//$form_width=170;
require($engine_path."cls/auth/session.php");


if(!$id||!is_numeric($id)) $id=$auth->user;
$_POST['id']=$id;


$user=$id;

if(!$act) $act="select";

$type="city/market";

$_POST['user']=$user;




$res=select("select MarketDate from ut_users where UserID='$auth->user'");
//print $res[0];

if(mktime()-$res[0]>8)
{

runsql("update ut_users set MarketDate=unix_timestamp() where UserID='$auth->user'");

runsql("delete from ut_slaves where UserID='$auth->user'");

runsql("insert into ut_slaves (TypeID, CountryID, Age, Talent, Stamina, Morale, Height, Weight, Acc, Str, Dex, Vit, Skl, Level, Exp, UserID, Price)
(select 
(select TypeID from ut_gladiator_types order by rand() limit 1) as TypeID,
(select CountryID from ut_countries order by rand() limit 1) as CountryID,
@age:=round(18+22*rand()) as Age,
@talent:=if((select @a:=(100*rand()))>0,
if(@a<9,1,if(@a<28,2,if(@a<55,3,if(@a<74,4,if(@a<85,5,if(@a<93,6,if(@a<97,7,if(@a<99,8,9)))))))),
if(@a<9,1,if(@a<28,2,if(@a<55,3,if(@a<74,4,if(@a<85,5,if(@a<93,6,if(@a<97,7,if(@a<99,8,9))))))))
) as talent, 100 as Stamina, 100 as Morale, @h:=round(160+39*rand()) as Height, round(@h-115+50*rand()) as Weight,
@acc:=(select if(
(select @s1:=rand())>0 and
(select @s2:=rand())>0 and
(select @s3:=rand())>0 and
(select @s4:=rand())>0 and
(select @s:=@s1+@s2+@s3+@s4)>0,
 if(ROUND(@s1/@s*30)<3,3,if(ROUND(@s1/@s*30)>10,10,ROUND(@s1/@s*30))),
 if(ROUND(@s1/@s*30)<3,3,if(ROUND(@s1/@s*30)>10,10,ROUND(@s1/@s*30))))) as Acc,

@str:=if(ROUND(@s2/@s*30)<3,3,if(ROUND(@s2/@s*30)>10,10,ROUND(@s2/@s*30))) as Str,
@dex:=if(ROUND(@s3/@s*30)<3,3,if(ROUND(@s3/@s*30)>10,10,ROUND(@s3/@s*30))) as Dex,
@Vit:=if(ROUND(@s4/@s*30)<3,3,if(ROUND(@s4/@s*30)>10,10,ROUND(@s4/@s*30))) as Vit,
@skl:=round(@acc+@str+@dex+@Vit) as Skl,
1 as Level, 0 as Exp,'$user;' as UserID, round((45-@age)*if((45-@age)<0,1,power(@talent,0.6))+power(@acc,0.6)+power(@str,0.6)+power(@dex,0.6)+power(@Vit,0.6)+power(@skl,0.6))*10 as Price
from en_numbers where Number<11)");

$res=runsql("select CountryID,PlayerID from ut_slaves where UserID='$user;'");

while($r=mysql_fetch_array($res))
	{
		$nm=runsql("select Name from ut_gladiator_names where CountryID='$r[CountryID]' order by rand() limit 1");
		$n=mysql_fetch_array($nm);
		//print"--".$r[CountryID]."--".$n[Name]; exit;
		runsql("update ut_slaves set Name_rus='$n[Name]' where PlayerID='$r[PlayerID]'");
	}

}



require($site_path."up.php");



if($form_ok) {$form=new cls_form($type,'select'); $act="select";}
require($site_path."left.php");

?>
<center><img src="/images/art/market.jpg" width=500px height=300px></center>
<?

$r1=select ("select sum(Slots) as Slots from tm_buildings where UserID='$auth->user'");
$r2=select ("select sum(Slots) as Slots from ut_players
left outer join ut_gladiator_types using (TypeID) where UserID='$user'"); 

$r=$r1[Slots]-$r2[Slots];

if($act=="buy") 
{

	$r3=select ("select Slots from ut_slaves left outer join ut_gladiator_types using (TypeID) where PlayerID='$id'"); 
	
	$r4=select("select b.BuildingID, concat(b.Name_$lang,'-',b.Level) as building from ut_slaves s
	 left outer join fn_gladiators_conditions c using(TypeID) 
		left outer join fn_buildings_info b using(InfoID) where PlayerID='$id'");
	$r5=select("select RecordID from tm_buildings where BuildingID='$r4[BuildingID]' and UserID='$user'");
	if(!$r5[RecordID])
	{
		print"<h3>Для найма гладиатора этого типа Вам нужно построить: $r4[building]</h3>";
	}
	elseif($r3[Slots]>$r)
	{
		print"<h3>Не хватает слотов для покупки раба</h3><br><h3>У Вас осталось слотов: $r</h3><br><h3>Необходимо слотов: $r3[Slots]</h3>";
	}
	else
	$form->Draw(); 
}
else 
{
 
	print"<br><h3>У Вас осталось слотов: $r</h3><br>";

	print"<br><h3>Доступные рабы:</h3><br>";

/*
print "<table border=0 cellpadding=1 width=100% cellspacing=0><td valign=top width=50%>";

$forma = new cls_form('gladiators/roster','main');
$forma->Draw();

print "</td><td valign=top width=50%>";

$forma = new cls_form('gladiators/roster','main2');
$forma->Draw();

print "</table>";

print "<hr>";

*/

	$form->Draw();

/*
if($act=="select")
{
	//table();
	print "<br><table border=0 bordercolor=78746C width=100% bgcolor=78746C cellspacing=2 cellpadding=3>";
	print "<tr class=header align=center><td><b>Инфраструктура</td><td><b>Специалисты</td><td><b>Стадион</td></tr><tr bgcolor=545E61>";
	
	print "<td width=33% valign=top>";

	//$res=runsql("select concat(i.Name_$lang,'-',b.Level) as Name from tm_buildings b join fn_buildings_info i on b.BuildingID=i.BuildingID and b.Level=i.Level where b.userID='$user'");

$res=runsql("select concat(i.Name_$lang,'-',a.Level),a.BuildingID from
(select b.BuildingID,max(b.Level) as Level from tm_buildings b where userID='$user' group by b.BuildingID) a
join fn_buildings_info i on i.BuildingID=a.BuildingID and i.Type=0 and i.Level=a.Level order by i.BuildingID");

	while($r=mysql_fetch_array($res))
	{
		print "» <a href=\"$site_url"."xml/user/buildings.php?id=$r[1]\">".$r[0]."</a><br>";
	}

	print "</td>";

	print "<td width=33% valign=top>";

	$res=runsql("select concat_ws('-',i.Name_$lang,t.Level) as Name,t.StaffID from tm_staff t  join fn_staff_info i on i.StaffID=t.StaffID and t.Level=i.Level  and t.userID='$user'  order by t.Date");

	while($r=mysql_fetch_array($res))
	{
		print "» <a href=\"$site_url"."xml/user/staff.php?id=$r[1]\">".$r[0]."</a><br>";
	}


	print "</td>";

	print "<td width=33% valign=top>";

$res=runsql("select concat(i.Name_$lang,'-',a.Level),a.BuildingID from
(select b.BuildingID,max(b.Level) as Level from tm_buildings b where userID='$user' group by b.BuildingID) a
join fn_buildings_info i on i.BuildingID=a.BuildingID and i.Type=1 and i.Level=a.Level order by i.BuildingID");

	while($r=mysql_fetch_array($res))
	{
		print "» <a href=\"$site_url"."xml/user/stadium.php?id=$r[1]\">".$r[0]."</a><br>";
	}


	print "</td>";
	print "</table>";
}
*/



}
require($site_path."bottom.php");?>