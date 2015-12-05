<?
require('../../config.php');

require($engine_path."cls/auth/session.php");

unset($er);

if($show!="all")
{

$q=select("select * from ft_battles where (UserID1='$auth->user' or UserID2='$auth->user') order by Date desc");

if($q[0]) {header("Location:/xml/arena/online.php?id=$q[0]");exit;}
else $er='Проведенных Вами боев не найдено. Зайдите в раздел Арена';

}

require($site_path."up.php");

require($site_path."left.php");

if($show!="all")
{

if($er) 
{
	print icon('error',$er);
	$form=new cls_form("gladiators/builder","empty");	
}

}
else
{
	if(!$user) $_GET['user']=$auth->user;

	if($user!=$auth->user) 
	{
		$q=select("select Login from ut_users where UserID='$user'");
		print "<font size=4>История боёв $q[Login]</font><br><br>";
	}
	else 		print "<font size=4>История боёв</font><br><br>";

	$form=new cls_form("arena/arena","userhistory");	
	$form->draw();
}

require($site_path."bottom.php");
?>