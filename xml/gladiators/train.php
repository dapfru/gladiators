<?
require('../../config.php');

$form_width=170;


require($engine_path."cls/auth/session.php");

$act="select";

$type="gladiators/train";

if($user&&checkpriv("control/support","")) setvar('user',$user);
else setvar('user',$auth->user);

if($step)
{

	lock_rst($auth->user);

	$do=0;

	$auth->rst=update_exp($auth->rst);
	$auth->rst=update_health($auth->rst);

	foreach($_POST['GladiatorID'] as $k=>$v)
	{

if(!(get_injury($auth->rst[Gladiators][$v][Injury],$auth->rst[Date])>0))
{
		$_POST['NewPercentTrain'][$k]=round($_POST['NewPercentTrain'][$k]);
		if($_POST['NewPercentTrain'][$k]>=0&&$_POST['NewPercentTrain'][$k]<=100&&is_numeric($_POST['NewPercentTrain'][$k]))
		{
			if($auth->rst[Gladiators][$v][PercentTrain]!=$_POST['NewPercentTrain'][$k])
			{
				$auth->rst[Gladiators][$v][PercentTrain]=$_POST['NewPercentTrain'][$k];
				$do=1;
			}
		}
		else $error=1;
}
	}

	if(!$error&&$do) 
	{
		write_rst($auth->user,$auth->rst);
	}

	unlock_rst($auth->user);

	header("Location:train.php?form_ok=1");
}

require($site_path."up.php");


$res=runsql("select f.Name_$lang,s.Level,s.Date,s.StaffID from 
fn_staff_info f left outer join tm_staff s 
on s.StaffID=f.StaffID  and s.UserID='$auth->user' 
 where  (f.StaffID=1 or f.StaffID=3 or f.StaffID=5) and f.Level=1 order by f.StaffID");

$level=0;

while($q=mysql_fetch_array($res))
{
	if($q[1]) 
	{
		if($level) $leftcontent.="<img src=/images/hr2.gif width=180 height=10><br>";

		$leftcontent.="<img src=\"/images/marker3.gif\" width=11 height=11/> <a href=/xml/residence/staff.php?id=$q[3]>$q[0]-$q[1]</a><br>";


		$level=1;
	}
	
}

	if(!$level) $leftcontent.=icon('green','Для начала тренировок, необходимо <a href=/xml/residence/staff.php?id=1>нанять тренера</a>');
	else 
	{
		$leftcontent="<b>Нанятые тренеры</b><br><br>".$leftcontent;
	}

require($site_path."left.php");


?>

	<script src="slider.js"></script>
<?



print "<font size=4pt>$form->title</font><br><br>";

print "<a name=\"bottom\"></a>";

$form->Draw();








require($site_path."bottom.php");


if($act=="select"||$act=="vip")
{
?>
<script>
	var bgImage = new Image(100,18);
	bgImage.src = "back.gif";
	var btImage = new Image(10,18);
	btImage.src = "slider.gif";
	var inputs = document.getElementsByTagName("input");

	for(var i=0; i<inputs.length; i++)
	{
		if(inputs[i].className == "slider")
		{
			MakeSlider(inputs[i],bgImage,btImage,0,100,"%(0:100)");


		}

	}


</script>
<?
}



?>
<script>window.onload=window.location.href="#bottom"</script>