<?
header("Content-type: text/html;charset=windows-1251");
require($_SERVER["DOCUMENT_ROOT"].'/config.php');

	require($engine_path."cls/auth/session.php");

	echo "<html><body>";




	$delete_orderID = $_GET["delete_order"];



	if($delete_orderID)
	{

		if($auth->user)
		{
			//$res = mysql_query("delete from ut_orders where OrderID=$delete_orderID and UserID=$auth->user");


		}
		exit;
	}


	if($id)
	{

			//выбираем ордер по матчу
			//if($r[OrderFile]) $order=$r[OrderFile];
	}

	if($print != 1)
	{
		if($_POST["load"] || ($_GET["id"] && $_SERVER['REQUEST_METHOD']!='POST'))
		{
			load($order);
		}
		else
		{
			mysave();
			if($_GET["id"]) 
			{

				$nameWindow = "window.parent";
			

				

				if(!$er) print "<script>var win = $nameWindow;\nwin.document.location.href='/xml/arena/fight.php?id=".$_GET["id"]."'</script>";
			}
		}
	}

	function unpack_data($data)
	{
		return unserialize(substr($data,39));
	}

	function pack_data()
	{
		global $secpass,$site_path,$auth;

//print "<script>alert('err');</script>";
//exit;
if($_POST[id])
{
		$id=$_POST[id];
		$q=mysql_query("select TypeID,ExtraGlad,LimitGlad,LimitSkl from ft_agreements where RecordID='$id'");
		$q=mysql_fetch_array($q,1);
		$order=$q;
		$lim=$order[LimitGlad];
}
		$order[UserID]=$auth->user;


$players=explode(";",$_POST[players]);
$zones=explode(";",$_POST[zones]);

$i=0;
$j=1;

foreach($zones as $k)
{

	if($i>0&&$k==1)
	{
		$b=($i-1-($i-1)%5)/5+1;
		$a=($i-1)%5+1;


	$data=explode(":",$players[$j]);
	$playerid=$data[0];
	$order[Squad][$a][$b]=$playerid;
	$j++;


	$order[Tasks][$playerid]=0;//$data[1];//mt_rand(1,10);
	$order[Attack][$playerid]=$data[1];//mt_rand(30,70);
	$order[Power][$playerid]=$data[2];//mt_rand(30,70);
	$order[Block][$playerid]=$data[3];//mt_rand(30,70);
	$order[Courage][$playerid]=$data[4];//mt_rand(30,70);

	}


	$i++;
}

if($_POST[leader]) $order[LeaderID]=$_POST[leader];
if($_POST[tactic]) $order[Tactic]=$_POST[tactic];

$num=mt_rand(0,5);
for($i=0;$i<$num;$i++)
{
	//$order[Subs][$i]=array(mt_rand(0,100),mt_rand(0,1),mt_rand(1,4));
}

	$str=serialize($order);
	$data="ORD".pack("N",0x01000000).md5($str.$secpass).$str;

	return $data;

	}


	function load($orderData)
	{

		global $id,$auth,$limitglad,$extra,$limitskl,$auth,$site_path;

		$order = null;

		if($orderData)
		{

			$order = unpack_data($orderData);
		}
		else
		{



			if(!$id&&file_exists($site_path."files/preord/".$auth->user.".ord"))
			{


				$file=fopen($site_path."files/preord/".$auth->user.".ord","r");
				$data = fread($file,filesize($site_path."files/preord/".$auth->user.".ord"));
				$order = unpack_data($data);
				fclose($file);

			}
			elseif($id&&file_exists($site_path."files/ord/".$id."-".$auth->user.".ord"))
			{
				$file=fopen($site_path."files/ord/".$id."-".$auth->user.".ord","r");
				$data = fread($file,filesize($site_path."files/ord/".$id."-".$auth->user.".ord"));
				$order = unpack_data($data);
				fclose($file);
			}
			else
			{
				echo "can't find an order:".$_POST["filename"];
				return;
			}
		}

		$nameWindow = ($_GET["id"] && !$_GET["first"])?"window":"window.parent";
		echo "
			$nameWindow;
			<script>

				var win = $nameWindow;\n
				//win.clearTasks();
				for(i=0; i<win.zones.length;i++)\n
					for(j=0; j<win.zones[i].players.length;j++)\n
						win.SetPlayerToBase(win.zones[i].players[j].playerDiv,win.zones[i]);\n

				";

		$k = 0;



//$glad=$auth->rst[Gladiators];
$glad=get_gladiators($auth->user);
$auth->rst[Gladiators]=$glad;

foreach($order[Squad] as $a=>$k) 
{

	foreach($k as $b=>$p)
	{
		$zn=(($b-1)*5+$a)-1;
		if($p) $players[$zn]=$p;
	

	}
}

		$k = 0;

		$skl=0;
		for($i=0;$i<25;$i++)
		{
			if($players[$i])
			{
				$p=$players[$i];

				if($glad[$p][Injury]==0 && (!$limitglad||$limitglad>$k) && (!$limitskl||$limitskl>=$skl+$glad[$p][Level]) && ($extra || $glad[$p][TypeID]<9)) { echo "win.AddPlayerToZoneById(win.zones[$i],".$players[$i].");\n"; $skl+=$glad[$p][Level]; $k++;}

				
			}
		}






		if($order[LeaderID]) echo "if(win.document.getElementById('LeaderID')) win.document.getElementById('LeaderID').value = $order[LeaderID];\n";
		if($order[Tactic]) echo "if(win.document.getElementById('Tactic')) win.document.getElementById('Tactic').value = $order[Tactic];\n";
		echo "win.UnhighLightZones();";
	

		
/*

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
*/
		echo "</script>";

	}
	function mysave()
	{
		global $id,$er;
		global $auth,$site_path;
		global $tournamentId;

		$orderData = pack_data();

		$ermess = checkorderBuilder($orderData);

		if($ermess)
		{
			print "<script>alert('Ошибка сохранения ордера: ".$ermess."')</script>";
			$er=1;
			return;
		}


		if($id)
		{

			$file=fopen($site_path."files/ord/".$id."-".$auth->user.".ord","w");
			fputs($file,$orderData);
			fclose($file);

		}
		else
		{
			$file=fopen($site_path."files/preord/".$auth->user.".ord","w");
			fputs($file,$orderData);
			fclose($file);
		}


	}




function checkorderBuilder($order)
{
	global $HTTP_POST_FILES,$i,$lang,$buf,$ord_version,$cur_ver,$ord_md5key,$auth;

	$ar=unpack_data($order);
$glad=get_gladiators($auth->user);

	$cnt=0;
	$skl=0;

	foreach($ar[Squad] as $k=>$v)
	{
		$cnt+=count($v);
		if(!($k>0&&$k<6)) $er.="Неправильная позиция ";


if($ar[TypeID]!=1&&!($k==1)) $er.="Неправильная позиция ";

		foreach($v as $l=>$p)
		{

if($ar[TypeID]>2&&!(6-$l<=$ar[LimitGlad])) $er.="Неправильная позиция ";

if($ar[TypeID]==2&&!($l==5)) $er.="Неправильная позиция ";

			if(!($l>0&&$l<6)) exit;
			if(!$glad[$p]) $er.="Гладиатор $p не найден в Вашем отряде"." ";
			if($glad[$p][Injury]>0) $er.=$glad[$p][Name]." травмирован!"." ";
			if($glad[$p][TypeID]>7) $extra=1;
			$skl+=$glad[$p][Level];
		}
	}

	if($cnt==0) exit;

	if($cnt<$ar[LimitGlad]&&$ar[TypeID]==3) $er.="Вам необходимо выставить ровно $ar[LimitGlad] гладиаторов в серии поединков"." ";

	if($ar[LimitGlad]&&$cnt>$ar[LimitGlad]) $er.="Превышен лимит гладиаторов ($ar[LimitGlad]). "." ";
	if(round($ar[LimitSkl])&&round($skl)>round($ar[LimitSkl])) $er.="Превышен лимит мастерства гладиаторов ($ar[LimitSkl])"." ";
	if(!$ar[ExtraGlad]&&$extra) $er.="Специальные типы гладиаторов к этому бою не допускаются (лучники, конные и колесничьи)"." ";

	if($er)
	{
		mysql_query("set @error='$er'");
	}

	return $er;
}
	echo "<span id=isloaded>done</span><script>window.parent.HideSystemMessage();</script></body></html>";

$db->close();
?>
