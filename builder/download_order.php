<?php

require($_SERVER["DOCUMENT_ROOT"].'/config.php');
require($engine_path."cls/auth/session.php");
	
$order = null;
$id = $_GET["id"];
$filename = $_GET["filename"];
if($id > 0)
{
	$q=select("select m.*,Team(t1.TeamID,t1.Name_$lang) as Team1, Team(t2.TeamID,t2.Name_$lang) as Team2,
			dt.Name_$lang as Tournament,m.TournamentID,dt.ShortName
			from ut_matches m 
			left outer join ut_teams t1 on t1.TeamID=m.TeamID1
			left outer join ut_teams t2 on t2.TeamID=m.TeamID2
			left outer join ut_tournaments t on t.TournamentID=m.TournamentID
			left outer join ut_tournament_types dt on t.TypeID=dt.TypeID
			where m.MatchID='$id'");

	$r =select("select * from ut_orders where TournamentID='$q[TournamentID]' and Tour='$q[Tour]' and TeamID='$auth->team'");

	if($q[TeamID1]==$auth->team) 
	{
	  $order=$q[OrderTeam1];
	  $date=$q[DateOrder1];
	}
	elseif($q[TeamID2]==$auth->team) 
	{
	  $order=$q[OrderTeam2];
	  $date=$q[DateOrder2];
	}
	if($r[OrderFile] && $r[Date]>$date) $order=$r[OrderFile] ;
}
else if($filename)
{
	$res = mysql_query("select OrderFile from ut_orders where name='".$filename."' and TeamID=".$auth->team);
	$data = mysql_fetch_row($res);
	$order = $data[0];
}
else
{
	$res = mysql_query("select Name from ut_orders where TeamID=".$auth->team);
	while($data = mysql_fetch_row($res))
	{
		print "<a href='?filename=$data[0]' >$data[0]</a><br />";
	}
	exit;
}
$res2 = mysql_query("select ShortName from ut_teams where TeamID = ".$auth->team);
if($res2)
{
	$data2 = mysql_fetch_row($res2);
	if($data2 && $order)
	{
		header("Content-type: application/ord");
		header("Content-Disposition: attachment; filename=".$data2[0]."$filename.ord");
			print $order;
	}
	else
	{
		print "error<br>";
		print (!$data2)?"data2<br>".$data2:"order<br>".$order;
	}
}
?>