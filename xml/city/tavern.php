<?require('../../config.php');

require($engine_path."cls/auth/session.php");


if(!$act) $act="select";

$type="city/tavern";

$_POST['user']=$user;


$res=select("select TavernDate from ut_users where UserID='$auth->user'");


if(date("d",mktime()-5*3600)!=date("d",$res[0])||date("m",mktime()-5*3600)!=date("m",$res[0]))
//if(1==1)
{


$num=mt_rand(3,10);


runsql("update ut_users set TavernDate=unix_timestamp()-5*3600 where UserID='$auth->user'");

runsql("delete from ut_tavern where UserID='$auth->user'");

runsql("insert into ut_tavern (TypeID, CountryID, Age, Talent, Height, Weight, UserID)
(select @t:=
(select TypeID from ut_gladiator_types order by rand() limit 1) as TypeID,
(select CountryID from ut_gladiator_countries where TypeID=@t order by Rate*rand()*rand() desc,Rate desc limit 1) as CountryID,
@age:=round(18+20*rand()) as Age,

@talent:=if((select @a:=(1000*rand()))>0,
if(@a<90,1,if(@a<280,2,if(@a<550,3,if(@a<740,4,if(@a<850,5,if(@a<950,6,if(@a<995,7,if(@a<999,8,9)))))))),
if(@a<90,1,if(@a<280,2,if(@a<550,3,if(@a<740,4,if(@a<850,5,if(@a<950,6,if(@a<995,7,if(@a<999,8,9))))))))
) as Talent, 
@h:=round(160+30*rand())+(select Height from ut_gladiator_types where TypeID=@t) as Height, 
round(@h-115+50*rand())+(select Weight from ut_gladiator_types where TypeID=@t) as Weight,

'$auth->user' as UserID

from en_numbers where Number<=$num)");



	$res=runsql("select CountryID,GladiatorID from ut_tavern where UserID='$auth->user'");
	while($r=mysql_fetch_array($res))
	{
		
		unset($a);

		$level=mt_rand(6,10);

		for($i=1;$i<=$level*3;$i++)
		{
			$a[mt_rand(0,3)]+=1;
		}


		$n=select("select Name from ut_gladiator_names where CountryID='$r[CountryID]' order by rand() limit 1");
		runsql("update ut_tavern g set Name='$n[Name]',Level='$level',Acc=1+'$a[0]',Vit=1+'$a[1]',Str=1+'$a[2]',Dex=1+'$a[3]',
Price=round(power(1.18,'$level')*(12/(10-Talent)-1)*(select Coefficient from ut_gladiator_types where TypeID=g.TypeID)*1.5*EXP((Age-23)*(Age-23)/-200)*100) where GladiatorID='$r[GladiatorID]'");

	}

}


require($site_path."up.php");

if($form_ok) {$form=new cls_form($type,'select'); $act="select";}
require($site_path."left.php");


?>
<center><img src="/images/art/tavern.jpg" width=500px height=300px></center>
<?


$r1=select ("select sum(Slots) as Slots from tm_buildings where UserID='$auth->user'");

foreach($auth->rst[Gladiators] as $k=>$v)
{
	$t=$v[TypeID];
	$q=select("select Slots from ut_gladiator_types where TypeID='$t'");
	$slots+=$q[0];
}


$slotsnum=$r1[Slots]-$slots;

if($act=="buy") 
{

	$r3=select ("select Slots from ut_tavern left outer join ut_gladiator_types using (TypeID) where GladiatorID='$id'"); 
	
	$r4=select("select b.BuildingID, concat(b.Name_$lang,'-',b.Level) as building from ut_tavern s
	 left outer join fn_gladiators_conditions c using(TypeID) 
		left outer join fn_buildings_info b using(InfoID) where GladiatorID='$id'");
	$r5=select("select RecordID from tm_buildings where BuildingID='$r4[BuildingID]' and UserID='$auth->user'");
	if($r4[BuildingID]&&!$r5[RecordID])
	{
		print icon("error","Для найма гладиатора этого типа Вам нужно построить: $r4[building]")."<br>";
		$act='select';
		$form1=new cls_form($type,$act);
		$form1->Draw();
	}
	elseif($r3[Slots]>$slotsnum)
	{
		print icon("error","Не хватает слотов для гладиаторов.<br>У Вас осталось слотов: $slotsnum<br>Необходимо слотов: $r3[Slots]")."<br>";
		$act='select';
		$form1=new cls_form($type,$act);
		$form1->Draw();
	}
	else
	$form->Draw(); 
}
else 
{
 
	print"<br><h3>У Вас осталось слотов: $slotsnum</h3>";

	print"<h3>Доступные наемники:</h3>";


	$form->Draw();


}

require($site_path."bottom.php");
?>