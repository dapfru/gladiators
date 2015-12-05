<?require('../../config.php');
//$form_width=170;
require($engine_path."cls/auth/session.php");

if(!$act) $act="select";
$type="city/hippo";

$_POST['user']=$user;

//--------------------инициализация переменных------------------

$horses_count=5;
$races_count=20;
unset($horses_wins);


//-----расчет параметров на ближайшие заезды-------------------------

$res=runsql("select * from ut_races where Result_Names='' order by Date asc limit 0,5");
$r=mysql_fetch_array($res);

$leftcontent.="<font size=4pt>Ближайшие заезды:</font><br><br>";

for($k=1;$k<=3;$k++)
{
	$r=mysql_fetch_array($res);

		$resarr_nm=explode("/",$r[Horses_Names]);
		$resarr_wn=explode("/",$r[Horses_Wins]);
		$resarr_co=explode("/",$r[Horses_Coefficients]);
		for($i1=1;$i1<=$horses_count;$i1++)
		{
			$horses_names[$i1]=$resarr_nm[$i1-1];
			$horses_wins[$i1]=$resarr_wn[$i1-1];
			$horses_coefficients[$i1]=$resarr_co[$i1-1];
		}

	$leftcontent.="<table border=0 width=200px bgcolor=#78746C cellspacing=1 cellpadding=4><tr valign=middle align=middle class=\"header\"><td>Колесница</td>
	<td>Победы</td>
	<td>Коэф</td>";

	for($i=1;$i<=$horses_count;$i++)
	{
		if($col=="#3B484C") $col="#545E61"; else $col="#3B484C";
		$leftcontent.="<tr bgcolor=$col><td>$i. $horses_names[$i]</td>
		<td align=center>$horses_wins[$i]</td>
		<td align=center>$horses_coefficients[$i]</td>";

	}
	$leftcontent.="</table><br><br>";
} 
unset($k);
//------------------------------------------


	$r=select("select r.* from ut_races r left outer join ut_stakes s on r.RaceID=s.RaceID and 
s.UserID='$auth->user' where r.Result_Names<>'' order by StakeID is null asc, r.Date desc limit 0,1");
	
	if($r[0])
	{
		$resarr_num=explode("/",$r[Result_Numbers]);
		$resarr_nam=explode("/",$r[Result_Names]);

		$r1=select("select * from ut_stakes where RaceID='$r[RaceID]' and UserID='$auth->user' order by StakeID desc limit 0,1");
		if($r1&&$r1[HorseNumber]==$resarr_num[0]) $gain=$r1[Sum]*$r1[Coefficient]; else $gain=0;
				
		if($r1)
		{

			if($r1[Paid]!='1')
			{	

				lock_rst($auth->user);

				transfer_money($gain,1,$auth->user,4,$r1[StakeID]);

				unlock_rst($auth->user);
				$auth->rst=read_rst($auth->user);
				mysql_query("update ut_stakes set Paid='1' where StakeID='$r1[StakeID]'");
			}
		}

	}


$mes='';


if($sum&&$num)
{


	if($auth->rst[Money]<$sum) $mes="error"; 
	elseif($sum<50) $mes= "error 1";
	elseif($sum>1000) $mes= "error 2";
	else 
	{
	$q=select("select * from ut_races where RaceID='$race' order by Date desc limit 0,1");
	$q1=select("select * from ut_stakes where UserID='$auth->user' and RaceID='$race'");

	if($q[Result_Names]<>''||$q[Date]<time()) 
	{
		$mes= icon("green","Заезд уже состоялся, ставки больше не принимаются. Попробуйте сделать ставку в <a href=\"/xml/city/hippo.php\">следующем заезде</a>");
	}
	elseif($q1[0])
	{
		$wait=date("i",$q[Date])-date("i",$tm);	
		if($wait>0) $mes= icon("green","Вы уже сделали ставку на этот заезд. Результаты гонки - через $wait минут.");
		else $mes=icon("green","Заезд завершен.<a href=\"/xml/city/hippo.php\">Ознакомьтесь с результатами.</a>");
	}
	else
	{
		$coef=explode("/",$q[Horses_Coefficients]);
		$koef=$coef[$num-1];
		if(date("i",$q[Date])==30) $wait=date("i",$q[Date])-date("i",$tm); else	$wait=60-date("i",$tm);


		mysql_query("insert into ut_stakes(RaceID,UserID,Date,Sum,Coefficient,HorseNumber,Paid,IP)
		 values('$race','$auth->user',unix_timestamp(),'$sum','$koef','$num','0','$REMOTE_ADDR')");

		$r1=select("select StakeID from ut_stakes where UserID='$auth->user'");


		lock_rst($auth->user);

		transfer_money($sum,$auth->user,1,3,$r1[0]);

		unlock_rst($auth->user);
				$auth->rst=read_rst($auth->user);

		$mes= icon("green","Ставка принята.");
	}
	}
}

require($site_path."up.php");
require($site_path."left.php");

?>
<center><img src="/images/art/hippo.jpg" width=500px height=300px></center>
<?

if($mes) print $mes;

$tm=time();


//if(!$sum) // форма для ставок-----------
//{
	//------- результаты последнего заезда------------------------------------
	
	$r=select("select r.* from ut_races r left outer join ut_stakes s on r.RaceID=s.RaceID and 
s.UserID='$auth->user' where r.Result_Names<>'' order by StakeID is null asc, r.Date desc limit 0,1");
	
	if($r[0])
	{
		$resarr_num=explode("/",$r[Result_Numbers]);
		$resarr_nam=explode("/",$r[Result_Names]);

	
		$wins_nam=explode("/",$r[Horses_Coefficients]);

		$r1=select("select * from ut_stakes where RaceID='$r[RaceID]' and UserID='$auth->user' order by StakeID desc limit 0,1");
		if($r1&&$r1[HorseNumber]==$resarr_num[0]) $gain=$r1[Sum]*$r1[Coefficient]; else $gain=0;
			
		print"<font size=4pt><br>Результаты предыдущего заезда: </font><br><br>";
		//print"Состоялся: ".date("d.m H:i",$r[Date])."<br><br>";

		for($i=1;$i<=$horses_count;$i++)
		{
			if($r1[HorseNumber]==$resarr_num[$i-1]) print "<u>";
			$num=$resarr_num[$i-1]-1;
			print "$i-е место: ".$resarr_nam[$i-1]."(колесница <b>№".$resarr_num[$i-1]."</b>, коэф. <b>".$wins_nam[$num]."</b>)</u><br>";
		}		
		if($r1)
		{
			print "<br><b>Ваша ставка:</b> ".$r1[Sum]." на колесницу №".$r1[HorseNumber]."<br>";
			print "<b>Коэффициент:</b> ".$r1[Coefficient]."<br>";
			print "<b>Выигрыш:</b> ".$gain."<br><br>";
		
		}
		else print "Вы не делали ставок на этот заезд<br><br>";
	}

	//----------------новый заезд------------------------------------------
	
	$q=select("select * from ut_races where Result_Names='' order by Date asc limit 0,1");

	$r1=select("select * from ut_stakes where UserID='$auth->user' and RaceID='$q[RaceID]' order by Date desc limit 0,1");

	if(!$r1[0]&&$q[Date]>time())
	{
	
	$r2=select("select * from ut_races where Result_Names='' and Date>unix_timestamp() order by Date asc limit 0,1");

		$resarr_nm=explode("/",$r2[Horses_Names]);
		$resarr_wn=explode("/",$r2[Horses_Wins]);
		$resarr_co=explode("/",$r2[Horses_Coefficients]);
		for($i1=1;$i1<=$horses_count;$i1++)
		{
			$horses_names[$i1]=$resarr_nm[$i1-1];
			$horses_wins[$i1]=$resarr_wn[$i1-1];
			$horses_coefficients[$i1]=$resarr_co[$i1-1];
		}

		print"<font size=4pt>Участники:</font><br><br>";
		print"<table width=350px border=0 width=100% bgcolor=#78746C cellspacing=1 cellpadding=4><form name=\"hippo\" method=\"post\" action=\"/xml/city/hippo.php\"><tr valign=middle align=middle class=\"header\"><input type=hidden name=act value='stake'><input type=hidden name=step value=1><td>Колесница</td>
		<td>Количество побед в <br>последних $races_count заездах</td>
		<td>Коэффициент</td><td>&nbsp;</td>";

		for($i=1;$i<=$horses_count;$i++)
		{	
			if($col=="#3B484C") $col="#545E61"; else $col="#3B484C"; 
			print"<tr bgcolor=$col style='color:blue'><td>$i. $horses_names[$i]</td>
			<td align=center>$horses_wins[$i]</td>
			<td align=center>$horses_coefficients[$i]</td>
			<td><input type=radio value=$i name=\"num\" style=\"background-color:$col\"></td>";

		}

		if($col=="#3B484C") $col="#545E61"; else $col="#3B484C";
		print"<tr bgcolor=$col><td colspan=4>Ставка: <input type=text size=10 name=\"sum\" value=\"\"></td>";
		if($col=="#3B484C") $col="#545E61"; else $col="#3B484C"; 
		print"<tr bgcolor=$col><td colspan=4><input type=\"submit\" class=\"button\" value=\"Подтвердить\">
		<input type=hidden value=\"$r2[RaceID]\" name=\"race\"></td>";
		print"</form></table><br>";
		print"<font size=4pt>Время начала: ".date("H:i",$r2[Date])."</font><br>";
	}
	elseif($q[Date]<time()) //----т.е. ипподром сломался-------
	{
		print icon("green","На данный момент ипподром закрыт. Попробуйте зайти позже.");
	}
	else//---- т.е. ставка на заезд уже сделана------
	{

	$r2=select("select * from ut_races where Result_Names='' and Date>unix_timestamp() order by Date asc limit 0,1");

		$resarr_nm=explode("/",$r2[Horses_Names]);
		$resarr_wn=explode("/",$r2[Horses_Wins]);
		$resarr_co=explode("/",$r2[Horses_Coefficients]);
		for($i1=1;$i1<=$horses_count;$i1++)
		{
			$horses_names[$i1]=$resarr_nm[$i1-1];
			$horses_wins[$i1]=$resarr_wn[$i1-1];
			$horses_coefficients[$i1]=$resarr_co[$i1-1];
		}

		print"<font size=4pt>Участники:</font><br><br>";
		print"<table width=350px border=0 width=100% bgcolor=#78746C cellspacing=1 cellpadding=4>
<tr valign=middle align=middle class=\"header\"><td>Колесница</td>
		<td>Количество побед в <br>последних $races_count заездах</td>
		<td>Коэффициент</td>";

		for($i=1;$i<=$horses_count;$i++)
		{	
			if($col=="#3B484C") $col="#545E61"; else $col="#3B484C"; 
			print"<tr bgcolor=$col style='color:blue'><td>";

			if($r1[HorseNumber]==$i) print "<u>";

			print "$i. $horses_names[$i]</td>
			<td align=center>$horses_wins[$i]</td>
			<td align=center>$horses_coefficients[$i]</td>";

		}

		if($col=="#3B484C") $col="#545E61"; else $col="#3B484C";
		print"<tr bgcolor=$col><td colspan=4>Ставка: $r1[Sum]</td>";
		if($col=="#3B484C") $col="#545E61"; else $col="#3B484C"; 

		print"</table><br>";
		print"<font size=4pt>Время начала: ".date("H:i",$r2[Date])."</font><br><br>";


		if(date("i",$q[Date])==30) $wait=date("i",$q[Date])-date("i",$tm); else	$wait=60-date("i",$tm);
		print icon("green","Вы уже сделали ставку на этот заезд. Результаты гонки - через $wait минут.");
	}
//}
	



require($site_path."bottom.php");
?>