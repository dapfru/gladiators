<?
require('../../config.php');

require($engine_path."cls/auth/session.php");

$type="arena/fight";
unset($act);


$fname=$site_path."files/gam/".$id.".gam";

if(file_exists($fname)) header("Location:online.php?id=$id");


require($site_path."up.php");

require($site_path."left.php");

?>
<center><img src="/images/art/arena.jpg" width=500px height=300px></center>
<?


if($id)
{


	$q=select("select a.*,u1.Login Login1, u2.Login Login2,a.Date+60*a.Timeout-unix_timestamp() Timeleft from ft_agreements a
			join ut_users u1 on u1.UserID=a.UserID1
			join ut_users u2 on u2.UserID=a.UserID2 
			where a.RecordID='$id'");
	if($q[0])
	{


		print "<br><center>$q[Login1] vs. $q[Login2]<br><br><img src=\"/images/sep.gif\" height=1px width=180px><br><br>";

		if(($q[Timeleft]<=0 && !file_exists($fname))||(file_exists($site_path."files/ord/".$id."-$q[UserID1].ord")&&file_exists($site_path."files/ord/".$id."-$q[UserID2].ord")))
		{
			print "Генерируем бой";
			

			$file=fopen($fname,"w");

			function getfile($fname)
			{
				$file=fopen($fname,"r");
				$str=fread($file,filesize($fname));
				fclose($file);
				return pack("l",strlen($str)).$str;
			}


			$q=mysql_query("select Date+60*Timeout Date,UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl from ft_agreements where RecordID='$id'");
			$q=mysql_fetch_array($q,1);
			$gam=$q;
			$gam[Date]=mktime();
	
			if($q[Date]) 
			{



			$str=serialize($gam).getfile($site_path."files/rst/".$q[UserID1].".rst").getfile($site_path."files/ord/$id-".$q[UserID1].".ord").getfile($site_path."files/rst/".$q[UserID2].".rst").getfile($site_path."files/ord/$id-".$q[UserID2].".ord");

/*
$time=microtime(1);
for($i=1;$i<=1000;$i++)
{
	$a=gzcompress($str);
}

print "<br>".(microtime(1)-$time);


$time=microtime(1);
for($i=1;$i<=1000;$i++)
{
	$a=gzcompress($str,0);
}

print "<br>".(microtime(1)-$time);
*/
			//$str=bzcompress($str);




			fputs($file,"GAM".pack("N",0x01000000).md5($str.$secpass).$str);
			//fputs($file,$str);

			runsql("insert into ft_battles(RecordID,UserID1,UserID2,Date,TypeID,ExtraGlad,LimitGlad,LimitSkl) 
(select RecordID,UserID1,UserID2,unix_timestamp(),TypeID,ExtraGlad,LimitGlad,LimitSkl from ft_agreements where RecordID='$id')");
			runsql("delete from ft_agreements where RecordID='$id'");

			fclose($file);


			$res=exec("/var/www/gladiators_admin/gladcore /var/www/gladiators.ru/files/gam/$id.gam");
			
//$fname=$site_path."files/gam/".$id.".gam";
//$f=fopen($fname,"r");

//$gam=unserialize(substr(fread($f,filesize($fname)),39));

$user1=$q[UserID1];
$user2=$q[UserID2];



//$fname=$site_path."files/gam/".$id.".res";
//$f=fopen($fname,"r");

$ar=unserialize($res);

//print "1) ".$ar[Score].$ar[Score][0]."<br>";
//print "2) ".$ar[Score][1]."<br>";
//print "деньги: ".$ar[Money]."<br>";

lock_rst($user1);
lock_rst($user2);

$rst1=read_rst($user1);
$rst2=read_rst($user2);

foreach($rst1[Gladiators] as $k=>$v)
{

		if(!$rst1[Gladiators][$k][PercentTrain]) $rst1[Gladiators][$k][PercentTrain]=0;
		$coef=10+(100-$rst1[Gladiators][$k][PercentTrain])*30/100;

		$rst1[Gladiators][$k][Stamina]=intval($rst1[Gladiators][$k][Stamina]+$coef*(mktime()-$r[Date])/3600);

		if($rst1[Gladiators][$k][Morale]!=0) 
		{
			$mor=intval(round($rst1[Gladiators][$k][Morale]-($rst1[Gladiators][$k][Morale])/abs($rst1[Gladiators][$k][Morale])*(mktime()-$r[Date])/3600));
		
			if(($mor)*($rst1[Gladiators][$k][Morale])<0) $rst1[Gladiators][$k][Morale]=0;
			else $rst1[Gladiators][$k][Morale]=$mor;
		}



		$rst1[Gladiators][$k][Injury]=intval(round($rst1[Gladiators][$k][Injury]-(mktime()-$r[Date])/3600));
		if($rst1[Gladiators][$k][Injury]<0) $rst1[Gladiators][$k][Injury]=0;
}

foreach($rst2[Gladiators] as $k=>$v)
{

		if(!$rst2[Gladiators][$k][PercentTrain]) $rst2[Gladiators][$k][PercentTrain]=0;
		$coef=10+(100-$rst2[Gladiators][$k][PercentTrain])*30/100;

		$rst2[Gladiators][$k][Stamina]=intval($rst2[Gladiators][$k][Stamina]+$coef*(mktime()-$r[Date])/3600);

		if($rst2[Gladiators][$k][Morale]!=0) 
		{
			$mor=intval(round($rst2[Gladiators][$k][Morale]-($rst2[Gladiators][$k][Morale])/abs($rst2[Gladiators][$k][Morale])*(mktime()-$r[Date])/3600));
		
			if(($mor)*($rst2[Gladiators][$k][Morale])<0) $rst2[Gladiators][$k][Morale]=0;
			else $rst2[Gladiators][$k][Morale]=$mor;
		}



		$rst2[Gladiators][$k][Injury]=intval(round($rst2[Gladiators][$k][Injury]-(mktime()-$r[Date])/3600));
		if($rst2[Gladiators][$k][Injury]<0) $rst2[Gladiators][$k][Injury]=0;
}


$score1=reset($ar[Score]);
$score2=next($ar[Score]);

if($score1>$score2) 
{
	transfer_money($ar[Money],1,$user1,26,$id);
	$rst1[Win]++;
	$rst2[Lose]++;
}
elseif($score1<$score2) 
{
	transfer_money($ar[Money],1,$user2,26,$id);
	$rst2[Win]++;
	$rst1[Lose]++;
}
else 
{
	$rst1[Tie]++;
	$rst2[Tie]++;
	transfer_money(round($ar[Money]/2),1,$user1,26,$id);
	transfer_money(round($ar[Money]/2),1,$user2,26,$id);
}

foreach($ar[Gladiators] as $k=>$v)
{

	if($v[Stamina]<0) $v[Stamina]=0;

	//print	"$k $v[Stamina] $v[Morale] $v[Injury] $v[Exp]<br>";

	if($rst1[Gladiators][$k]) 
	{
		$rst1[Gladiators][$k][Morale]=$v[Morale];
		$rst1[Gladiators][$k][Injury]=$v[Injury];

		$rst1[Gladiators][$k][Stamina]=$v[Stamina];
		$rst1[Gladiators][$k][Exp]+=round($v[Exp],3);

//print "[$k][Morale]=$v[Morale]<br>";
//print "[$k][Injury]=$v[Injury]<br>";
//print "[$k][Stamina]=$v[Stamina]<br>";
//print "[$k][Exp]=$v[Exp]<br>";

	}
	elseif($rst2[Gladiators][$k]) 
	{
		$rst2[Gladiators][$k][Morale]=$v[Morale];
		$rst2[Gladiators][$k][Injury]=$v[Injury];

		$rst2[Gladiators][$k][Stamina]=$v[Stamina];
		$rst2[Gladiators][$k][Exp]+=round($v[Exp],3);

//print "[$k][Morale]=$v[Morale]<br>";
//print "[$k][Injury]=$v[Injury]<br>";
//print "[$k][Stamina]=$v[Stamina]<br>";
//print "[$k][Exp]=$v[Exp]<br>";

	}
}

//exit;

$rst1[Date]=mktime();
$rst2[Date]=mktime();

write_rst($user1,$rst1);
write_rst($user2,$rst2);

unlock_rst($user1);
unlock_rst($user2);


//exit;
header("Location:online.php?id=$id");




			}
		}
		else 
		{
			print "До боя осталось: <input type=\"text\" id=\"Timer\" style=\"border:0;background-color:3B484C;color:E5CEA6\" readonly size=4>";

			print "<br><a href=/builder/?id=$id>Вернуться к настройкам</a>";

?>

<script language="JavaScript">

<!-- www.cgi.ru -->

var up, down;

var min1, sec1;

var cmin, csec;

function Minutes(data) 
{ 
	for(var i=0;i<data.length;i++) if(data.substring(i,i+1) ==":") break;
	return(data.substring(0,1)); 
}



function Seconds(data) 
{ 
	for(var i=0;i<data.length;i++) if(data.substring(i,i+1) ==":") break;
	return(data.substring(i+1,data.length)); 
}



function Display(min,sec) 
{ 

	var disp;
	disp='';
	if(min<=9) disp+="0";
	disp+=min+":";
	if(sec<=9) disp+="0"+sec;
	else disp+=sec;
	return(disp); 
}



function Down() 
{

	cmin=<?=floor($q[Timeleft]/60)?>;

	csec=0+<?=($q[Timeleft]%60)?>;
	DownRepeat(); 
}



function DownRepeat() 
{

	csec--;

	if(csec==-1) { csec=59; cmin--; }

	document.getElementById("Timer").value=Display(cmin,csec);

	if((cmin==0) && (csec==0)) document.location.href='fight.php';

	else 	
	{
		down=setTimeout("DownRepeat()",1000); 
	}
// -- www.cgi.ru -->
		
}		


Down() ;
</script>
<?

		}

	}
}



require($site_path."bottom.php");
?>