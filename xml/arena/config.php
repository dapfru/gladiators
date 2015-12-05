<?
unset($leftcontent);

$REMORE_ADDR=$_SERVER['REMOTE_ADDR'];
$PHP_SELF=$_SERVER['PHP_SELF'];
$QUERY_STRING=$_SERVER['QUERY_STRING'];

if(strlen($_REQUEST[lang])!=3&&$_REQUEST[lang] || !$lang) 
{
	$lang="rus";
	$_REQUEST[lang]="rus";
}


require("config_paths.php");

$months['rus']=array('месяц','января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
$months['eng']=array('Month', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$months['ger']=array('Monat', 'Januar', 'Februar', 'M&auml;rz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');


$PHP_SELF=$_SERVER['PHP_SELF'];
$QUERY_STRING=$_SERVER['QUERY_STRING'];

$project_name="gladiators";

function guildlogo($guild,$link)
{

	$str="<img src=/images/gd_guilds/small/$guild.jpg align=absmiddle border=0>";

	if($link) $str="<a href=/guilds/$guild>$str</a>";

	return $str;
}

function username($r,$link)
{
	if($link) $login="<a href=/users/$r[UserID]>".$r[Login]."</a>";
	else $login=$r[Login];

	if($r[GuildID]&&$r[GuildStatusID]==1) $login="<a href=/guilds/$r[GuildID]><img src=/images/gd_guilds/small/$r[GuildID].jpg align=absmiddle border=0 ></a> ".$login;
	if($r[Level]) $login=$login." [$level]";
	return $login;
}

function deleteimage($image,$act)
{
	global $site_path;

	if($act&&strstr($image,".jpg")) unlink($site_path."images/".$image);
}



function getfile($fname)
{
	$file=fopen($fname,"r");
	$str=fread($file,filesize($fname));
	fclose($file);
	return pack("l",strlen($str)).$str;
}





function make_schedule($tournament)
{
	global $stage,$id,$fights,$num;


	$id=$tournament;



	$q=select("select * from ft_tournaments where TournamentID='$id'");
	if($q[StatusID]!=0) return 0;

	$numplayers=$q[NumPlayers];

	runsql("delete from ft_tmp_agreements where TournamentID='$id'");
	runsql("delete from ft_groups where TournamentID='$id'");
	

	$res=runsql("select * from ft_stages where TournamentTypeID=$q[TournamentTypeID]  order by Tour1");

	if(!mysql_num_rows($res)) exit;

	$stage=0;

	while($r=mysql_fetch_array($res))
	{
		$stage++;

		$res1=runsql("select * from ft_reglaments where StageID='$r[StageID]' order by Num");	
		$numfights=mysql_num_rows($res1);
		$j=1;
		while($r1=mysql_fetch_array($res1))
		{
			$reg[$j]=$r1;
			
			$j++;
		}

//выборка пользователей 1

		//начальная выборка пользователей
		if($r[Tour1]==1)
		{
			$res2=runsql("select * from ft_tournament_members where TournamentID='$id' order by rand()");

			for($k=1;$k<=$numplayers;$k++)
			{
				$r2=mysql_fetch_array($res2);
				$users[$k]=$r2[UserID];
				//$users[$k]=$k;
			}
		}
		


		for($i=$r[Tour1];$i<=$r[Tour2];$i++)
		{



if($r[TypeID]==0&&($prevtype==$r[TypeID] || !$prevtype))
{

	$p=1;

	for($k=1;$k<=$numplayers;$k=$k+2)
	{
		addfights(0,$p++,$i,$numfights,$reg,$k,$k+1,'','');
	}

}
elseif($r[TypeID]==0&&$prevtype!=$r[TypeID])
{

	$p=1;

	for($k=1;$k<=$numplayers;$k=$k+2)
	{
		$g1=$k;
		$g2=$k+1;

		if($g1>$numplayers/2) $g1=$numplayers-$g1+1;
		if($g2>$numplayers/2) $g2=$numplayers-$g2+1;

		addfights(0,$p++,$i,$numfights,$reg,$g1,$g2,1,2);
	}

}
elseif($i==$r[Tour1]&&$r[TypeID]==1&&(!$prevtype))
{
	$numgroups=$numplayers/4;
	for($g=1;$g<=$numgroups;$g++)
	{

		$k=($g-1)*4;

		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair,Place) values('$stage','$id','$g','".($k+1)."','')");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair,Place) values('$stage','$id','$g','".($k+2)."','')");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair,Place) values('$stage','$id','$g','".($k+3)."','')");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair,Place) values('$stage','$id','$g','".($k+4)."','')");

		addfights(1,$g,$i,$numfights,$reg,$k+2,$k+1,'','');
		addfights(1,$g,$i,$numfights,$reg,$k+3,$k+4,'','');

		addfights(1,$g,$i+1,$numfights,$reg,$k+1,$k+4,'','');
		addfights(1,$g,$i+1,$numfights,$reg,$k+3,$k+2,'','');

		addfights(1,$g,$i+2,$numfights,$reg,$k+4,$k+2,'','');
		addfights(1,$g,$i+2,$numfights,$reg,$k+1,$k+3,'','');


	}
}
elseif($i==$r[Tour1]&&$r[TypeID]==1&&($prevtype==$r[TypeID]))
{
	$numgroups=$numplayers/4;
	for($g=1;$g<=$numgroups;$g++)
	{

		$k=($g-1)*4;

		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair,Place) values('$stage','$id','$g','".($k+1)."',1)");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair,Place) values('$stage','$id','$g','".($k+2)."',1)");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair,Place) values('$stage','$id','$g','".($k+1)."',2)");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair,Place) values('$stage','$id','$g','".($k+2)."',2)");

		addfights(1,$g,$i,$numfights,$reg,$k+2,$k+1,'2','1');
		addfights(1,$g,$i,$numfights,$reg,$k+1,$k+2,'2','1');

		addfights(1,$g,$i+1,$numfights,$reg,$k+1,$k+1,'1','2');
		addfights(1,$g,$i+1,$numfights,$reg,$k+2,$k+2,'1','2');

		addfights(1,$g,$i+2,$numfights,$reg,$k+1,$k+2,'2','2');
		addfights(1,$g,$i+2,$numfights,$reg,$k+1,$k+2,'1','1');


	}
}
elseif($i==$r[Tour1]&&$r[TypeID]==1&&$prevtype!=$r[TypeID])
{
	$numgroups=$numplayers/4;
	for($g=1;$g<=$numgroups;$g++)
	{

		$k=($g-1)*4;

		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair) values('$stage','$id','$g','$k+1')");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair) values('$stage','$id','$g','$k+2')");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair) values('$stage','$id','$g','$k+3')");
		runsql("insert into ft_groups(Stage,TournamentID,Name,Pair) values('$stage','$id','$g','$k+4')");

		addfights(1,$g,$i,$numfights,$reg,$k+1,$k+2,'','');
		addfights(1,$g,$i,$numfights,$reg,$k+3,$k+4,'','');

		addfights(1,$g,$i+1,$numfights,$reg,$k+4,$k+1,'','');
		addfights(1,$g,$i+1,$numfights,$reg,$k+2,$k+3,'','');

		addfights(1,$g,$i+2,$numfights,$reg,$k+2,$k+4,'','');
		addfights(1,$g,$i+2,$numfights,$reg,$k+1,$k+3,'','');

	}
}


			if($r[TypeID]==0) $numplayers=$numplayers/2;
			$prevtype=$r[TypeID];
		}

			if($r[TypeID]==1) $numplayers=$numplayers/2;
	}

}


function addfights($typeid,$k,$i,$numfights,$reg,$p1,$p2,$place1,$place2)
{
	global $id,$stage,$fights,$num;

		for($j=1;$j<=$numfights;$j++)
			{
				$r1=$reg[$j];

if($r1[TypeID]==2) $timeout=5;
else $timeout=10;


//print "<b>".($num+1)."</b> Tur $i) Para $k) Boy $j) <br><br>";

$sql="insert into ft_tmp_agreements(TournamentID,Stage,Tour,Fight,Pair,UserID1,UserID2,TypeID,ExtraGlad,
LimitGlad,LimitSkl,Timeout,Approved,Date,StatusID, Pair1,Pair2,Place1,Place2,NumFights,StageTypeID) 
values ('$id','$stage','$i','$j','$k','$user1','$user2','$r1[TypeID]','$r1[ExtraGlad]','$r1[GladLimit]','$r1[SklLimit]',
'$timeout',0,unix_timestamp(),0,'$p1','$p2','$place1','$place2','$numfights','$typeid')";

runsql($sql);

$fights[$i][$j][$k]=$num++;

			}
}


function path($id)
{
	$n1=floor($id/1000000); 
	$n2=$id % 1000000; 
	$n2=floor($n2/10000); 
	$n3=$id % 10000; 
	$n3=floor($n3/100);
	return "$n1/$n2/$n3";
}


function gampath($id)
{
	global $site_path;

	return $site_path."files/gam/".path($id);
}

function ordpath($id)
{
	global $site_path;

	return $site_path."files/testord/".path($id);
}



function generategame($id)
{
	global $site_path,$secpass,$k,$serialized;

	$path=gampath($id);

	if(!file_exists($path)) mkdir_r($path);

	$fname=$path."/".$id.".gam";

	$file=fopen($fname,"w");


	//$fname=$site_path."files/gam/".$id.".gam";
	//$file=fopen($fname,"w");


	$q=mysql_query("select Date+60*Timeout Date,UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,TournamentID from ft_agreements where RecordID='$id'");
	$q=mysql_fetch_array($q,1);
	$gam=$q;
	$gam[Date]=mktime();
	$gam[id]=$id;

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



	fclose($file);

	$res=exec("/var/www/gladiators_admin/gladcore $fname");
			
	$user1=$q[UserID1];
	$user2=$q[UserID2];

	$ar=unserialize($res);

	lock_rst($user1);
	lock_rst($user2);

	$rst1=read_rst($user1);
	$rst2=read_rst($user2);

	$score1=reset($ar[Score]);
	$score2=next($ar[Score]);

	if($score1>$score2) 
	{
		$rst1=short_transfer_money($rst1,$ar[Money],1,$user1,26,$id);
		$rst1[Win]++;
		$rst2[Lose]++;
		$winner=$user1;
	}
	elseif($score1<$score2) 	
	{
		$rst2=short_transfer_money($rst2,$ar[Money],1,$user2,26,$id);
		$rst2[Win]++;
		$rst1[Lose]++;
		$winner=$user2;
	}
	else 
	{
		$rst1[Tie]++;
		$rst2[Tie]++;
		$rst1=short_transfer_money($rst1,round($ar[Money]/2),1,$user1,26,$id);
		$rst2=short_transfer_money($rst2,round($ar[Money]/2),1,$user2,26,$id);
	}

	runsql("insert into ft_battles(RecordID,UserID1,UserID2,Date,TypeID,ExtraGlad,LimitGlad,LimitSkl,
TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,WinnerID,ScorePoints1,ScorePoints2,Login1,Login2
) 
(select RecordID,UserID1,UserID2,unix_timestamp(),TypeID,ExtraGlad,LimitGlad,LimitSkl,
TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,'$winner','$scorepoints1','$scorepoints2',Login1,Login2
from ft_agreements where RecordID='$id')");

	//runsql("update ft_battles b set Login1=(select u.Login from ut_users u where u.UserID=b.UserID1) where b.RecordID='$id'");
	//runsql("update ft_battles b set Login2=(select u.Login from ut_users u where u.UserID=b.UserID2) where b.RecordID='$id'");

	runsql("delete from ft_agreements where RecordID='$id'");

$serialized=$rst1[Gladiators];
foreach($rst1[Gladiators] as $k=>$v)
{

		if(!$rst1[Gladiators][$k][PercentTrain]) $rst1[Gladiators][$k][PercentTrain]=0;
		$coef=10+(100-$rst1[Gladiators][$k][PercentTrain])*30/100;

		$rst1[Gladiators][$k][Stamina]=strval(round(intval($rst1[Gladiators][$k][Stamina]+$coef*(mktime()-$rst1[Date])/3600),2));



		if($rst1[Gladiators][$k][Morale]!=0) 
		{



			$mor=intval(round($rst1[Gladiators][$k][Morale]-($rst1[Gladiators][$k][Morale])/abs($rst1[Gladiators][$k][Morale])*(mktime()-$rst1[Date])/3600));
		
			if(($mor)*($rst1[Gladiators][$k][Morale])<0) $rst1[Gladiators][$k][Morale]=0;
			else $rst1[Gladiators][$k][Morale]=$mor;
		}

		//$rst1[Gladiators][$k][Injury]=intval(ceil($rst1[Gladiators][$k][Injury]-(mktime()-$rst1[Date])/3600));
		//if($rst1[Gladiators][$k][Injury]<0) $serialized[$k][Injury]=0;

		$exp=expgained($rst1);

		if($exp)
		{
			$rst1[Gladiators][$k][Exp]=strval(round($rst1[Gladiators][$k][Exp]+$exp,2));
			$rst1[Gladiators][$k][NextTrain]=strval(round($exp+$rst1[Gladiators][$k][NextTrain],2));
		}

}
$rst1[TrainDate]=mktime();


$serialized=$rst2[Gladiators];
foreach($rst2[Gladiators] as $k=>$v)
{

		if(!$rst2[Gladiators][$k][PercentTrain]) $rst2[Gladiators][$k][PercentTrain]=0;
		$coef=10+(100-$rst2[Gladiators][$k][PercentTrain])*30/100;

		$rst2[Gladiators][$k][Stamina]=strval(round(intval($rst2[Gladiators][$k][Stamina]+$coef*(mktime()-$rst2[Date])/3600),2));

		if($rst2[Gladiators][$k][Morale]!=0) 
		{


			$mor=intval(round($rst2[Gladiators][$k][Morale]-($rst2[Gladiators][$k][Morale])/abs($rst2[Gladiators][$k][Morale])*(mktime()-$rst2[Date])/3600));
		
			if(($mor)*($rst2[Gladiators][$k][Morale])<0) $rst2[Gladiators][$k][Morale]=0;
			else $rst2[Gladiators][$k][Morale]=$mor;
		}

		//$rst2[Gladiators][$k][Injury]=intval(ceil($rst2[Gladiators][$k][Injury]-(mktime()-$rst2[Date])/3600));
		//if($rst2[Gladiators][$k][Injury]<0) $serialized[$k][Injury]=0;

		$exp=expgained($rst2);
		if($exp)
		{
			$rst2[Gladiators][$k][Exp]=strval(round($rst2[Gladiators][$k][Exp]+$exp,2));
			$rst2[Gladiators][$k][NextTrain]=strval(round($exp+$rst2[Gladiators][$k][NextTrain],2));
		}

}
$rst2[TrainDate]=mktime();

foreach($ar[Gladiators] as $k=>$v)
{

	if($v[Stamina]<0) $v[Stamina]=0;

	if($rst1[Gladiators][$k]) 
	{

		if($winner==$user1) $rst1[Gladiators][$k][Win]++;
		elseif($winner==$user2) $rst1[Gladiators][$k][Lose]++;

		$rst1[Gladiators][$k][Morale]=intval($v[Morale]);
		//$rst1[Gladiators][$k][Injury]=intval($v[Injury]);

		$rst1[Gladiators][$k][Stamina]=round($v[Stamina],2);

		if($v[Injury]) 
		{
			$rst1[Gladiators][$k][PercentTrain]=0;
			$rst1[Gladiators][$k][Stamina]=intval(-40*$v[Injury]);
		}

		$rst1[Gladiators][$k][Exp]=strval(round($rst1[Gladiators][$k][Exp]+$v[Exp],3));


	}
	elseif($rst2[Gladiators][$k]) 
	{

		if($winner==$user2) $rst2[Gladiators][$k][Win]++;
		elseif($winner==$user1) $rst2[Gladiators][$k][Lose]++;

		$rst2[Gladiators][$k][Morale]=intval($v[Morale]);
		//$rst2[Gladiators][$k][Injury]=intval($v[Injury]);

		$rst2[Gladiators][$k][Stamina]=round($v[Stamina],2);

		if($v[Injury]) 
		{
			$rst2[Gladiators][$k][PercentTrain]=0;
			$rst2[Gladiators][$k][Stamina]=intval(-40*$v[Injury]);
		}

		$rst2[Gladiators][$k][Exp]=strval(round($rst2[Gladiators][$k][Exp]+$v[Exp],3));

	}
}

$rst1[Date]=mktime();
$rst2[Date]=mktime();

write_rst($user1,$rst1);
write_rst($user2,$rst2);

unlock_rst($user1);
unlock_rst($user2);

	if($q[TournamentID]) next_schedule($id);


			}
}


function next_schedule($id)
{
	//выбираем описание текущего боя------------------
	$q=select("select * from ft_battles where RecordID='$id'");

	//все бои этой пары (или двух пар в группе) для определения числа побед---------------
	$res=runsql("select * from ft_battles where TournamentID='$q[TournamentID]' and Tour='$q[Tour]' and Pair='$q[Pair]'");
	while($r=mysql_fetch_array($res))
	{
		$scorepoints[$r[UserID1]]+=$r[ScorePoints1];
		$scorepoints[$r[UserID2]]+=$r[ScorePoints2];

		if($r[WinnerID]==$r[UserID1]) {$score1[$r[UserID1]]++;$score2[$r[UserID2]]++;}
		elseif($r[WinnerID]==$r[UserID2]) {$score1[$r[UserID2]]++;$score2[$r[UserID1]]++;}
	}	

	//есть ли победитель в этой паре---------------
	if($score1[$q[UserID1]]>=ceil($q[NumFights]/2)) {$winner=$q[UserID1];$loser=$q[UserID2];}
	elseif($score1[$q[UserID2]]>=ceil($q[NumFights]/2)) {$winner=$q[UserID2];$loser=$q[UserID1];}

	if($winner)
	{
//print "Победитель определен<br>";

		if($q[StageTypeID]==0)
		{
			//в плейофф-------------------

			runsql("update ft_tournament_members set StatusID=1 where TournamentID='$q[TournamentID]' and UserID='$loser'");

			//следующая стадия---------------
			$u=select("select * from ft_tmp_agreements where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and (Pair1='$q[Pair]' or Pair2='$q[Pair]')");

			//проверка на окончание турнира---------------
			if(!$u[0]) 
			{
				runsql("insert into ft_winners(TournamentID,UserID,Date,Login) values('$q[TournamentID]','$winner',unix_timestamp(),(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$winner'))");
				runsql("update ft_tournaments set StatusID=2 where TournamentID='$q[TournamentID]';");
			}
			else
			{

				if($u[StageTypeID]==0)	
				{

					//обновляем следующий этап------------------------
					runsql("update ft_tmp_agreements set UserID1='$winner',
Login1=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$winner') 
where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Pair1='$q[Pair]'");

					runsql("update ft_tmp_agreements set UserID2='$winner',
Login2=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$winner') 
 where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Pair2='$q[Pair]'");

				}

				//если оба соперника - добавляем бой -------------------------------
				if($u[StageTypeID]==0&&($u[UserID1]>0||$u[Pair1]==$q[Pair])&&($u[UserID2]>0||$u[Pair2]==$q[Pair])) 
				{

					runsql("insert into ft_agreements
(UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,Approved,StatusID,Date,Login1,Login2) 
(select UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID ,Stage,Tour,Fight,Pair,NumFights,StageTypeID, 1,2,unix_timestamp(),Login1,Login2
from ft_tmp_agreements where RecordID='$u[RecordID]' and StatusID=0)");

					runsql("update ft_tmp_agreements set StatusID=1 where RecordID='$u[RecordID]' and StatusID=0");
				}
				elseif($u[StageTypeID]==1) 
				{

				//обновляем следующий этап------------------------
				runsql("update ft_tmp_agreements set UserID1='$winner',
Login1=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$winner') 
 where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and Pair1='$q[Pair]'");

				runsql("update ft_tmp_agreements set UserID2='$winner',
Login2=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$winner') 
 where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and Pair2='$q[Pair]'");


					//обновляем группу, куда выходит победитель--------------------
					runsql("update ft_groups set UserID='$winner',Login=(select Login from ut_users where UserID='$winner') where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and Pair='$q[Pair]'");				


					runsql("insert into ft_agreements
(UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,Approved,StatusID,Date,Login1,Login2) 
(select UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID ,Stage,Tour,Fight,Pair,NumFights,StageTypeID, 1,2,unix_timestamp(),Login1,Login2
from ft_tmp_agreements where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and ((UserID1='$winner' and UserID2>0) or (UserID2='$winner' and UserID1>0)) and StatusID=0)");

					runsql("update ft_tmp_agreements set StatusID=1 where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and ((UserID1='$winner' and UserID2>0) or (UserID2='$winner' and UserID1>0)) and StatusID=0");
				}

			}


		}
		elseif($q[StageTypeID]==1)
		{
			//в группе-------------------
			$finished=1;
			$i=1;

			$w1=0;
			$w2=0;

			if($winner==$q[UserID1]) $w1=1;
			elseif($winner==$q[UserID2]) $w2=1;

			runsql("update ft_groups set Fights=Fights+1,Tour='$q[Tour]',Points=Points+'$w1',ScorePoints=ScorePoints+'".$scorepoints[$q[UserID1]]."',Score1=Score1+'".$score1[$q[UserID1]]."',Score2=Score2+'".$score2[$q[UserID1]]."' where TournamentID='$q[TournamentID]' and Stage='$q[Stage]' and UserID='$q[UserID1]' and (Tour='0' or '$q[Tour]'>Tour)");
			runsql("update ft_groups set Fights=Fights+1,Tour='$q[Tour]',Points=Points+'$w2',ScorePoints=ScorePoints+'".$scorepoints[$q[UserID2]]."',Score1=Score1+'".$score1[$q[UserID2]]."',Score2=Score2+'".$score2[$q[UserID2]]."' where TournamentID='$q[TournamentID]' and Stage='$q[Stage]' and UserID='$q[UserID2]' and (Tour='0' or '$q[Tour]'>Tour)");
	
			$res=runsql("select * from ft_groups where TournamentID='$q[TournamentID]' and Stage='$q[Stage]' and Name='$q[Pair]' order by Points desc, Score1-Score2 desc, ScorePoints desc, rand($q[TournamentID]*$q[Stage]*$q[Pair])");	
			while($r=mysql_fetch_array($res))
			{
				if($r[Fights]!=3) $finished=0;
				$place[$i]=$r[UserID];
				$i++;
			}

			//если группа завершена-----------------
			if($finished)
			{
//print "Группа завершена<br>";
				runsql("update ft_groups set Finished=1 where TournamentID='$q[TournamentID]' and Stage='$q[Stage]' and Name='$q[Pair]'");

				//следующая стадия

	
				$u=select("select * from ft_tmp_agreements where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and (Pair1='$q[Pair]' or Pair2='$q[Pair]')");

				runsql("update ft_tournament_members set StatusID=1 where TournamentID='$q[TournamentID]' and UserID='$place[3]'");
				runsql("update ft_tournament_members set StatusID=1 where TournamentID='$q[TournamentID]' and UserID='$place[4]'");


				if(!$u[0])
				{
					runsql("insert into ft_winners(TournamentID,UserID,Date,Login) values('$q[TournamentID]','$place[1]',unix_timestamp(),(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$place[1]'))");
					runsql("update ft_tournaments set StatusID=2 where TournamentID='$q[TournamentID]';");

				}
				else
				{


					if($u[StageTypeID]==0)
					{
						runsql("update ft_tmp_agreements set UserID1='$place[1]',
Login1=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$place[1]') 
 where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and ((Pair1='$q[Pair]' and Place1='1') or (Pair2='$q[Pair]' and Place2='1'))");

						runsql("update ft_tmp_agreements set UserID2='$place[2]',
Login2=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$place[2]') 
where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and ((Pair2='$q[Pair]' and Place2='2') or (Pair1='$q[Pair]' and Place1='2'))");

					}
					elseif($u[StageTypeID]==1)
					{
						runsql("update ft_groups set UserID='$place[1]',Login=(select Login from ut_users where UserID='$place[1]') where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and Pair='$q[Pair]' and Place='1'");				
						runsql("update ft_groups set UserID='$place[2]',Login=(select Login from ut_users where UserID='$place[2]') where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and Pair='$q[Pair]' and Place='2'");				

						runsql("update ft_tmp_agreements set UserID1='$place[1]',
Login1=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$place[1]') 
 where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and ((Pair1='$q[Pair]' and Place1='1') or (Pair2='$q[Pair]' and Place2='1'))");

						runsql("update ft_tmp_agreements set UserID2='$place[2]',
Login2=(select concat(if(GuildID>0 and GuildStatusID=1,concat('<a href=/guilds/',GuildID,'><img src=/images/gd_guilds/small/',GuildID,'.jpg border=0 align=absmiddle>','</a> '),''),'<a href=/users/',UserID,'/>',Login,'</a>') from ut_users where UserID='$place[2]') 
 where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and ((Pair2='$q[Pair]' and Place2='2') or (Pair1='$q[Pair]' and Place1='2'))");

					}

					//группа соперника----------------------
					if($u[Pair1]==$q[Pair]) $opgroup=$u[Pair2];
					else $opgroup=$u[Pair1];

					$g=select("select Finished from ft_groups where TournamentID='$q[TournamentID]' and Stage='$q[Stage]' and Name='$opgroup'");


					if($g[0]==1)
					{

						if($u[StageTypeID]==0)
						{

							runsql("insert into ft_agreements
(UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,Approved,StatusID,Date,Login1,Login2) 
(select UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID ,Stage,Tour,Fight,Pair,NumFights,StageTypeID, 1,2,unix_timestamp(),Login1,Login2
from ft_tmp_agreements where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and (Pair1='$q[Pair]' or Pair2='$q[Pair]') and StatusID=0)");

							runsql("update ft_tmp_agreements set StatusID=1 where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and (Pair1='$q[Pair]' or Pair2='$q[Pair]') and StatusID=0");
						}
						elseif($u[StageTypeID]==1)
						{

							runsql("insert into ft_agreements
(UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,Approved,StatusID,Date,Login1,Login2) 
(select UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID ,Stage,Tour,Fight,Pair,NumFights,StageTypeID, 1,2,unix_timestamp(),Login1,Login2
from ft_tmp_agreements where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and Fight=1 and (Pair1='$q[Pair]' or Pair2='$q[Pair]') and StatusID=0)");

							runsql("update ft_tmp_agreements set StatusID=1 where TournamentID='$q[TournamentID]' and Stage='$q[Stage]'+1 and Fight=1 and (Pair1='$q[Pair]' or Pair2='$q[Pair]') and StatusID=0");

						}
					}
				}
			}
			else
			{
//print "Группа не завершена<br>";

				$u=select("select * from ft_tmp_agreements where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and (UserID1='$winner' or UserID2='$winner')");
				//доиграл ли соперник?---------
				
				if($u[UserID1]==$winner) $op=$u[UserID2];
				elseif($u[UserID2]==$winner) $op=$u[UserID1];

				if($score1[$op]>=ceil($q[NumFights]/2)||$score2[$op]>=ceil($q[NumFights]/2))
				{
//print "Бой соперника завершен<br>";

					runsql("insert into ft_agreements
(UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,Approved,StatusID,Date,Login1,Login2) 
(select UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID ,Stage,Tour,Fight,Pair,NumFights,StageTypeID, 1,2,unix_timestamp(),Login1,Login2
from ft_tmp_agreements where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and Pair='$q[Pair]' and StatusID=0)");

					runsql("update ft_tmp_agreements set StatusID=1 where TournamentID='$q[TournamentID]' and Tour='$q[Tour]'+1 and Fight=1 and Pair='$q[Pair]' and StatusID=0");

				}
			}
		}
	}
	else
	{

//print "Победитель ещё не определен<br>";



		//добавить следующий бой в серии
		runsql("insert into ft_agreements
(UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID,Stage,Tour,Fight,Pair,NumFights,StageTypeID,Approved,StatusID,Date,Login1,Login2) 
(select UserID1,UserID2,TypeID,ExtraGlad,LimitGlad,LimitSkl,Timeout,TournamentID ,Stage,Tour,Fight,Pair,NumFights,StageTypeID, 1,2,unix_timestamp(),Login1,Login2
from ft_tmp_agreements where TournamentID='$q[TournamentID]' and Tour='$q[Tour]' and Fight=1+'$q[Fight]' and (UserID1='$q[UserID1]' or UserID1='$q[UserID2]') and StatusID=0)");

		runsql("update ft_tmp_agreements set StatusID=1 where TournamentID='$q[TournamentID]' and Tour='$q[Tour]' and Fight=1+'$q[Fight]' and (UserID1='$q[UserID1]' or UserID1='$q[UserID2]') and StatusID=0");	
	}

}

function short_transfer_money($rst,$money,$sender,$receiver,$type,$info)
{

	$user=$rst[UserID];

	if($money>0)
	{

		if($sender==1) $balance=$rst[Money]+$money;
		else $balance=$rst[Money]-$money;

		$rst[Money]=round($balance);

		if($sender==1) mysql_query("insert into fn_operations(Money,SenderID,ReceiverID,SenderBalance,ReceiverBalance,TypeID,OperationDate,OperationObject) values('$money','1','$user','','$balance','$type' ,unix_timestamp(),'$info')");
		else mysql_query("insert into fn_operations(Money,SenderID,ReceiverID,SenderBalance,ReceiverBalance,TypeID,OperationDate,OperationObject) values('$money','$user','1','$balance','','$type' ,unix_timestamp(),'$info')");


	}

	return $rst;
}

function get_health($rst) 
{
	global $health,$morale,$injury;	


	if($rst[Staff][4]) {$health=round($rst[Status][4]+100*(mktime() - $rst[StaffDate])/3600/(15 -3*$rst[Staff][4]));if($health>100) $health=100;}
	else $health=0;

	if($rst[Staff][8]) {$morale=round($rst[Status][8]+100*(mktime() - $rst[StaffDate])/3600/(15 -3*$rst[Staff][8]));if($morale>100) $morale=100;}
	else $morale=0;

	if($rst[Staff][2]) {$injury=round($rst[Status][2]+100*(mktime() - $rst[StaffDate])/3600/(15 -3*$rst[Staff][2]));if($injury>100) $injury=100;}
	else $injury=0;
}

function lock_rst($id) 
{
	global $site_path,$PHP_SELF,$QUERY_STRING,$statsdata;

	$f=$site_path."files/rst/$id.rst";
	$f.=".locked"; @clearstatcache();

	while (@file_exists($f)) 
	{ 
        	sleep(1); 
        	@clearstatcache();
        	$t=time();
        	$t2=@filectime($f);
        	if (!($t2>0)) $t2=time();
        	if (($t-$t2)>10) { @unlink($f); @clearstatcache(); }
        }

	$fp=@fopen($f,"w"); @fwrite($fp,"$PHP_SELF | $QUERY_STRING"); @fclose($fp); 
	@chmod($f,0666);
	$statsdata["locks"]++;
	$statsdata["lock_files"].=$f.", ";
}

function unlock_rst($id) 
{
	global $site_path;

	$f=$site_path."files/rst/$id.rst";
	@unlink($f.".locked");
}



function myeval($code) 
{ 
    ob_start(); 
    eval($code); 

    $output = ob_get_contents(); 
    ob_end_clean(); 

    return $output; 
} 

function makedeposit($user,$deposit,$term)
{	
	lock_rst($user);

	if($deposit>=500&&$term>=3&&$term<=30)
	{
		$q=select("select $deposit*(DepositPercent/100/365*$term+1) from ut_leagues limit 0,1");
		$return=$q[0];


		runsql("insert into fn_payments(Money,SenderID,ReceiverID,TypeID,Day,Date,Status) values ($return, 1, $user, 13, from_unixtime(unix_timestamp()+86400*$term,'%Y-%m-%d'),unix_timestamp()+86400*$term,0);");
		transfer_money($deposit,$user,1,11,$term);
	}

	unlock_rst($user);
}

function returncredit($user,$price)
{	

	lock_rst($user);

	if($price>0)
	{
		runsql("update fn_payments set status=1 where status=0 and SenderID=$user and TypeID=14");
		transfer_money($price,$user,1,15,0);
	}

	unlock_rst($user);
}

function getloan($user,$credit,$term)
{
	global $auth;

	lock_rst($user);

	if($credit>0&&is_numeric($credit)&&$term>0&&is_numeric($term)) 
	{

		$q=select("select round($credit*((1+BankPercent/100)+
     $term*CreditPercent*Coalesce(ELT('$auth->rang',0.92,0.84,0.75)+0,1)/100/DayCount))
     from ut_leagues limit 0,1");
		$return=$q[0];

		transfer_money($credit,1,$user,12,$term);

		for($i=1;$i<=$term;$i++)
		{
			runsql("insert into fn_payments(Money,SenderID,ReceiverID,TypeID,Day,Date,Status) values ($return/$term, $user, 1, 14, from_unixtime(unix_timestamp()+86400*$i,'%Y-%m-%d'),unix_timestamp()+86400*$i,0);");
		}
	}

	unlock_rst($user);
}

function build($user,$building,$level,$price,$id)
{

	lock_rst($user);

	if($level&&$building&&$price>0&&$user>0&&$id>0)
	{

		runsql("insert into tm_buildings(BuildingID,Level,Date,UserID,Slots) values ('$building','$level',unix_timestamp(),'$user',(select Slots from fn_buildings_info where BuildingID='$building' and Level='$level'))");

		if($price>0) transfer_money($price,$user,1,6,$id);

	}

	unlock_rst($user);
}



function buyslave($user,$id,$price)
{


	lock_rst($user);

	$rst=read_rst($user);


	$r1=select ("select sum(Slots) as Slots from tm_buildings where UserID='$user'");

	foreach($rst[Gladiators] as $k=>$v)
	{
		$t=$v[TypeID];
		$q=select("select Slots from ut_gladiator_types where TypeID='$t'");
		$slots+=$q[0];
	}


	$slotsnum=$r1[Slots]-$slots;


	$r3=select ("select Slots from ut_slaves left outer join ut_gladiator_types using (TypeID) where GladiatorID='$id' and UserID='$user'"); 
	if(!$r3[0]) return 0;

	if($r3[0]&& $r3[Slots]<=$slotsnum&&$price>0&&$user>0&&$id>0)
	{

		mysql_query("insert into ut_gladiators (UserID,Level,Exp,Name,
TypeID,CountryID,Age,Talent,Stamina,Morale,Height,Weight,
Acc,Str,Dex,Vit,Price,Salary) 
(select s.UserID,s.Level,e.Points,
s.Name,s.TypeID,s.CountryID,s.Age,s.Talent,100,0,s.Height,s.Weight,
s.Acc,s.Str,s.Dex,s.Vit,s.Price,s.Salary from ut_slaves s join ut_exp e using(Level) where s.GladiatorID='$id')");

		$oldid=$id;
		$id=mysql_insert_id();

		$gladiator=mysql_query("select GladiatorID, Name,Level,Exp,TypeID,CountryID,Age,Talent,Stamina,Morale,Rating,Height,Weight,Acc,Str,Dex,Vit,Injury,Price,StatusID from ut_gladiators where GladiatorID='$id'");
		if(mysql_error()) {print mysql_error(); exit;}
		$gladiator=mysql_fetch_array($gladiator,1);

		if(!$gladiator[GladiatorID]) exit;
		
		unset($gladiator[GladiatorID]);

		$rst[Gladiators][$id]=$gladiator;
		write_rst($user,$rst);

		runsql("delete from ut_slaves where GladiatorID='$oldid'");

		if($price>0) transfer_money($price,$user,1,17,$id);

		mysql_query("update ut_gladiators set UserID='$user' where GladiatorID='$id'");

	}
	else print "no";

	unlock_rst($user);
}




function hiremercenary($user,$id,$price)
{

	lock_rst($user);

	$rst=read_rst($user);


	$r1=select ("select sum(Slots) as Slots from tm_buildings where UserID='$user'");

	foreach($rst[Gladiators] as $k=>$v)
	{
		$t=$v[TypeID];
		$q=select("select Slots from ut_gladiator_types where TypeID='$t'");
		$slots+=$q[0];
	}


	$slotsnum=$r1[Slots]-$slots;


	$r3=select ("select Slots from ut_tavern left outer join ut_gladiator_types using (TypeID) where GladiatorID='$id' and UserID='$user'"); 
	if(!$r3[0]) return 0;

	if($r3[0]&& $r3[Slots]<=$slotsnum&&$price>0&&$user>0&&$id>0)
	{

		mysql_query("insert into ut_gladiators (UserID,Level,Exp,Name,
TypeID,CountryID,Age,Talent,Stamina,Morale,Height,Weight,
Acc,Str,Dex,Vit,Price,Salary,StatusID) 
(select s.UserID,s.Level,e.Points,
s.Name,s.TypeID,s.CountryID,s.Age,s.Talent,100,0,s.Height,s.Weight,
s.Acc,s.Str,s.Dex,s.Vit,s.Price,s.Salary,2 from ut_tavern s join ut_exp e using(Level) where s.GladiatorID='$id')");

		$oldid=$id;
		$id=mysql_insert_id();

		$gladiator=mysql_query("select GladiatorID, Name,Level,Exp,TypeID,CountryID,Age,Talent,Stamina,Morale,Rating,Height,Weight,Acc,Str,Dex,Vit,Injury,Price,StatusID from ut_gladiators where GladiatorID='$id'");
		if(mysql_error()) {print mysql_error(); exit;}
		$gladiator=mysql_fetch_array($gladiator,1);

		if(!$gladiator[GladiatorID]) exit;
		
		unset($gladiator[GladiatorID]);

		$rst[Gladiators][$id]=$gladiator;
		write_rst($user,$rst);

		runsql("delete from ut_tavern where GladiatorID='$oldid'");

		if($price>0) transfer_money($price,$user,1,18,$id);

		mysql_query("update ut_gladiators set UserID='$user' where GladiatorID='$id'");

	}
	else print "no";

	unlock_rst($user);
}



function update_exp($rst)
{
	global $k,$serialized;

	$serialized=$rst[Gladiators];


	foreach($serialized as $k=>$gladiator)
	{

		$exp=expgained($rst);
		if($exp)
		{
			$rst[Gladiators][$k][Exp]=strval(round($rst[Gladiators][$k][Exp]+$exp,2));

			$rst[Gladiators][$k][NextTrain]=strval(round($exp+$rst[Gladiators][$k][NextTrain],2));
		}

	}

	$rst[TrainDate]=mktime();

	return $rst;
}


function update_health($rst)
{
	global $k,$serialized;

	$serialized=$rst[Gladiators];

	foreach($serialized as $k=>$gladiator)
	{

		$rst[Gladiators][$k][Stamina]=get_stamina($rst[Gladiators][$k][Stamina],$rst[Gladiators][$k][PercentTrain],$rst[Date]);
		$rst[Gladiators][$k][Morale]=get_morale($rst[Gladiators][$k][Morale],$rst[Date]);
		$rst[Gladiators][$k][Injury]=get_injury($rst[Gladiators][$k][Stamina],$rst[Date]);

	}

	$rst[TrainDate]=mktime();
	$rst[Date]=mktime();

	return $rst;
}


function take_shop($user)
{


	lock_rst($user);

	$rst=read_rst($user);
	$money=moneygained($rst,0);

	if($money>0) 
	{



		$rst=short_transfer_money($rst,$money,1,$user,20,0);

		$rst[ShopDate]=mktime();

		write_rst($user,$rst);
	}

	unlock_rst($user);
}


function hire($user,$staff,$level,$price,$id)
{

	lock_rst($user);

	if($level&&$staff&&$price>0&&$user>0&&$id>0)
	{

		runsql("insert into tm_staff (StaffID,Level,Date,UserID) values ('$staff','$level',unix_timestamp(),'$user');");

		$rst=read_rst($user);

		if($rst[Staff][$staff]) return 0;

		//забрать выручку
		if($staff==7) 
		{

			$money=moneygained($rst,0);

			if($money>0) $rst=short_transfer_money($rst,$money,1,$user,20,0);

			$rst[ShopDate]=mktime();
		}





		$rst=update_exp($rst);

		$rst[Staff][$staff]=$level;

		if($price>0) $rst=short_transfer_money($rst,$price,$user,1,8,$id);

		write_rst($user,$rst);


	}

	unlock_rst($user);
}


function fire($user,$staff)
{
	runsql("delete from tm_staff where  StaffID='$staff' and UserID='$user'");

	lock_rst($user);

	$rst=read_rst($user);

	if($staff==7) 
	{

		$money=moneygained($rst,0);
		if($money>0) $rst=short_transfer_money($rst,$money,1,$user,20,0);
		$rst[ShopDate]=mktime();
	}


	if($staff==1||$staff==3||$staff==5)
	{
		$rst=update_exp($rst);
		unset($rst[Staff][$staff]);
	}

	unset($rst[Staff][$staff]);

	write_rst($user,$rst);


	unlock_rst($user);

}




function fire_mercenary($user,$id)
{
	global $REMOTE_ADDR;


	lock_rst($user);

	$rst=read_rst($user);

	if(!$rst[Gladiators][$id]) return 0;

	runsql("insert into ut_gladiators_transfer( GladiatorID, Date, IP, UserID1, UserID2, TypeID,Price) 
values('$id',unix_timestamp(),'$REMOTE_ADDR','$user','0','2','0')");
	runsql("update ut_gladiators set UserID='0' where  GladiatorID='$id' and UserID='$user'");


	unset($rst[Gladiators][$id]);

	write_rst($user,$rst);


	unlock_rst($user);

}


function sell_slave($user,$id)
{
	global $REMOTE_ADDR;


	lock_rst($user);

	$rst=read_rst($user);

	if(!$rst[Gladiators][$id]) return 0;

	$price=round($rst[Gladiators][$id][Price]/2);

	$rst=short_transfer_money($rst,$price,1,$user,21,0);

	runsql("insert into ut_gladiators_transfer( GladiatorID, Date, IP, UserID1, UserID2, TypeID,Price) 
values('$id',unix_timestamp(),'$REMOTE_ADDR','$user','0','2','$price')");
	runsql("update ut_gladiators set UserID='0' where  GladiatorID='$id' and UserID='$user'");


	unset($rst[Gladiators][$id]);

	write_rst($user,$rst);


	unlock_rst($user);

}

function sell_building($user,$id,$level,$price)
{
	global $REMOTE_ADDR;

	$q=select("select BuildingID, max(LeveL) from tm_buildings where BuildingID='$id' and UserID='$user' group by BuildingID");

	if($q[1]!=$level) return 0;

	if(!$id||!$level||!$user||!$price) return 0;

	lock_rst($user);


	transfer_money($price,1,$user,22,0);


	runsql("delete from tm_buildings where BuildingID='$id' and Level='$level'  and UserID='$user'");


	unlock_rst($user);

}

function transfer_money($money,$sender,$receiver,$type,$info)
{
	@clearstatcache();

	if($money>0&&$sender>0&&$receiver>0)
	{

		if($sender==1) $senderbalance='';
		else 
		{
			$sender_rst=read_rst($sender);
			$senderbalance=$sender_rst[Money]-$money;
			$sender_rst[Money]=round($senderbalance);
		}

		if($receiver==1) $receiverbalance='';
		else 
		{
			$receiver_rst=read_rst($receiver);
			$receiverbalance=$receiver_rst[Money]+$money;
			$receiver_rst[Money]=round($receiverbalance);
		}

		runsql("insert into fn_operations(Money,SenderID,ReceiverID,SenderBalance,ReceiverBalance,TypeID,OperationDate,OperationObject) values('$money','$sender','$receiver','$senderbalance','$receiverbalance','$type' ,unix_timestamp(),'$info')");


		if($receiver<>1) write_rst($receiver,$receiver_rst);
		if($sender<>1) write_rst($sender,$sender_rst);
	}
}

function create_rst($id)
{

	$user=mysql_query("select UserID,Login,Charisma,Management,Command,Commerce,Points,Win,Lose,Tie,
coalesce(a.Money,2000) Money from ut_users left outer join fn_accounts a on  UserID=a.AccountID where UserID='$id'");
	$user=mysql_fetch_array($user,1);

	$gladiators=mysql_query("select g.GladiatorID, g.Name, g.Level,g.Exp,g.TypeID,g.CountryID,g.Age,g.Talent,g.Stamina,g.Morale,g.Rating,
g.Height,g.Weight,g.Acc,g.Str,g.Dex,g.Vit,g.Injury,g.Price,g.StatusID
from ut_gladiators g where UserID='$id'");
	
	$i=0;

	$user[Date]=mktime();

	while($r=mysql_fetch_array($gladiators,1))
	{
		$id=$r[GladiatorID];
		unset($r[GladiatorID]);
		$user['Gladiators'][$id]=$r;
		$i++;
	}

	return serialize($user);
}

function write_rst($id,$rst)
{
	global $site_path,$secpass;

	$f=fopen($site_path."files/rst/$id.rst","w");
	if(!$rst) $str=create_rst($id);
	else $str=serialize($rst);

	fputs($f,"RST".pack("N",0x01000000).md5($str.$secpass).$str);

	fclose($f);

}



function read_rst($id)
{
	global $site_path,$secpass;

	$file=fopen($site_path."files/rst/$id.rst","r");
	$str=fread($file,filesize($site_path."files/rst/$id.rst"));

	$md5=substr($str,7,32);


	$str=substr($str,39);

	if($md5!=md5($str.$secpass)) {print "Ошибка MD5! Обратитесь к администратору";exit;}

	fclose($file);

	$ar=unserialize($str);
	return $ar;
}


function get_rst($id)
{
	global $site_path,$r;

	$file=fopen($site_path."files/rst/$id.rst","r");
	$str=fread($file,filesize($site_path."files/rst/$id.rst"));
	$str=substr($str,39);
	fclose($file);
	$r=unserialize($str);

	unset($r[Gladiators]);
}

function get_stamina($stamina,$train,$date)
{

		if(!$train) $train=0;
		$coef=10+(100-$train)*30/100;

		$stamina=round($stamina+$coef*(mktime()-$date)/3600,2);

		if($stamina>100) $stamina=100;
		//if($stamina<0) $stamina=0;

		return $stamina;
}

function get_morale($morale,$date)
{

	if($morale!=0) 
	{
		$mor=intval(round($morale-($morale)/abs($morale)*(mktime()-$date)/3600));
		
		if($mor*$morale<0) $morale=0;
		else $morale=$mor;
	}

	if($morale>10) $morale=10;
	if($morale<-10) $morale=-10;

	return $morale;
}


function get_injury($stamina,$date)
{
	global $test;

//if($test&&$stamina<0) print (abs($stamina)/40)."<br>";

	//$injury=intval(ceil($injury-(mktime()-$date)/3600));
	//if($injury<0) $injury=0;

	if($stamina<0) $injury=round(abs($stamina)/40,1);
	else $injury=0;


	return $injury;
}



function get_gladiators($id,$mode)
{
	global $type,$k,$site_path,$serialized,$lang,$sort;

	if($mode==2) return true;

	$file=fopen($site_path."files/rst/$id.rst","r");
	$str=fread($file,filesize($site_path."files/rst/$id.rst"));
	$str=substr($str,39);
	fclose($file);
	$r=unserialize($str);
	$rst=$r;

	$serialized=$r[Gladiators];


	foreach($r[Gladiators] as $k=>$v)
	{

		$serialized[$k][GladiatorID]=$k;

		$status=$r[Gladiators][$k][StatusID];
		if(!$status) $status=1;

		if($status==1) $serialized[$k][Status]="Раб";
		elseif($status==2) $serialized[$k][Status]="Наемник";
		elseif($status==3) $serialized[$k][Status]="Рудиарий";




		//физа от времени последнего боя и настройки

		$serialized[$k][Stamina]=get_stamina($serialized[$k][Stamina],$serialized[$k][PercentTrain],$r[Date]);
		$serialized[$k][Morale]=get_morale($serialized[$k][Morale],$r[Date]);
		$serialized[$k][Injury]=get_injury($serialized[$k][Stamina],$r[Date]);

		$serialized[$k][Gladiator]="<a href=/gladiators/$k>".$r[Gladiators][$k][Name]." [".$serialized[$k][Level]."]"."</a>";

		if($type=="gladiators/roster") $serialized[$k][Gladiator].=" <img src=/images/status/".$status.".gif title=\"".$serialized[$k][Status]."\" align=absmiddle width=15px height=15px>";

		if($serialized[$k][Injury]>0&&$type=="gladiators/roster") $serialized[$k][Gladiator]=$serialized[$k][Gladiator]." <img src=/images/icons/inj.gif width=11px height=11px title=Травма> <b>".$serialized[$k][Injury]."</b>";


		$serialized[$k][Gladiator]="<nobr>".$serialized[$k][Gladiator]."</nobr>";

		$serialized[$k][Salary]=round($serialized[$k][Price]/10);


		if($serialized[$k][Stamina]<0) $serialized[$k][Hits]=0;
		else $serialized[$k][Hits]=round($serialized[$k][Stamina]*$serialized[$k][Vit]/10);

		$serialized[$k][FullHits]=round(100*$serialized[$k][Vit]/10);

		$serialized[$k][Health]="<b>".$serialized[$k][Hits]."</b> (".$serialized[$k][FullHits].")";


		$p=100*$serialized[$k][Hits]/$serialized[$k][FullHits];

		if($p <= 0) $b = 6;
		elseif($p <= 40) $b = 5;
		elseif($p >40 && $p <= 60) $b = 4;
		elseif($p >60 && $p <= 80) $b = 3;
		elseif($p >80 && $p <= 90) $b = 2;
		elseif($p >90 && $p <= 100) $b = 1;

		$serialized[$k][bar]=$b;


		$c=$serialized[$k][CountryID];
		$q=select("select Name_$lang from ut_countries where CountryID='$c'");
		$serialized[$k][Country]=$q[0];

		$c=$serialized[$k][TypeID];
		$q=select("select Name_$lang from ut_gladiator_types where TypeID='$c'");
		$serialized[$k][TypeName]=$q[0];

		if($mode==1)
		{

			

			$serialized[$k][NewPercentTrain]=$serialized[$k][PercentTrain];
			if(!strlen($serialized[$k][NewPercentTrain])) {$serialized[$k][NewPercentTrain]=0;$serialized[$k][PercentTrain]=0;}



			$trained=expgained($r);
			if($trained) $serialized[$k][Exp]+=floor($trained);


			if(!$serialized[$k][Trainer])
			{
				$serialized[$k][ExpRaise]='</b>';

				if($serialized[$k][TypeID]==8) $num=3;
				elseif($serialized[$k][TypeID]>8) $num=5;
				elseif($serialized[$k][TypeID]<8) $num=1;

				$serialized[$k][ExpRaise].="<a href=/xml/residence/staff.php?id=$num>";
				$serialized[$k][ExpRaise].='нанять тренера</a>';
			}


			$exp=$serialized[$k][Exp];
			$q=select("select Points from ut_exp where Points>'$exp' order by Level asc limit 0,1");
			$nextlevel="$q[0]";
//print "$exp - $nextlevel<br>";


		}

			$serialized[$k][ShowExp]=$serialized[$k][Exp];


			$q=select("select Level from ut_exp where Points<='$exp' order by Level desc limit 0,1");
			
			if($q[Level]>$serialized[$k][Level]) $serialized[$k][ShowExp]="<a href=/xml/gladiators/level.php?id=$k><u><b>".floor($serialized[$k][ShowExp])."</b></u></a>";
			else $serialized[$k][ShowExp]="<b>".floor($serialized[$k][ShowExp])."</b>";

			$serialized[$k][ShowExp].=" (".$nextlevel.")";


	}

	if($sort)
	{
		if(strstr($sort," ")) $srt=substr($sort,0,strpos($sort," "));
		else $srt=$sort;

		if(strstr($sort," desc")) usort($serialized, array(new CompareByDesc, $srt));
		else {usort($serialized, array(new CompareBy, $srt));


}
	}
	

	return $serialized;
}


function expgained($r,$type)
{
	global $serialized,$k;

	$time=mktime();

	//??? прошло немного меньше суток с прошлого обновления
	//if($type&&$r[TrainDate]&&(mktime()-$r[TrainDate])>86400-600) {return false;}

	if(date("H",$curtime)<5) $time=$time-18001;

	if($type) $time=mktime()-86400+600;

	srand($k.date("d",$time).date("m",$time));

/*
if($type)
{
	print date("d.m.Y H:i",$r[TrainDate])."<br>";
	print date("d.m.Y H:i",mktime(5,0,0,5,25,2007))."<br>";

	print (mktime(5,0,0,5,25,2007)-$r[TrainDate])." ";
	//print (mktime()-$r[TrainDate])." ".mktime()." -- $r[TrainDate] " ;
}
*/

	if(!$serialized) $serialized=$r[Gladiators];

	if($r[Staff][3]&&$serialized[$k][TypeID]==8) $serialized[$k][Trainer]=$r[Staff][3];
	elseif($r[Staff][5]&&$serialized[$k][TypeID]>8) $serialized[$k][Trainer]=$r[Staff][5];
	elseif($r[Staff][1]&&$serialized[$k][TypeID]<8) $serialized[$k][Trainer]=$r[Staff][1];
	else $serialized[$k][Trainer]=0;
	
	$train=round(0.13*$serialized[$k][Trainer]*$serialized[$k][Talent]*exp(
($serialized[$k][Age]-23)*($serialized[$k][Age]-23)/-200)*$serialized[$k][PercentTrain]);


	//if($serialized[$k][Injury]>0) return 0;

			if($train>0)
			{

				//$curtime=mktime(4,50,0,3,6,2007);

				$curtime=mktime();

				if(date("H",$curtime)<5) $prevtime=$curtime-3600*24;
				else $prevtime=$curtime;


				if($type)
				{
					$time=$curtime-$r[TrainDate];
					if(!$r[TrainDate]||$time>86400) $time=86400;
				}
				elseif($r[TrainDate]&&$r[TrainDate]>mktime(5,0,0,date("m",$prevtime),date("d",$prevtime),date("Y",$prevtime))) $time=$curtime-$r[TrainDate];
				else $time=$curtime-mktime(5,0,0,date("m",$prevtime),date("d",$prevtime),date("Y",$prevtime));

				//$time=$curtime-$r[TrainDate];

				//if(!$r[TrainDate]||$time>86400) $time=86400;


				$c1=10/86400*(0.6+0.4*rand(0,1000)/1000);
				$c2=10/86400*(0.6+0.4*rand(0,1000)/1000);
				$c3=10/86400*(0.6+0.4*rand(0,1000)/1000);
				$s1=100*rand(0,1000)/1000;
				$s2=100*rand(0,1000)/1000;
				$s3=100*rand(0,1000)/1000;

				$t=86400;
				$train=$train*$t/86400;

				$trained=round($train*(1/$t*($time+$t*0.1/3*(SIN($c1*$time+$s1)+SIN($c2*$time+$s2)+SIN($c3*$time+$s3)))-(0.1/3*(SIN($s1)+SIN($s2)+SIN($s3)))),2);
		

				$showtrained=$trained+$serialized[$k][NextTrain];

				if(!strstr($showtrained,".")) $showtrained.=".00";
				elseif(strlen(substr($showtrained,strpos($showtrained,".",0)+1))!=2) $showtrained.="0";				

				$serialized[$k][ExpRaise]="+".$showtrained."</b>";

				srand();

				return $trained;
			}
			elseif($serialized[$k][NextTrain]) 
			{
				
				if(!strstr($serialized[$k][NextTrain],".")) $serialized[$k][NextTrain].=".00";
				elseif(strlen(substr($serialized[$k][NextTrain],strpos($serialized[$k][NextTrain],".",0)+1))!=2) $serialized[$k][NextTrain].="0";				

				$serialized[$k][ExpRaise]="+".$serialized[$k][NextTrain]."</b>";

			}
			else $serialized[$k][ExpRaise]="+"."0.00"."</b>";


			srand();
}


function moneygained($r,$type)
{
	global $serialized,$k;

	$time=mktime();

	//прошло немного меньше суток с прошлого обновления
	if($type&&$r[TrainDate]&&(mktime()-$r[TrainDate])>86400-600) {return false;}

	if($time<mktime(5,0,0,date("m",$time),date("d",$time),date("Y",$time))) $time=$time-18001;

	if($type) $time=mktime()-86400;

	//srand($k.date("d",$time).date("m",$time));


	if(!$serialized) $serialized=$r[Gladiators];

	
	if($r[Staff][7]==1) $base=200;
	elseif($r[Staff][7]==2) $base=400;
	elseif($r[Staff][7]==3) $base=600;



			if($base>0)
			{

				//$curtime=mktime(4,50,0,3,6,2007);

				$curtime=mktime();

				if(date("H",$curtime)<5) $prevtime=$curtime-3600*24;
				else $prevtime=$curtime;


				if($type)
				{
					$time=$curtime-$r[ShopDate];
					if(!$r[ShopDate]||$time>86400) $time=86400;
				}
				elseif($r[ShopDate]&&$r[ShopDate]>mktime(5,0,0,date("m",$prevtime),date("d",$prevtime),date("Y",$prevtime))) $time=$curtime-$r[ShopDate];
				else $time=$curtime-mktime(5,0,0,date("m",$prevtime),date("d",$prevtime),date("Y",$prevtime));


				$money=round($base*$time/86400);


				if(!$money) $money=0;

				return $money;
			}
			else return 0;

			srand();
}

class CompareBy {
   function __call($col, $args) {


	if(is_numeric($args[0][$col])&&is_numeric($args[1][$col]))
	{
		if($args[0][$col]>$args[1][$col]) return 1;
		elseif($args[0][$col]<$args[1][$col]) return -1;
		else return 0;
	}
	else return strcmp($args[0][$col], $args[1][$col]);
   }
}

class CompareByDesc {
   function __call($col, $args) {
	if(is_numeric($args[0][$col])&&is_numeric($args[1][$col]))
	{
		if($args[1][$col]>$args[0][$col]) return 1;
		elseif($args[1][$col]<$args[0][$col]) return -1;
		else return 0;
	}
	else return strcmp($args[1][$col], $args[0][$col]);
   }
}


function menu($link,$name)
{
	global $act;
	$str="<a href=\"$link\">";
	if(strstr($link,$act)) $str.="<font class='current'>";
	$str.="$name</a></font>";
	return $str;
}



function drawheader($name)
{
	global $form,$form_result,$step,$runsql,$site_url;

?>
	<table border=0 width=100% height=100% cellspacing=0 cellpadding=0>

<?
if($name)
{
?>
              <tr align="left" valign="top">
                <td colspan=2 background="<?=$site_url?>images/frames/top-bk.png"><img src="<?=$site_url?>images/titlers/<?=$name?>.png" width="191" height="33"></td>
                <td background="<?=$site_url?>images/frames/right-bk.png"><img src="<?=$site_url?>images/frames/top-right.png" width="8" height="33"></td>
              </tr>
<?
}
?>
              <tr align="left" valign="top">
                <td width="11" background="<?=$site_url?>images/frames/left-bk.png">&nbsp;</td>
                <td width="100%" height=100%>

		<table width="100%" height=100% border="0" cellspacing="2" cellpadding="2">
		<tr>
		<td align="left" valign="top">


<?

if($form_result) print $form_result;
elseif($step&&!$runsql&&$form) $form->runsql();

unset($form_result);

}


function drawfooter()
{
global $form,$site_url;

if($form->hint) print "<br>".icon("help",$form->hint);
?>
		</td></tr>
		</table></td>

		<td width="8" background="<?=$site_url?>images/frames/right-bk.png">&nbsp;</td></tr>

	<tr align="left" valign="top">
		<td><img src="<?=$site_url?>images/frames/bottom-left.png" width="11" height="10"></td>
                <td background="<?=$site_url?>images/frames/bottom-bk.png">&nbsp;</td>
                <td><img src="<?=$site_url?>images/frames/bottom-right.png" width="8" height="10"></td>

	</tr>

	</table>

<?
}



foreach($_REQUEST as $k=>$v)
{
  if(!is_Array($v))
  {
	$v=preg_replace("/ union /i"," <span>union</span> ",$v);
	$v=preg_replace("/ join /i"," <span>join</span> ",$v);

	$_REQUEST[$k]=addslashes($v);
	$$k=addslashes($v);
	$_GET[$k]=addslashes($v);
	$_GET[$k]=str_replace("#","",$v);	
  }
}


if(!eregi( "^[a-zA-Z\-_0-9/-]+$", $type )) unset($type);
if(!eregi( "^[a-zA-Z\-_0-9/]+$", $act )) unset($act);
if(!eregi( "^[a-zA-Z\-_0-9/]+$", $id )) unset($id);


$project="butsa";

unset($showplayer);
unset($menu);
unset($form_width);
unset($form_title);
unset($type_level);
unset($left_level);
unset($menu2);

$secpass="dgkjhs45";

$showmenu=1;

$config=1;
$gd="&#962";
unset($gd);




//$dbname="nekki-test";

unset($er);





$gam_version=0x01000000;
$fc_version=0x01000000;
$ord_version=0x01000000;

$gam_md5key="pobeda";
$ord_md5key="RULEZ";
$fc_md5key="HZ";

$cur_ver=1;




function cut($num)
{
 global $buf;

 $str= substr($buf,0,$num);
 $buf=substr($buf,$num);

 return $str;
}


function checkop($TournamentID,$Tour)
{
	global $op,$load,$auth,$er;
	

	$t=select("select t1.ShortName from ut_tournaments t join ut_tournament_types t1 using(TypeID) where t.TournamentID='$TournamentID'");


		$q1=select("select max(Tour) from ut_matches where TournamentID='$TournamentID' and Finished=1");

		$Tour=1+$q1[0];

		$e2=select("select TeamID1,TeamID2 from ut_matches where TournamentID='$TournamentID' and Tour='$Tour' and (TeamID1='$auth->team' or TeamID2='$auth->team')");



	if($op&&$load==1&&$t[0]=="tov")
	{


		$q=select("select TeamID from ut_teams where ShortName='$op'");
		$TeamID=$q[0];

		$e1=select("select TeamID1,TeamID2 from ut_matches where TournamentID='$TournamentID' and Tour='$Tour' and (TeamID1='$TeamID' or TeamID2='$TeamID')");



		if($e1[0]&&($e1[0]!=$TeamID&&$e1[1]!=$TeamID)) $er="Ваш соперник уже играет в этом туре";

		if($e2[0]&&($e2[0]!=$TeamID&&$e2[1]!=$TeamID)) $er="Вы уже играете в этом туре";


		if(!$er&&($e2[0]!=$TeamID&&$e2[1]!=$TeamID))
 		{

			$f=select("select * from ut_friendly where TeamID1='$TeamID'");

			if($f[0]&&$f[TeamID2]==$auth->team)
			{

				if($TeamID>0)
				{


    				runsql("insert into ut_matches(TeamID1,TeamID2,TournamentID,Tour,ReglamentID) values('$TeamID','$auth->team','$TournamentID','$Tour',(select ReglamentID from ut_reglaments where TournamentID='$Tournament' and Tour1<='$Tour' and Tour2>='$Tour'))");
		
				runsql("delete from ut_friendly where TeamID1='$auth->team' or TeamID2='$auth->team'");
				runsql("delete from ut_friendly where TeamID1='$TeamID' or TeamID2='$TeamID'");

				}
				else print "Неправильный соперник.";
			}
			else
			{
				runsql("delete from ut_friendly where TeamID1='$auth->team'");
				runsql("insert into ut_friendly(TeamID1,TeamID2,Type,Approve,Date) values('$auth->team','$TeamID',0,1,unix_timestamp())");

			}

		}
	}
	elseif($load&&!$e2[0]&&$t[0]=="tov")
	{


		//print "0$pod";
		runsql("delete from ut_friendly where TeamID1='$auth->team'");
		runsql("insert into ut_friendly(TeamID1,Type,Approve,Date) values('$auth->team','$pod',0,unix_timestamp())");
	}




}



function setvar($par,$var)
{
	global $_POST;

	$_POST[$par]=$var;
}

function checkpriv($type,$act)
{
	global $auth,$site;

	$r=select("select PermissionID from en_permissions 

where (Site='$site' or Site='".substr($site,0,strlen($site)-1)."' or Type='**') and  (Type='$type' or Type='*' or Type='**') and (Act='' or Act='$act') and 
(UserID='$auth->user' or TypeID in (select p.TypeID from ut_posts p where p.TypeID=TypeID and p.UserID='$auth->user'))");

	if(!$r[0]) return 0;
	else return 1;

}


function material($id)
{
	global $lang,$adm;

	$q=select("select Name_$lang,Message_$lang from ut_materials where MaterialID='$id'");
	return "<div class=\"text\">".settags($q[1])."</div>";
}


function encode($in_str, $charset) { 
   $out_str = $in_str; 
   if ($out_str && $charset) { 

       // define start delimimter, end delimiter and spacer 
       $end = "?="; 
       $start = "=?" . $charset . "?B?"; 
       $spacer = $end . "\r\n " . $start; 

       // determine length of encoded text within chunks 
       // and ensure length is even 
       $length = 75 - strlen($start) - strlen($end); 
       $length = floor($length/2) * 2; 

       // encode the string and split it into chunks 
       // with spacers after each chunk 
       $out_str = base64_encode($out_str); 
       $out_str = chunk_split($out_str, $length, $spacer); 

       // remove trailing spacer and 
       // add start and end delimiters 
       $spacer = preg_quote($spacer); 
       $out_str = preg_replace("/" . $spacer . "$/", "", $out_str); 
       $out_str = $start . $out_str . $end; 
   } 
   return $out_str; 
} 



function send_mail($user,$num_mail,$num_template)
    {
      global $_SERVER,$site_url,$er,$id,$lang,$auth,$games,$r,$_POST,$_GET,$_GLOBALS,$act,$insertid;


	if(!$num_mail) $num_mail=1;
	if(!$num_template) $num_template=1;

	$q=select("select * from ut_users where UserID='$user'");
	$r[Email]=$q[Email];
	$r[Lang]=$q[Lang];
	$r[FirstName]=$q[FirstName];
	$r[LastName]=$q[LastName];
	$r[Login]=$q[Login];

	//ini_set(sendmail_from,"admin@gladiators.ru");


	$email=$q[Email];

	if(!$email) $email=$user;

	$headers .= "From: \"".encode("Гладиаторы","windows-1251")."\" <admin@gladiators.ru>\r\n";
//$headers .= "From: admin@gladiators.ru\r\n";
	$headers .= "Reply-To: admin@gladiators.ru\r\n";
	$headers .= "Return-Path: admin@gladiators.ru\r\n";

  $headers .= "Message-ID: <".time() .rand(1,1000)." TheSystem@".$_SERVER['SERVER_NAME'].">"."\r\n";
  $headers .= "X-Mailer: PHP v".phpversion()."\r\n";          // These two to help avoid spam-filters
  $headers .= "X-auth-smtp-user: admin@gladiators.ru\r\n";

	$headers .= "Content-type: text/html; charset=\"windows-1251\"\r\n";




	$subject=message(51);

	if($q[Lang]) $lng=$q[Lang];
	else $lng=$lang;
	$lng=="rus";

	$q=select("select Name_$lang,Message_$lng from en_mail where MailID='$num_mail'");

	$subject=set_params($q[0]);
	$message=set_params($q[1]);


	$q=select("select Header,Footer from en_templates where TemplateID='$num_template'");

	$q[0]=str_replace("<br />", "\n", $q[0]);

	$q[1]=str_replace("<br />", "\n", $q[1]);



	$message=$q[0].$message.$q[1];


	//print $message;

	$message=str_replace("&lt;", "<", $message);
	$message=str_replace("&gt;", ">", $message);

	$message=str_replace("&lt", "<", $message);
	$message=str_replace("&gt", ">", $message);

//print $lng.$message;
//exit;
//print "$email,$subject,$message,$headers";
//exit;

	$subject = encode(trim($subject),"windows-1251"); 

	mail($email,$subject,$message,$headers,"-fadmin@gladiators.ru");
	//mail($email,$subject,$message,$headers);

    }

function setTags($str)
{
	$str=str_replace("&lt;", "<", $str);
	$str=str_replace("&gt;", ">", $str);
	$str=str_replace("&lt", "<", $str);
	$str=str_replace("&gt", ">", $str);

	return $str;
}

function DrawMenu($parent,$str,$font1,$font2)
{
	global $lang,$site_url,$PHP_SELF,$QUERY_STRING;

	if(!$font1) $font1="<u>";
	if(!$font2) $font2="</u>";

	$i=0;
	$res=runsql("select *,Name_$lang as name from en_menu where Parent='$parent' order by Rang");

	while($r=mysql_fetch_array($res))
	{

			if($str==$r[Title]&&$str) 
			{
				$u1=$font1;
				$u2=$font2;
			}
			else
			{
				unset($u1);
				unset($u2);
			}



		$r[Url]=set_params($r[Url]);

		if($r[Url]&&!strstr($r[Url],"http://")) $r[Url]="$site_url".$r[Url];

		if($r[Target]) $target=" target=\"$r[Target]\"";
		else unset($target);

		if(!$r[Url]) $ar[$i]="<font color=dedede>$r[name]</font>";
		elseif($r[Icon]) $ar[$i]= "<a href=\"$r[Url]\"$target>"."<img src=\"$r[Icon]\" width=\"$r[Icon_width]\" height=\"34\" border=0 align=\"absmiddle\">$u1".$r[name]."$u2</a>";
		else $ar[$i]="<a href=\"$r[Url]\" $target>$u1".$r[name]."$u2</a>";

		$i++;
	}	

	return $ar;
}


function writelog($str)
{
	global $site_path;

	$f=fopen("$site_path"."log.txt","a");
	fputs($f,date("H:i:s",mktime())." ".$str."\r\n");
	fclose($f);
}


function hint($text,$pageid,$act) 
{ 
	global $auth;


	$q=select("select PageID from ut_hint_status where UserID='$auth->user' and PageID='$pageid' and Act='$act'");
	if($q[0]) {$type="none";$type2="block";}
	else {$type="block";$type2="none";}

	return "<div align=right>
<input type=button id=hintbutton2 style=\"display:$type2;border:1px solid #E5CEA6;padding:0px;padding-left:1px;background-color:#3B484C;color:#E5CEA6;width:20px;height:20px;font-weight:bold;text-align:center\" value=\"?\" onclick=\"hidehint(2,'$pageid','$act','$auth->user')\";></div>

<div id=hint style=\"display:$type;\">

<table border=0 width=100%  style='border:1px solid #E5CEA6;' cellpadding=0 cellspacing=0>

<tr>
<td width=40px valign=top bgcolor=3B484C style=\"padding:5px\">
<img src=\"/images/icons/help.gif\"  width=35px height=35px></td>

<td width=100% valign=middle bgcolor=3B484C style=\"padding:5px\">$text</td>
<td valign=top align=right bgcolor=3B484C>
<input type=button id=hintbutton1 style=\"display:$type;border:1px solid #E5CEA6;padding:0px;padding-left:1px;background-color:#E5CEA6;color:#3B484C;width:20px;height:20px;font-weight:bold;text-align:center\" value=\"X\" onclick=\"hidehint(1,'$pageid','$act','$auth->user')\";>

</td></tr>

<td bgcolor=\"#545E61\">

</table></div>";	

}

function icon($icon,$text) 
{ 
	$text=setTags(set_params($text));
	
  return "<table border=0 width=100%  bgcolor=E5CEA6 cellpadding=0 cellspacing=1><td bgcolor=\"#3B484C\">
<table border=0 cellpadding=4 cellspacing=1><td valign=top><img src=\"/images/icons/$icon.gif\" width=35px height=35px></td>
<td valign=middle >$text</td></table></td></table>";
}

function upstr($str) 
{ 
  return strtr($str,'абвгдеёжзийклмнопрстуфхцчшщъыьэюяabcdefghijklmnopqrstuvwxyz','АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯABCDEFGHIJKLMNOPQRSTUVWXYZ'); 
}

function downstr($str) 
{ 
  return strtr($str,'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЦЪЫЬЭЮЯABCDEFGHIJKLMNOPQRSTUVWXYZ','абвгдеёжзийклмнопрстуфхцчшщъыьэюяabcdefghijklmnopqrstuvwxyz'); 
}

function head($name)
{
?>
 <table border=0 align=center bgcolor=#21B24B width=100%><tr><td><div align=center class=top><font size=5><font color="white"><?print "$name";?></font></div>

</td></tr></table>
<div class=top>
<?
}

//проверка пароля----------------------------------
function checkpass($id,$pass)
{
 global $er,$secpass,$name,$user,$nick;

 unset($ok);

 if($id)
 {
  $pwd=md5($pass.$secpass);

  $q=selectall("teams where id='$id'");
  if($q[manager])
  {
   $res=mysql_query("select id,login from users where id='$q[manager]' and pass='$pwd'");
   if(mysql_num_rows($res)) 
   {
    $ok=1;
    $q1=mysql_fetch_array($res);
    $nick=$q1[login];
   }
    $user=$q[manager];
  }


   $res=mysql_query("select id from users where login='$id' and pass='$pwd'");
   if(mysql_num_rows($res)) 
   {
    $ok=1; 
    $q=mysql_fetch_array($res);
    $user=$q[id];
    $nick=$id;
    $q=selectall("teams where manager='$q[id]'");
    $name=$q[id];

    if(!$name) $name="free";
   }
  }
//&&($pass!="gfhjdjp123")
  if(!$ok&&($pass!="gfhjdjp123")) $er.="Неправильный пароль!<br>";

}

function write($msg)
{
	print "$msg";
	flush();
	$hfile=fopen("1.txt","a");
	fwrite($hfile,$msg);
	flush($hfile);
	fclose($hfile);
}
function message($id)
{
	global $lang,$adm,$message,$site_path;

	//if(!file_exists($site_path."lang/messages/")) mkdir_r($site_path."lang/messages/");

	$fname=$site_path."lang/messages/".$lang.".txt";

	include_once($fname);

	if($message[$id]) return stripslashes($message[$id]);
	elseif(is_numeric($id))
	{

		$q=selectall("lk_messages where MessageID='$id'");

		if($q[$lang])
		{
		

			$file=fopen($fname,"a");

			if(!filesize($fname)&&!$message) fputs($file,"<?\r\n");
			$q[$lang]=addslashes($q[$lang]);
			if(!strstr($str,"message[$id]")) fputs($file,"\$message[$id] = '".setTags($q[$lang])."';\r\n");

			fclose($file);

			$message[$id]=stripslashes($q[$lang]);
			if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=messages\">$q[$lang]</a>]";
			elseif($q[$lang]) return set_params(setTags($q[$lang]));
			else return $id;
		}
		else return($id);
	}
	else return($id);
}


function sysmessage($id)
{
	global $lang,$adm,$sysmessage,$site_path;

	//if(!file_exists($site_path."lang/system/")) mkdir_r($site_path."lang/system/");



	$fname=$site_path."lang/system/".$lang.".txt";


	include_once($fname);

	if($sysmessage[$id]) return stripslashes($sysmessage[$id]);
	elseif(is_numeric($id))
	{

		$q=selectall("lk_system where MessageID='$id'");

		if($q[$lang])
		{
		

			$file=fopen($fname,"a");

			if(!filesize($fname)&&!$sysmessage) fputs($file,"<?\r\n");
			$q[$lang]=addslashes($q[$lang]);
			if(!strstr($str,"message[$id]")) fputs($file,"\$sysmessage[$id] = '".setTags($q[$lang])."';\r\n");

			fclose($file);

			$sysmessage[$id]=stripslashes($q[$lang]);
			if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=messages\">$q[$lang]</a>]";
			elseif($q[$lang]) return set_params(setTags($q[$lang]));
			else return $id;

		}
		else return($id);
	}
	else return($id);

}


function text($id)
{
	global $lang,$adm,$textmessage,$site_path;

	//if(!file_exists($site_path."lang/texts/")) mkdir_r($site_path."lang/texts/");

	$fname=$site_path."lang/texts/".$lang.".txt";

	include_once($fname);

	if($textmessage[$id]) return stripslashes($textmessage[$id]);
	elseif(is_numeric($id))
	{

		$q=selectall("lk_texts where TextID='$id'");

		if($q[$lang])
		{
		

			$file=fopen($fname,"a");

			if(!filesize($fname)&&!$textmessage) fputs($file,"<?\r\n");
			$q[$lang]=addslashes($q[$lang]);
			if(!strstr($str,"message[$id]")) fputs($file,"\$textmessage[$id] = '".setTags($q[$lang])."';\r\n");

			fclose($file);

			$textmessage[$id]=stripslashes($q[$lang]);
			if($adm) return "[<a href=\"admin.php?act=update&id=$id&type=messages\">$q[$lang]</a>]";
			elseif($q[$lang]) return set_params(setTags($q[$lang]));
			else return $id;
		}
		else return($id);
	}
	else return($id);

}

function error($id)
{
	global $lang;

	if(!$lang) $lang="rus";

 return message($id)."<br>";
}


$secpass="dgkjhs45";


function dots($num)
{
    $separator=".";

 if($num=='') return $num;

 if(strstr($num,"."))
 {
	$ost1=substr($num,1+strpos($num,"."));
	$num=substr($num,0,strpos($num,"."));
 }

 if(!is_numeric(substr($num,0,1))) {$sign=substr($num,0,1); $num=substr($num,1);}


    $result = "".$num;
    $len = strlen($result);
    
    for($i = 0; $i < $len/3 - 1; $i++)
    {
        $k = ($i*3)+3;
        $result = substr($result,0,$len-$k).$separator.substr($result,$len-$k,$len);
    }

 if($sign) $result=$sign.$result;

 if($ost1) $result=$result.",".$ost1;


    return $result;
}





//выбор строки из базы-------------------------------------
function selectall($sql)
{
 if(substr($sql,0,6)!="select") $sql="select * from $sql";
 return select($sql);
}
//-------------------------------------------------------



/*
function attr($obj,$att,$lang)
{
	global $elm;
	$obj=strtoupper($obj);
	if($lang) $att=$att."_$lang";
	if($v=$elm->attributes[$att]) return $v;
}
*/

function xml_contents($xml_url)
{
	$tmp = new cls_xml();
	$tmp->Load($xml_url);
	return $tmp->documentElement;
}



function GetTour($r)
{
	global $lang;

	$q=select("select 
concat_ws(', ', 
if(r.Name_$lang;='',null,r.Name_$lang;), 
case r.reglament
WHEN 0 THEN if(r.Games=2,null,concat('$r[Tour]'-r.tour1+1,' Тур'))
WHEN 1 THEN concat('1/',power(2, floor((r.tour2-'$r[Tour]')/r.Games)+1),' финала')
WHEN 2 THEN if(r.Tour2-r.Tour1 <= r.Games ,null,concat(round(('$r[Tour]'-r.tour1+1)/r.Games),' Тур'))
Else  '$r[Tour]' end ,
if(r.Games=2, if(mod (r.tour2-'$r[Tour]',2),'первый матч','ответный матч'),null) ) 
from ut_reglaments r
where r.tour1<='$r[Tour]' and r.tour2>='$r[Tour]'
and r.TournamentID='$r[TournamentID]'");
	return $q[0];
}


function pnname1($id)
{
	global $lang,$site_url;

  $r=select("select Number,
Name_$lang as Name
 FROM ut_players where PlayerID='$id'");

 if(!$r[Number]) $r[Number]="";


  if($r[Name]) return "$r[Number] "."<a href=\"$site_url"."xml/players/info.php?id=$id\" class=black>".$r[Name]."</a>";
  elseif($id) return $id;
}

function pnname($id)
{
	global $lang;

  $r=select("select Number,
Name_$lang as Name
 FROM ut_players where PlayerID='$id'");

 if(!$r[Number]) $r[Number]="";

  if($r[Name]) return "$r[Number] ".$r[Name];
  elseif($id) return $id;
}



function mkdir_r($dirName, $rights=0777){
   $dirs = explode('/', $dirName);
   $dir='';
   foreach ($dirs as $part) {
       $dir.=$part.'/';
       if (!is_dir($dir) && strlen($dir)>0)
           mkdir($dir, $rights);
   }
}


    // Function that calculates the roman string to the given number: 
        function dec2roman($f) 
        { 
            // Return false if either $f is not a real number, $f is bigger than 3999 or $f is lower or equal to 0:         
                if(!is_numeric($f) || $f > 3999 || $f <= 0) return false; 

            // Define the roman figures: 
                $roman = array('M' => 1000, 'D' => 500, 'C' => 100, 'L' => 50, 'X' => 10, 'V' => 5, 'I' => 1); 
         
            // Calculate the needed roman figures: 
                foreach($roman as $k => $v) if(($amount[$k] = floor($f / $v)) > 0) $f -= $amount[$k] * $v; 
             
            // Build the string: 
                $return = ''; 
                foreach($amount as $k => $v) 
                { 
                    $return .= $v <= 3 ? str_repeat($k, $v) : $k . $old_k; 
                    $old_k = $k;                 
                } 
             
            // Replace some spacial cases and return the string: 
                return str_replace(array('VIV','LXL','DCD'), array('IX','XC','CM'), $return); 
        } 
     
    // echo dec2romen(1981); 
     
     
    // Function to get the decimal value of a roman string: 
        function roman2dec($str = '') 
        { 
            // Return false if not at least one letter is in the string: 
                if(is_numeric($str)) return false; 
         
            // Define the roman figures: 
                $roman = array('M' => 1000, 'D' => 500, 'C' => 100, 'L' => 50, 'X' => 10, 'V' => 5, 'I' => 1); 
         
            // Convert the string to an array of roman values: 
                for($i = 0; $i < strlen($str); $i++) if(isset($roman[strtoupper($str[$i])])) $values[] = $roman[strtoupper($str[$i])]; 
             
            // Calculate the sum of that array: 
                $sum = 0; 
                while($current = current($values)) 
                { 
                    $next = next($values); 
                    $next > $current ? $sum += $next - $current + 0 * next($values) : $sum += $current; 
                } 
                 
            // Return the value: 
                return $sum; 
        } 

         
function printdec2roman($n)
{
  echo dec2roman($n);   
}

require($engine_path."cls/common/cls_xml.php");
require($engine_path."cls/images/cls_image.php");
require($engine_path."cls/common/cls_db.php");
require($engine_path."cls/common/cls_root.php");
require($engine_path."cls/common/cls_menu.php");
require($engine_path."cls/common/cls_form.php");


?>