<?
header("Content-type: text/html;charset=windows-1251");
require($_SERVER["DOCUMENT_ROOT"].'/config.php');
	require($engine_path."cls/auth/session.php");

	echo "<html><body>";
	$delete_orderID = $_GET["delete_order"];
	if($delete_orderID)
	{

		if($auth->team)
		{
			$res = mysql_query("delete from ut_orders where OrderID=$delete_orderID and TeamID=$auth->team");
			if($res)
			{
				echo "
				<script>
					//delete order record
					//window.parent.document.getElementById('ordertr$delete_orderID').parentNode.removeChild(window.parent.ordertr$delete_orderID);
				</script>



				";
			}

		}
		exit;
	}
	$gam_version=0x01000000;
	$fc_version=0x01000000;
	$ord_version=0x01000000;

	$gam_md5key="pobeda";
	$ord_md5key="RULEZ";
	$fc_md5key="HZ";
	$print = $_GET["print"];
	$cur_ver=1;
	$team = $auth->team;
	$id = $_POST["id"];
	if(!$id)
		$id = $_GET["id"];
	$order = null;

	$tournamentId = $_POST["tour"];

	if($id)
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

/*
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

			if($r[OrderFile] && $r[Date]>$date) $order=$r[OrderFile];
*/
			if($r[OrderFile]) $order=$r[OrderFile];
	}

	if($print != 1)
	{
		if($_POST["load"] || ($_GET["id"] && $_SERVER['REQUEST_METHOD']!='POST'))
		{
			load($order);
		}
		else
		{
			echo "3";

			mysave();
		}
	}
	else
	{
		echo "4";
		//$res = mysql_query("select OrderTeam1,OrderTeam2 from ut_matches where MatchID='$id'");
		$data = mysql_fetch_row($res);
		$arr1 = unpack_data($data[0]);
		$arr2 = unpack_data($data[1]);

		foreach($arr1 as $key => $value)
		{
			if(!$arr2[$key])
				$arr2[$key] = "[empty]";

		}
		foreach($arr2 as $key => $value)
		{
			if(!$arr1[$key])
				$arr1[$key] = "[empty]";
		}
		echo "<table border=1>";
		echo "<tr><td>название значения</td><td>команда 1</td><td>команда 2</td></tr>";
		foreach($arr1 as $key => $value)
		{

			echo "<tr><td>$key</td><td>$arr1[$key]</td><td>$arr2[$key]</td></tr>";

		}
		echo "</table>";

		exit;
	}

	function unpack_data($data)
	{
		$arr = Array();
		$str = unpack("a32key",$data);
		$arr["md5"] = $str["key"];
		$data = substr($data,32);

		$str = unpack("a3key",$data);
		$arr["ord"] = $str["key"];
		$data = substr($data,3);
		//version
		$str = unpack("Lkey",$data);
		$arr["version"] = $str["key"];
		$data = substr($data,4);
		//match_type
		$str = unpack("Ckey",$data);
		$arr["match_type"]= $str["key"];
		$data = substr($data,1);

		if($arr["match_type"]==1)
		{
			$str = unpack("Ckey",$data);
			$arr["friendly_type"]=$str["key"];
			$data = substr($data,1);
			if($str["key"]==0)
			{
				$str = unpack("a3key",$data);
				$res = mysql_query("select TeamID from ut_teams where ShortName='".$str["key"]."'");
				$d = mysql_fetch_row($res);
				$arr["friendly_command"]=$d[0];
				$data = substr($data,3);
			}
		}
		//tactic,passes,strategy,pressing
		$str = unpack("Ckey",$data);
		$arr["tactic"]= $str["key"];
		$data = substr($data,1);

		$str = unpack("Ckey",$data);
		$arr["passes"]= $str["key"];
		$data = substr($data,1);

		$str = unpack("Ckey",$data);
		$arr["strategy"]=$str["key"];
		$data = substr($data,1);

		$str = unpack("Ckey",$data);
		$arr["pressing"]=$str["key"];
		$data = substr($data,1);

		//zones
		$str = unpack("Ckey",$data);
		$arr["zonesCount"]=$str["key"];
		$data = substr($data,1);
		for($i=0;$i<$arr["zonesCount"];$i++)
		{
			$str = unpack("Ckey",$data);
			$arr["zone".$i]=$str["key"];
			$data = substr($data,1);
		}

		//players
		//$str = unpack("Ckey",$data);
		//$arr["playersCount"]=$str["key"];
		//$data = substr($data,1);
		for($i=0;$i<11;$i++)
		{
			$str = unpack("Lkey",$data);
			$arr["player".$i]=$str["key"];
			$data = substr($data,4);
		}
		//reserveplayers
		$str = unpack("Ckey",$data);
		$arr["reservePlayersCount"]=$str["key"];
		$data = substr($data,1);
		for($i=0;$i<$arr["reservePlayersCount"];$i++)
		{
			$str = unpack("Lkey",$data);
			$arr["reservePlayer".$i]=$str["key"];
			$data = substr($data,4);
		}

		//subscount
		$str = unpack("Ckey",$data);
		$arr["subsCount"]=$str["key"];
		$data = substr($data,1);
		//subs
		for($i=0;$i<$arr["subsCount"];$i++)
		{
			$str = unpack("Lkey",$data);
			$arr["subsPlayerIn".$i]=$str["key"];
			$data = substr($data,4);

			$str = unpack("Lkey",$data);
			$arr["subsPlayerOut".$i]=$str["key"];
			$data = substr($data,4);

			$str = unpack("Ckey",$data);
			$arr["subsType".$i]=$str["key"];
			$data = substr($data,1);
			$subType = $arr["subsType".$i];
			if($subType == 2 || $subType == 3)
			{
				$str = unpack("Ckey",$data);
				$arr["subsTime".$i]=$str["key"];
				$data = substr($data,1);
			}
			if($subType == 4 || $subType == 5)
			{
				$str = unpack("Ckey",$data);
				$arr["subsGoalsToken".$i]=$str["key"]+1;
				$data = substr($data,1);
				$str = unpack("ckey",$data);
				$arr["subsGoalsCount".$i]=$str["key"];
				$data = substr($data,1);
			}
			if($subType == 6 || $subType == 7)
			{
				$str = unpack("Ckey",$data);
				$arr["subsTime".$i]=$str["key"];
				$data = substr($data,1);
				$str = unpack("Ckey",$data);
				$arr["subsGoalsToken".$i]=$str["key"]+1;
				$data = substr($data,1);
				$str = unpack("ckey",$data);
				$arr["subsGoalsCount".$i]=$str["key"];
				$data = substr($data,1);
			}

		}
		//roles
		$str = unpack("Ckey",$data);
		$arr["captainCount"]=$str["key"];
		$data = substr($data,1);
		if($arr["captainCount"])
		{
			$str = unpack("Lkey",$data);
			$arr["captain"]=$str["key"];
			$data = substr($data,4);
		}
		$str = unpack("Ckey",$data);
		$arr["leftCornersCount"]=$str["key"];
		$data = substr($data,1);
		if($arr["leftCornersCount"])
		{
			$str = unpack("Lkey",$data);
			$arr["leftCorners"]=$str["key"];
			$data = substr($data,4);
		}
		$str = unpack("Ckey",$data);
		$arr["rightCornersCount"]=$str["key"];
		$data = substr($data,1);
		if($arr["rightCornersCount"])
		{
			$str = unpack("Lkey",$data);
			$arr["rightCorners"]=$str["key"];
			$data = substr($data,4);
		}
		$str = unpack("Ckey",$data);
		$arr["freeKickCount"]=$str["key"];
		$data = substr($data,1);
		if($arr["freeKickCount"])
		{
			$str = unpack("Lkey",$data);
			$arr["freeKick"]=$str["key"];
			$data = substr($data,4);
		}
		$str = unpack("Ckey",$data);
		$arr["penaltyCount"]=$str["key"];
		$data = substr($data,1);
		if($arr["penaltyCount"])
		{
			$str = unpack("Lkey",$data);
			$arr["penalty"]=$str["key"];
			$data = substr($data,4);
		}
		//tasks
		$str = unpack("Ckey",$data);
		$arr["tasksTypesCount"]=$str["key"];
		$data = substr($data,1);
		for($i=0; $i<$arr["tasksTypesCount"];$i++)
		{
			//players count
			$str = unpack("Ckey",$data);
			$arr["tasksPlayersCount".$i]=$str["key"];
			$data = substr($data,1);
			//type
			$str = unpack("Ckey",$data);
			$arr["tasksType".$i]=$str["key"];
			$data = substr($data,1);

			for($j=0;$j<$arr["tasksPlayersCount".$i];$j++)
			{
				//type
				$str = unpack("Lkey",$data);
				$arr["tasksType".$i."PlayerID".$j]=$str["key"];
				$data = substr($data,4);
			}
		}
		return $arr;
	}
	function pack_data()
	{
		global $tournament,$ord_md5key;

		$zones = explode(';',$_POST["zones"]);
		$players = explode(';',$_POST["players"]);
		$reserveplayers = explode(';',$_POST["reserveplayers"]);

		$match_type = explode(";",$_POST["match_type"]);
		$match = explode(";",$_POST["match"]);

		$data = "";

		$data .= pack("a3","ORD");
		$data .= pack("L",1);
		//match
		if($tournament == 0)
		{
			$data .= pack("C",$tournament);
		}
		else
		{
			$data .= pack("C",0);
			/*if($match_type[0] === "1")
			{
				$data .= pack("C",$match_type[1]);
				if($match_type[1] === "0")
				{
					//echo "---".$match_type[2]."----";
					$res = mysql_query("select ShortName from ut_teams where TeamID='".$match_type[2]."'");
					$d = mysql_fetch_row($res);
					$data .= pack("a3",$d[0]);
				}
			}*/
		}


		$data .= pack("C",$match[0]);
		$data .= pack("C",$match[1]);
		$data .= pack("C",$match[2]);
		$data .= pack("C",$match[3]);
		//print_r($match);

		//zones
		$data .= pack("C",$zones[0]);
		for($i=1;$i<count($zones);$i++)
			$data .= pack("C",$zones[$i]);
		//players
		//$data .= pack("C",$players[0]);
		for($i=1;$i<=11;$i++)
			$data .= pack("L",$players[$i]);
		//reserveplayers
		$data .= pack("C",$reserveplayers[0]);
		for($i=1;$i<count($reserveplayers);$i++)
			$data .= pack("L",$reserveplayers[$i]);
		//subst
		//echo "----".$_POST["subs"]."----";
		$data .= pack("C",$_POST["subsCount"]);
		$subs = explode('|',$_POST["subs"]);
		for($i=0;$i<$_POST["subsCount"];$i++)
		{
			$sub = explode(';',$subs[$i]);
			//playerIn
			$data .= pack("L",$sub[0]);
			//playerOut
			$data .= pack("L",$sub[1]);
			//type
			$data .= pack("C",($sub[2]));
			if($sub[2] == 2 || $sub[2] == 3)
				$data .= pack("C",$sub[3]);//min
			if($sub[2] == 4 || $sub[2] == 5)
			{
				$data .= pack("C",$sub[3]);//token
				$data .= pack("c",$sub[4]);//goals_count
			}
			if($sub[2] == 6 || $sub[2] == 7)
			{
				$data .= pack("C",$sub[3]);//min
				$data .= pack("C",$sub[4]);//token
				$data .= pack("c",$sub[5]);//goals_count
			}


		}
		//roles
		//echo "----".$_POST["roles"]."----";
		$roles = explode(';',$_POST["roles"]);
		//captain
		if($roles[0])
		{
			$data .= pack("C",1);
			$data .= pack("L",$roles[0]);
		}
		else
			$data .= pack("C",0);
		//left corners
		if($roles[1])
		{
			$data .= pack("C",1);
			$data .= pack("L",$roles[1]);
		}
		else
			$data .= pack("C",0);
		//right corners
		if($roles[2])
		{
			$data .= pack("C",1);
			$data .= pack("L",$roles[2]);
		}
		else
			$data .= pack("C",0);
		//freekick
		if($roles[3])
		{
			$data .= pack("C",1);
			$data .= pack("L",$roles[3]);
		}
		else
			$data .= pack("C",0);
		//penalty
		if($roles[4])
		{
			$data .= pack("C",1);
			$data .= pack("L",$roles[4]);
		}
		else
			$data .= pack("C",0);
		//tasks
//		echo "***".$_POST["tasks"]."***";
		$tasks = explode('|',$_POST["tasks"]);
		$data .= pack("C",$tasks[0]);//types count
		for($i=1; $i<$tasks[0]+1;$i++)
		{
			$tskArr = explode(';',$tasks[$i]);
			$data .= pack("C",$tskArr[0]);//players count
			$data .= pack("C",$tskArr[1]);//type
			for($j=2;$j<$tskArr[0]+2;$j++)
			{
				$data .= pack("L",$tskArr[$j]);//playerID
			}
		}
		//$data .= pack("C4","\x00\x00\x00\x00"); //free bytes
		$data.=pack("C",0); //free bytes
		$data.=pack("C",0); //free bytes
		$data.=pack("C",0); //free bytes
		$data.=pack("C",0); //free bytes

		$data = md5($data.$ord_md5key).$data;
		return $data;

	}
	function load($orderData)
	{
		//echo "load";
		global $auth;
		global $tournamentId;
		$arr = null;
		if($orderData)
		{
			//$orderData=stripslashes($orderData);

			$arr = unpack_data($orderData);
		}
		else
		{
			if(!$tournamentId)
				$res = mysql_query("select OrderFile from ut_orders where name='".$_POST["filename"]."' and TeamID=".$auth->team);
			else
				$res = mysql_query("select OrderFile from ut_orders where tournamentId=$tournamentId and TeamID=".$auth->team);

			$data = mysql_fetch_row($res);
			if($data)
			{
				$arr = unpack_data($data[0]);
			}
			else
			{
				echo "can't find an order:".$_POST["filename"];
				return;
			}
		}
		foreach(array_keys($arr) as $key)
		{
//			echo $key." => ".$arr[$key]."<br>";
		}
		$nameWindow = ($_GET["id"] && !$_GET["first"])?"window":"window.parent";
		echo "
			$nameWindow;
			<script>

				var win = $nameWindow;\n
				win.clearTasks();
				for(i=0; i<win.zones.length;i++)\n
					for(j=0; j<win.zones[i].players.length;j++)\n
						win.SetPlayerToBase(win.zones[i].players[j].playerDiv,win.zones[i]);\n

				";

		$k = 0;
		for($i=0;$i<$arr["zonesCount"];$i++)
		{
			$playersInZone = $arr["zone".$i];
			for($j=0;$j<$playersInZone;$j++)
			{
				if($arr["player".($k)])
				{
					echo "win.AddPlayerToZoneById(win.zones[$i],".$arr["player".($k)].");\n";
					$k++;
				}
			}
		}
		for($i=0;$i<$arr["reservePlayersCount"];$i++)
		{
			echo "win.AddReservePlayer(".$arr[("reservePlayer".$i)].",".($i+1).");\n";
		}
		//match
		//echo "win.document.getElementById('match_type').value = 1;\n";
		//echo "win.match_type_cahnge(win.document.getElementById('match_type'));";

		echo "win.document.getElementById('match_tactics').value = 0;\n";
		echo "win.document.getElementById('match_passes').value = 0;\n";
		echo "win.document.getElementById('match_strategy').value =0;\n";
		echo "win.document.getElementById('match_pressing').checked = false;\n";

		/*echo "win.document.getElementById('match_type').value = ".$arr["match_type"].";\n";
		//echo "win.match_type_cahnge(win.document.getElementById('match_type'));";
		if($arr["match_type"]==1)
		{
			echo "win.document.getElementById('friendly_match_type').value = ".$arr["friendly_type"].";\n";
			echo "win.friendly_match_type_changed(win.document.getElementById('friendly_match_type'));";
			if($arr["friendly_type"]==0)
			{
				echo "win.document.getElementById('friendly_match_command').value = ".$arr["friendly_command"].";\n";
			}
		}*/
		echo "win.getSliderByInput(win.document.getElementById('match_tactics')).SetValue(".$arr["tactic"].");\n";
		echo "win.document.getElementById('match_passes').value = ".$arr["passes"].";\n";
		echo "win.document.getElementById('match_strategy').value = ".$arr["strategy"].";\n";
		echo "win.document.getElementById('match_pressing').checked = ".((1==$arr["pressing"])?"true":"false").";\n";


		//subst
		echo "win.clearSubs();";
		for($i=0;$i<$arr["subsCount"];$i++)
		{
			echo "win.newsubs();\n";
			echo "win.document.getElementById('subs_injury_checked".$i."').checked=false;\n";

			echo "win.document.getElementById('subsIn".$i."').value=".$arr["subsPlayerIn".$i].";\n";
			echo "win.document.getElementById('subsOut".$i."').value=".$arr["subsPlayerOut".$i].";\n";
			$subType = $arr["subsType".$i];
			if($subType == 1 || $subType == 3 || $subType == 5 || $subType == 7)
				echo "win.document.getElementById('subs_injury_checked".$i."').checked=true;\n";
			if($subType == 2 || $subType == 3 || $subType == 6 || $subType == 7)
			{
				echo "win.document.getElementById('subs_time_checked".$i."').checked=true;\n";
				echo "win.document.getElementById('subs_time".$i."').value=".$arr["subsTime".$i].";\n";
			}
			if($subType == 4 || $subType == 5 || $subType == 6 || $subType == 7)
			{
				echo "win.document.getElementById('subs_goals_checked".$i."').checked=true;\n";
				echo "win.document.getElementById('subs_goals_token".$i."').value=".$arr["subsGoalsToken".$i].";\n";
				echo "win.document.getElementById('subs_goals_count".$i."').value=".$arr["subsGoalsCount".$i].";\n";
			}
		}
		if($arr["captain"])
			echo "win.document.getElementById('role_Captain').value=".$arr["captain"].";\n";
		if($arr["leftCorners"])
			echo "win.document.getElementById('role_LeftCorners').value=".$arr["leftCorners"].";\n";
		if($arr["rightCorners"])
			echo "win.document.getElementById('role_RightCorners').value=".$arr["rightCorners"].";\n";
		if($arr["freeKick"])
			echo "win.document.getElementById('role_FreeKicks').value=".$arr["freeKick"].";\n";
		if($arr["penalty"])
			echo "win.document.getElementById('role_Penalties').value=".$arr["penalty"].";\n";

		//tasks
		$taskCount = 0;
		for($i=0; $i<$arr["tasksTypesCount"];$i++)
		{
			for($j=0;$j<$arr["tasksPlayersCount".$i];$j++)
			{
				echo "win.addTask();\n";
				echo "win.document.getElementById('task_task$taskCount').value='".$arr["tasksType".$i]."';\n";
				echo "win.document.getElementById('task_player$taskCount').value='".$arr["tasksType".$i."PlayerID".$j]."';\n";
				$taskCount ++;
			}
		}
		echo "</script>";

	}
	function mysave()
	{
		global $id;
		global $auth;
		global $tournamentId;
		echo "test";
		$orderData = pack_data();

		$ermess = checkorderBuilder($tournamentId,$orderData);




		if($ermess)
		{
			print "<script>alert('Ошибка сохранения ордера: ".$ermess."')</script>";
			return;
		}
		if($id > 0)
		{

			$orderData=addslashes($orderData);


			$q=select("select TournamentID from ut_matches where MatchID='$id'");
			$tournamentId=$q[0];
			$ip = $_SERVER['REMOTE_ADDR'];
			mysql_query("delete from ut_orders where TeamID='$auth->team' and TournamentID='$tournamentId'");
			mysql_query("insert into ut_orders(TeamID,Name,Date,IP,OrderFile,TournamentID,Tour) values(".$auth->team.",'".$name."',UNIX_TIMESTAMP(),'$ip','$orderData',$tournamentId,".
			"(1+ coalesce((
select Tour from ut_maxtour where TournamentID='$tournamentId' limit 0,1
) ,0)))");

			//mysql_query("update ut_matches set OrderTeam1='$orderData',DateOrder1=unix_timestamp() where MatchID='$id' and TeamID1='$auth->team'");

			//mysql_query("update ut_matches set OrderTeam2='$orderData',DateOrder2=unix_timestamp() where MatchID='$id' and TeamID2='$auth->team'");


		}
		else if($tournamentId > 0)
		{
			Echo "TOUR";
			mysql_query("delete from ut_orders where TeamID='$auth->team' and TournamentID='$tournamentId'");
			mysql_query("insert into ut_orders(TeamID,Name,Date,IP,OrderFile,TournamentID,Tour) values(".$auth->team.",'".$name."',UNIX_TIMESTAMP(),'$ip','$orderData',$tournamentId,".
			"(1+ coalesce(
(select Tour from ut_maxtour where TournamentID='$tournamentId' limit 0,1) ,0)))");
		}
		else
		{

			$ip = $_SERVER['REMOTE_ADDR'];
			$name = $_POST["filename"];
			$res = mysql_query("select OrderID from ut_orders where IP='".$ip."' and Name='".$name."'");

			if($data = mysql_fetch_row($res))
			{
				$res=mysql_query("update ut_orders set TeamID=".$auth->team.",Name='$name',Date=UNIX_TIMESTAMP(),IP='$ip',OrderFile='$orderData' where OrderID = ".$data[0]);
			}
			else
			{
				$res=mysql_query("insert into ut_orders(TeamID,Name,Date,IP,OrderFile)values(".$auth->team.",'".$name."',UNIX_TIMESTAMP(),'$ip','$orderData')");
				$res=mysql_query("select Name,OrderID from ut_orders where TeamID=".$auth->team." and Name='$name'");
				$data=mysql_fetch_row($res);
				echo "<script>window.parent.appendNewFileName('$data[0]',$data[1]);</script>";

			}
		}
	}




function checkorderBuilder($tournament, $order)
{
	echo "hello";
	global $HTTP_POST_FILES,$i,$lang,$buf,$ord_version,$cur_ver,$ord_md5key,$auth;

	$name="Order";
	if(!$order)
	{
		$f['name']=$HTTP_POST_FILES[$name]['name'][$i];
		$f['tmp_name']=$HTTP_POST_FILES[$name]['tmp_name'][$i];
		$f['size']=$HTTP_POST_FILES[$name]['size'][$i];
		$f['type']=$HTTP_POST_FILES[$name]['type'][$i];


		if(substr($f['name'],0,3)!=$auth->user) $er.="Неправильное название файла<br>";
		if(substr($f['name'],strpos($f['name'],".")+1)!="ord") $er.="Неправильный формат файла<br>";

		$file = fopen($f['tmp_name'],"r");

		$buf=fread($file,filesize($f['tmp_name']));
		fclose($file);
	}else
	{
		$buf = $order;
	}


	$md=cut(32);

	if($buf&&!$er)
	{
		//проверка md5------------------------------
		if(strtoupper($md)!=strtoupper(md5($buf.$ord_md5key))) $er="Нельзя исправлять файл вручную<br>";


		if(cut(3)!="ORD") $er= "Неправильный файл. Скачайте новую версию билдера (не ниже 0.7.7.7) в разделе Файлы";

		if(substr($buf,strlen($buf)-4)!="\x00\x00\x00\x00") $er= "Неправильный файл. Скачайте новую версию билдера (не ниже 0.7.8.2) в разделе Файлы";

		if(!$er)
		{

			$a= unpack("Lversion/Ctype",cut(5));
			//проверка версии-------------------------------------

			$version= $a[version];
			if($version!=$cur_ver) $er.="Скачайте новую версию Билдера!";


			if($a[type]==1)
			{
				$optype= unpack("Cop",cut(1));
				$pod=$optype[op];
				if($pod==0)
	 			{
					$op= unpack("a3op",cut(3));
					$op=$op[op];
				}
			}

			$tactics= unpack("Ctac/Cper/Cstrat/Cpress/Cscheme",cut(5));

			//схема----------------------------------
			for($i=1;$i<=$tactics[scheme];$i++)
			{
				$p=unpack("Cnum",cut(1));
				$num=$p[num];
				unset($p);
			}

			unset($ar);

			//игроки основы-------------------------
			for($i=1;$i<=11;$i++)
			{
				unset($a);
				$a= unpack("Lidp",cut(4));

	        		$idp=$a[idp];
				$ar[$idp]++;

	        		$q=select("select *,Name_$lang as Name from ut_players where PlayerID='$idp'");


				if(!$q[0]) $er.="Игрок не найден";
				elseif($q[TeamID]!=$auth->team) $er.=$q["Name_$lang"].". Игрок не в Вашей команде!";
				elseif($q[Injury]>0) $er.=$q["Name_$lang"].". травмирован!";



$q1=selectall("ut_disqualify where PlayerID='$idp' and TournamentID='$tournament' and Tour+Term>=(
select Tour+1 from ut_maxtour where TournamentID='$tournament' limit 0,1
)");

//$er=" $tournament ";
	        		if($q1[0]) $er.="Игрок номер $q[Number] дисквалифицирован!";

//$er="тестирование, зайдите позже. $a $tournament =$q[Name] $idp";
			}



			$subs= unpack("Csubs",cut(1));
			$subs=$subs[subs];

			//игроки запаса----------------------------------
			for($i=1;$i<=$subs;$i++)
			{

				unset($a);
				$a= unpack("Lidp",cut(4));

	        		$idp=$a[idp];
				$ar[$idp]++;

	        		$q=selectall("ut_players where PlayerID='$idp'");


				if(!$q[0]) $er.="Игрок не найден";
				elseif($q[TeamID]!=$auth->team) $er.=$q["Name_$lang"].". Игрок не в Вашей команде!";
				elseif($q[Injury]>0) $er.=$q["Name_$lang"].". травмирован!";

	        		$q1=selectall("ut_disqualify where PlayerID='$idp' and TournamentID='$tournament' and Tour+Term>=(
select Tour+1 from ut_maxtour where TournamentID='$tournament' limit 0,1)");
	        		if($q1[0]) $er.="Игрок номер $q[Number] дисквалифицирован!";
			}



			foreach($ar as $v)
			{
				if($v>1) $er.="Игрок дублируется";
			}


	//как запретить совмещение турниров? ------------

			$tmp= unpack("Lnum",cut(4));
			$zam=$tmp[num];
		}

	}


	if($er)
	{
		mysql_query("set @error='$er'");
	}

	return $er;
}
	echo "<span id=isloaded>done</span><script>window.parent.HideSystemMessage();</script></body></html>";
$db->close();
?>
