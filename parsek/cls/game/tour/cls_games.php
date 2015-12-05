<?



Class cls_games
{
var $league;
var $season;
var $tournament;
var $tour;
var $maxtour;
var $division;
var $reglament;

    function cls_games()
    {
	global $reglament,$tournament,$tour,$auth;

	if(!$tournament) $this->tournament=1;
	else $this->tournament=$tournament;


	if(!$reglament) $this->reglament=$this->maxreglament();
	else $this->reglament=$reglament;

	//$q=select("select ReglamentID,TournamentID from ut_reglaments where (ReglamentID='$this->reglament') order by Tour2 desc");
	//$this->reglament=$q[ReglamentID];

	$q=select("select DivisionID from ut_teams where TeamID='$auth->team'");

	$this->division=$q[0];

	$q=select("select SeasonID from ut_seasons where StartDate>0 order by Num desc limit 0,1");
	$this->season=$q[0];

	if(!$tour) $this->tour=$this->maxtour();
	else $this->tour=$tour;

    }

    function maxreglament()
    {
	$res=runsql("select m.Tour from ut_matches m left outer join ut_reglaments r on r.ReglamentID=m.ReglamentID where r.TournamentID='$this->tournament' and m.Goals1 is not null order by m.Tour desc limit 0,1");
	$r=mysql_fetch_array($res);

	if(!$r[0]) return 0;
	else return $r[0];

    }


    function maxtour()
    {
	$res=runsql("select Tour from ut_matches where ReglamentID='$this->reglament' and Goals1 is not null order by Tour desc limit 0,1");
	$r=mysql_fetch_array($res);

	if(!$r[0]) return 0;
	else return $r[0];

    }

    function DrawTour()
    {
	global $PHP_SELF,$type,$act;

	$res=runsql("select Name_\$lang; as Name,Tour1,Tour2,Reglament from ut_reglaments where TournamentID='$this->tournament' order by Tour1");
	while($r=mysql_fetch_array($res))
	{
		
		if($r[Tour2]-$r[Tour1]>2&&$r[Name]) 
		{
			if($c) print "<br>";
			print "<b>".$r[Name].":</b> ";
		}
		elseif($c) print " | ";

		for($i=$r[Tour1];$i<=$r[Tour2];$i++)
		{
			$tur=TName($i,$r);


			if($i>$r[Tour1]&&$tur) print " | ";

			if($i==$this->tour) print $tur;
			else print "<a href=\"$PHP_SELF?tour=$i\">$tur</a>";

			$t=$tur;
		}

		$c++;
	}
    }

    function TournamentName()
    {
	$res=runsql("select Name_\$lang; as Name from ut_tournaments where TournamentID='$this->tournament'");
	$r=mysql_fetch_array($res);
	return $r[Name];
    }

    function TourName($large)
    {
	$res=runsql("select Name_\$lang; as Name,Tour1,Tour2,Reglament from ut_reglaments where TournamentID='$this->tournament' and (Tour1<=$this->tour and Tour2>=$this->tour) ");
	$r=mysql_fetch_array($res);
	return TName($this->tour,$r,$large);
    }

}

    function GetTourName($r,$large)
    {

	$res=runsql("select Name_\$lang; as Name,Tour1,Tour2,Reglament from ut_reglaments where TournamentID='$r[TournamentID]' and (Tour1<=$r[Tour] and Tour2>=$r[Tour]) ");
	$r1=mysql_fetch_array($res);

	return TName($r[Tour],$r1,$large);
    }

    function TName($i,$r,$large)
    {
	if(!$r[Reglament]) $r[Reglament]=0;

	if($r[Reglament]=="0") $tur=$i-$r[Tour1]+1;
	elseif($r[Reglament]=="3") $tur=$r[Name];
	elseif($r[Reglament]=="4"&&(($i-$r[Tour1])%2==0||$large)) $tur=($i-$r[Tour1])/2+1;
	elseif(($i-$r[Tour1])%2==0||$large)
	{
		if(($r[Tour2]-$r[Tour1])%2!=0) $r[Tour2]++;

		$num=($r[Tour2]-$i);
		if($r[Reglament]==2) $num=round($num/2);
		$t=pow(2,$num); 

		if($t!=1) $tur="1/$t";
		else $tur="финал";

	}

	if($large)
	{
  		if(($r[Reglament]==2||$r[Reglament]==4)&&($i%2!=0)) $tur.=", ".message(14);
  		elseif(($r[Reglament]==2||$r[Reglament]==4)&&($i%2==0)) $tur.=", ".message(15);
	}
	return $tur;
    }

    function TournamentName($tournament)
    {
	$res=runsql("select Name_\$lang; as Name from ut_tournaments where TournamentID='$tournament'");
	$r=mysql_fetch_array($res);
	return $r[Name];
    }
?>