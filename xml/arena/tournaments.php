<?
require('../../config.php');

require($engine_path."cls/auth/session.php");

$type="arena/tournaments";
if(!$act) $act="select";




function first_schedule($tournament,$members,$numplayers)
{
	global $stage,$id,$fights,$num;

	$id=$tournament;

	$q=select("select * from ft_tournaments where TournamentID='$id'");
	if($q[StatusID]!=0) return 0;

	if($members+1!=$numplayers) return 0;


	$r=select("select * from ft_stages where TournamentTypeID=$q[TournamentTypeID]  and Tour1=1 limit 0,1");
	$res2=runsql("select * from ft_tournament_members where TournamentID='$id' order by rand()");

	for($k=1;$k<=$numplayers;$k++)
	{
		$r2=mysql_fetch_array($res2);
		$users[$k]=$r2[UserID];
	}



	if($r[TypeID]==0)
	{

		for($k=1;$k<=$numplayers;$k++)
		{
			runsql("update ft_tmp_agreements set UserID1='$users[$k]',
Login1=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$users[$k]') 
 where TournamentID='$id' and Tour=1 and Pair1='$k'");

			runsql("update ft_tmp_agreements set UserID2='$users[$k]',
Login2=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$users[$k]') 
 where TournamentID='$id' and Tour=1 and Pair2='$k'");
		}
	}
	else
	{

		for($k=1;$k<=$numplayers;$k++)
		{
			runsql("update ft_tmp_agreements set UserID1='$users[$k]',
Login1=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$users[$k]') 
 where TournamentID='$id' and Stage=1 and Pair1='$k'");

			runsql("update ft_tmp_agreements set UserID2='$users[$k]',
Login2=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$users[$k]') 
 where TournamentID='$id' and Stage=1 and Pair2='$k'");

			runsql("update ft_groups set UserID='$users[$k]',Login=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$users[$k]') where TournamentID='$id' and Stage=1 and Pair='$k'");
		}
	}


	runsql("delete from ft_agreements where TournamentID='$id'");

	runsql("insert into ft_agreements
(UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,Approved,StatusID,Date,Login1,Login2) 
(select UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID ,Stage,Tour,Fight,Pair,NumFights,StageTypeID, 1,2,unix_timestamp(),Login1,Login2
from ft_tmp_agreements where TournamentID='$id' and Tour=1 and Fight=1)");

	runsql("update ft_tournaments set StatusID=1 where TournamentID='$id'");


}

$q=select("select m.TournamentID from ft_tournament_members m 
join ft_tournaments t on m.TournamentID=t.TournamentID and t.StatusID<>2 and m.StatusID=0 where m.UserID='$auth->user'");
if($q[0]) $mytournament=$q[0];

//if($auth->user==20) $mytournament=42;

//$mytournament=42;





require($site_path."up.php");

require($site_path."left.php");


if(!$id&&!$return&&$mytournament) //header("Location:/xml/arena/tournaments.php?id=$mytournament");
{
	?>
	<script>document.location.href='/xml/arena/tournaments.php?id=<?=$mytournament;?>';</script>
	<?
	exit;
}



if($form_ok&&$act=="cancel") unset($id); 

if($form_ok) $form=new cls_form($type,"select");

$res=$form->sqlres;



while($r=mysql_fetch_array($res))
{

print "<table border=0 width=100% bordercolor=#78746C bgcolor=#78746C cellpadding=4 cellspacing=1>";

print "<tr bgcolor=\"#515E64\">";

if(file_exists($site_path."images/ft_tournament_types/small/$r[TournamentTypeID].jpg")) print "<td rowspan=2 bgcolor=#3B484C valign=top><a href=$PHP_SELF?id=$r[TournamentID]><img src=\"".$site_url."images/ft_tournament_types/small/$r[TournamentTypeID].jpg\" border=0></a></td>";

print "<td height=10px  bgcolor=#3B484C><b><a href=tournaments.php?id=$r[0]>$r[Name]</a></td>";

print "<tr bgcolor=\"#515E64\"><td valign=top height=50px width=100%>";

if($r[Description]) print "<i>$r[Description]</i><br><br>";

if(!$id)
{
print "<b>";

if($r[StatusID]==1) print "Турнир начался";
elseif($r[StatusID]==2) print "Турнир завершен";
print "</b>";

}

if($r[NumPlayers]!=$r[Players]&&$r[StatusID]==0) print "Участников: $r[Players] из $r[NumPlayers]";
elseif($id) print "Участники";

if($id&&$r[Players])
{
	print ":<br>";
	$res1=runsql("select * from ft_tournament_members where TournamentID='$r[TournamentID]'");
	$str='';
	while($r1=mysql_fetch_array($res1))
	{	
		$str.= "<a href=/users/$r1[UserID]>";
		if($r1[StatusID]==0) $str.="<b>";
		$str.="$r1[Login]</b></a>, ";
	}
	print substr($str,0,strlen($str)-2);
}

if(!$mytournament&&$r[Players]<$r[NumPlayers]&&$r[StatusID]==0) print "<br><a href=tournaments.php?id=$r[TournamentID]&act=join&step=1><b>[присоединиться]</b></a>";
elseif($mytournament==$r[0]&&$r[Players]<$r[NumPlayers]&&$r[StatusID]==0) print "<br><a href=tournaments.php?id=$r[TournamentID]&act=cancel&step=1><b>[отказаться от участия]</b></a>";

print "<br><br>";

print $r[Reglament];

if(!$id) print "<div align=right><a href=tournaments.php?id=$r[TournamentID]>подробнее..</a></div>";

print "</td></tr>";


print "</table><br>";


if($mytournament==$r[0]&&$r[StatusID]==1&&$id)
{

	$q=select("select RecordID,UserID1,UserID2 from ft_agreements where TournamentID='$r[TournamentID]' and (UserID1='$auth->user' or UserID2='$auth->user')");
	if($q[0])
	{
		if($q[UserID1]==$auth->user) $op=$q[UserID2];
		else $op=$q[UserID1];

		if($op) $q1=select("select UserID,Login from ut_users where UserID='$op'");

		if($q1[0]) print icon('green',"Ваш следующий соперник - <a href=/users/$q1[0]>$q1[1]</a>. <a href=/builder/?id=$q[0]>Перейти в подготовку к бою</a>");
	}
}


}

pages();




if($id) $res1=runsql("select t.*,if(t.Login1='',u1.Login,t.Login1) User1,if(t.Login2='',u2.Login,t.Login2) User2 
from ft_tmp_agreements t 
left outer join ut_users u1 on u1.UserID=t.UserID1
left outer join ut_users u2 on u2.UserID=t.UserID2
where t.TournamentID='$id' and t.Fight=1 order by t.Stage,if(t.StageTypeID=0,t.Tour,t.Pair),if(t.StageTypeID=1,t.Tour,t.Pair)");

if($id&&mysql_num_rows($res1))
{

?>
<script>

document.write("<scr"+"ipt lang"+"uage=\"Java"+"Script\" src=\"load/jshttp.js\"></scr"+"ipt>");

function GetTournamentFights(tournament,tour,user) {
	if(user==0) return '';

	document.getElementById('fights').innerHTML = "Загрузка...";
	var req = new Subsys_JsHttpRequest_Js();
	req.onreadystatechange = function() {
		
		if (req.readyState == 4) {
			if (req.responseJS) {
				if(req.responseText||type) document.getElementById('fights').innerHTML = req.responseText;
			}
		}
	}
	req.open('POST', 'get_tournament_fights.php?tournament='+tournament+'&tour='+tour+'&user='+user, true);
	req.send(null);
}

function GetTournamentGroups(tournament,stage,group) {
	document.getElementById('fights').innerHTML = "Загрузка...";
	var req = new Subsys_JsHttpRequest_Js();
	req.onreadystatechange = function() {
		
		if (req.readyState == 4) {
			if (req.responseJS) {
				if(req.responseText||type) document.getElementById('fights').innerHTML = req.responseText;
			}
		}
	}
	req.open('POST', 'get_tournament_groups.php?tournament='+tournament+'&stage='+stage+'&group='+group, true);
	req.send(null);
}
</script>
<?



print "<center><div id='fights'>&nbsp;</div></center><table border=0  cellspacing=0 cellpadding=0>";

	$tour=0;
	$i=0;
	$j=0;

	$stagetype='';
	
	$tur=0;

	$numplayers=0;

	while($r=mysql_fetch_array($res1))
	{	

//|| $stage!=$r[Stage]
		if($r[Tour]!=$tour&&$tour&&($stagetype!=1 || $r[StageTypeID]!=1 || $stage!=$r[Stage])) {print "</table>";$i++;}

		$h=30*pow(2,$i);
		$h2=$h;
		if($r[Tour]!=$tour) $h2=20;

		if($r[StageTypeID]==1&&$tur==0&&$r[Stage]>1&&($stage==$r[Stage]||!$stage))
		{

		$h=30*pow(2,$i-1);
		$h2=$h;

		$h2=50;

			print "<td valign=middle><table width=20px border=0 cellspacing=0 cellpadding=3>";

			for($j=1;$j<=$numplayers;$j++)
			{


				print "<tr><td style='border-bottom:1px solid #ffffff;' height='$h2' valign=bottom>&nbsp;</td></tr>";
				print "<tr><td style='' height='$h' valign=bottom>&nbsp;</td></tr>";

				$h2=$h;
			}

			print "</table></td>";

		}

		if($r[Tour]!=$tour&&($r[StageTypeID]!=1 || $r[StageTypeID]!=$stagetype || $stage!=$r[Stage])) 
		{
			print "<td valign=middle><table width=100px border=0 cellspacing=0 cellpadding=3>";
			$numplayers=0;
		}

		if($tur>5) $tur=0;


		if($r[StageTypeID]==1) $tur++;
		else $tur=0;




		if(!$r[User1]) $r[User1]="&nbsp;";
		if(!$r[User2]) $r[User2]="&nbsp;";



if($r[StageTypeID]==1)
{

$h2=$h;

	if($tur==1)
	{

		print "<tr><td class=header style='border:1px solid #ffffff;cursor:pointer;'

onmouseover=\"this.style.backgroundColor='#3B484C'\"onmouseout=\"this.style.backgroundColor='#687174'\" 
onclick=\"GetTournamentGroups('$r[TournamentID]','$r[Stage]','$r[Pair]')\"

height='20' align=center><b>Группа $r[Pair]</td></tr>";

	}


	$h2=round($h/1.5) ;


	print "<tr  align=center><td 
onmouseover=\"this.style.backgroundColor='#3B484C'\"onmouseout=\"this.style.backgroundColor=''\" 
onclick=\"GetTournamentFights('$r[TournamentID]','$r[Tour]','$r[UserID1]')\"
style='cursor:pointer;border-left:1px solid #ffffff;border-right:1px solid #ffffff;";
	

	print "border-bottom:1px solid #ffffff;";	
	print "' height='$h2' ><nobr>$r[User1] - $r[User2]</td></tr>";
}
else
{
	$numplayers++;

		print "<tr><td style='border-bottom:1px solid #ffffff;' height='$h2' valign=bottom>$r[User1]</a></td></tr>";
		print "<tr><td 

onmouseover=\"this.style.backgroundColor='#3B484C'\"
onmouseout=\"this.style.backgroundColor=''\" 
onclick=\"GetTournamentFights('$r[TournamentID]','$r[Tour]','$r[UserID1]')\"
valign=bottom height='$h' style='cursor:pointer;border-bottom:1px solid #ffffff;border-right:1px solid #ffffff;'>$r[User2]</a></td></tr>";
}	
		$stagetype=$r[StageTypeID];
		$stage=$r[Stage];
	
		$tour=$r[Tour];
	}
		$j++;

print "</table>";


			print "<td valign=middle><table border=0 cellspacing=0 cellpadding=3>";

$q=select("select UserID,Login from ft_winners where TournamentID='$id'");

if(!$q[1]) $user="&nbsp;";
else $user="<a href=/users/$q[0]>$q[1]</a>";

print "<tr><td style='border-bottom:1px solid #ffffff;' height='$h2' valign=bottom>$user</td></tr>";

print "</table></table>";


}


if($id) print "<div align=right><a href=$PHP_SELF?id=$id>[обновить]</a> <a href=$PHP_SELF?return=1>[вернуться к списку]</a> <img src=\"/images/marker3.gif\" width=11 height=11 border=0></div><br>";



require($site_path."bottom.php");
?>