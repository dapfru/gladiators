<?
require('../../config.php');

require($engine_path."cls/auth/session.php");

$type="arena/fight";
unset($act);

//$fname=$site_path."files/gam/".$id.".gam";
$fname=gampath($id)."/".$id.".gam";


if(file_exists($fname)) header("Location:online.php?id=$id");
elseif($id)
{


	$agreement=select("select a.*,u1.Login Login1, u2.Login Login2,
a.Date+60*a.Timeout-unix_timestamp() Timeleft ,
a.Date+60*a.Timeout TimeLeft
			from ft_agreements a
			join ut_users u1 on u1.UserID=a.UserID1
			join ut_users u2 on u2.UserID=a.UserID2 
			where a.RecordID='$id'");

	$q=$agreement;

		if(($q[Timeleft]<=0 && !file_exists($fname))||(file_exists($site_path."files/ord/".$id."-$q[UserID1].ord")&&file_exists($site_path."files/ord/".$id."-$q[UserID2].ord")))
		{
			generategame($id);
			header("Location:online.php?id=$id");
		}
}


require($site_path."up.php");

require($site_path."left.php");

?>
<center><img src="/images/art/arena.jpg" width=500px height=300px></center>
<?


if($id)
{

	$q=$agreement;


	if($q[0])
	{

		$user1=$q[UserID1];
		$user2=$q[UserID2];
		print "<center><div style='font-size:24pt;'><a href=/users/$user1 style='color:FF9600;font-size:24pt;'>$q[Login1]</a> vs. <a href=/users/$user2 style='color:D5D5D5;font-size:24pt;'>$q[Login2]</a></div><br><img src=\"/images/sep.gif\" height=1px width=180px><br><br>";



			print "Ожидание заявки противника. Таймаут: <input type=\"text\" id=\"Timer\" style=\"border:0;background-color:3B484C;color:E5CEA6\" readonly size=4>";

			print "<br><a href=/builder/?id=$id>Вернуться к настройкам</a>";

?>


<script>

document.write("<scr"+"ipt lang"+"uage=\"Java"+"Script\" src=\"load/jshttp.js\"></scr"+"ipt>");
function refresh()
{
	if (timer>=0) clearTimeout(timer);
	timer=setTimeout('refresh()',5000);
	GetFight();
}

function GetFight(type) {

	var req = new Subsys_JsHttpRequest_Js();
	req.onreadystatechange = function() {
		if (req.readyState == 4) {
			if (req.responseJS) {
				if(req.responseJS.redirect) document.location.href=req.responseJS.redirect;
			}
		}
	}
	req.open('POST', 'get_fight.php?time=<?=$q[TimeLeft]?>&user1=<?=$q[UserID1]?>&user2=<?=$q[UserID2]?>&id=<?=$id?>&rand='+Math.floor(Math.random() * 1000000), true);
	req.send(null);
}

timer=setTimeout('refresh()',5000);
</script>



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

	if((cmin==0) && (csec==0)) document.location.href='fight.php?id=<?=$id?>';

	else 	
	{
		down=setTimeout("DownRepeat()",1000); 
	}
// -- www.cgi.ru -->
		
}		

<?

if($q[Timeleft]>0)
{
?>
Down() ;
<?
}
?>
</script>
<?



	//print "[<a href=\"javascript:GetBattles(1)\">Обновить</a>] ";


	}
}



require($site_path."bottom.php");
?>