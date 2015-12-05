<?



		require('helper.php');
if($id)
{

		
//---dynamic localization Локализация строк 

		echo "<script>\nfunction getLocaleString(id)\n{\n";
		foreach(array_keys($fields["additionaldata"]) as $key)
		{
			$control = $fields["additionaldata"][$key];
			echo "if(id=='".$key."')return '".$control->caption."';\n";
		}
		echo "return id;\n}</script>";
		
//---abilities Перечисление названий умений

		echo "<script>\nfunction getAbilityName(id)\n{\n";
		$res=runsql("select Ability,Name_".$lang." from ut_abilities where AbilityID>0 and AbilityID<=6");
		while($data = mysql_fetch_row($res))
		{
			echo "if(id=='".$data[0]."')return '".$data[1]."';\n";
		}
		echo "return id;\n}</script>";
		
	?>
	<link rel=stylesheet HREF="css.css" type="text/css">



	<span id=tttt></span>
	<script src="browserCommon.js"></script>
	<script src="hint.js"></script>
	<script src="players.js"></script>
	<script src="zones.js"></script>
	<script src = "combobox.js"></script> 
	<script src = "composition.js"></script> 
	<script src = "util.js"></script>
	<script src = "replacements.js"></script> 
	<script src = "tasks.js"></script> 
	<script src = "sending_data.js"></script> 
	<script src = "slider.js"></script> 
	<script>
		var common = new Common();
		var players = new Array();
		var zones = new Array();
		var replacements = new Array();
		var draging = false;
		var mouseX=0,mouseY=0;
		var square = null;
		var kitID = 0;
		var gkHeight = 0;
		var gkTop = 0;
		var defHeight = 0;
		var defTop = 0;
		var mDefHeight = 0;
		var mDefTop = 0;
		var forvHeight = 0;
		var forvTop = 0;
		var site_url = "<? echo $site_url; ?>";
		
		var enginePath = "<? echo $_SERVER["SERVER_ROOT"]; ?>";
		initHint();

		document.onmousemove = function ChangeMouseCoord(e)
		{
			mouseX = e ? e.pageX : event.clientX+document.body.scrollLeft;
			mouseY = e ? e.pageY : event.clientY+document.body.scrollTop;
		}
		

		<?

		$plCount = count($glad2);

		print "var playersCount=".(($plCount)?$plCount:"0").";\n";

		$i=0;
		foreach($glad2 as $k=>$v)
		{
			
			$players[$i]=$glad2[$k];

			$v[GladiatorID]=$k;
	
			print "\nplayers[$i] = new Player();";

			$r=$v;
			foreach(array_keys($r) as $key)
			{
				if($key != "Health" && $key != "Gladiator" && $key != "ShowExp")
				{
					$r[$key]=trim($r[$key]);
					echo "players[$i].$key = \"$r[$key]\";\n";
				}

			}
			echo "players[$i].name = \"".$r[Name]."\";";

			$i++;
		}



//рисуем зоны---------------------

		$zc=25;

		print "zonesCount=$zc;\n";

		$zonesFunc = "function getZoneByXY(x,y)\n{";

		for($i=0;$i<$zc;$i++)
		{
			$line = $arr[$i];
			$lineArr = explode(" ",$line);

			$b1=($i-$i%5)*4;
			$a1=($i%5)*20;

			print "zones[".$i."] = new Zone(\"Zn".($i+1)."\",".$a1.",".$b1.",20,20);\n";

			$zonesFunc .= "if(x>zones[$i].X1 && x<zones[$i].X2 && y>zones[$i].Y2 && y<zones[$i].Y1)\n return zones[$i];\n";
		}

		$zonesFunc .= "}\n";

		print "\n //zones func\n".$zonesFunc;
		
		
		?>
	</script>



	
<!-- ************TABS************* -->
	<div id=savedialog style="position:absolute;background-color:white;z-index:1000;display:none; left:100; width:200;border:1px solid;">
		<div style="float:left;padding:3"  class=header><b>Сохранение</b></div>
		<div style="text-align:right;padding:3" class=header>
			<span style="cursor:pointer" onclick="document.getElementById('savedialog').style.display='none';">x</span>
		</div>
		<script>



			function fillFilename(anchor)
			{
				document.getElementById('savingFileName').value = anchor.innerHTML;
			}
		</script>	
		



	</div>	
	
	<div id=savedialogtour style="position:absolute;background-color:white;z-index:1000;display:none; left:100; width:300;height:70px;border:1px solid;">
		<div style="float:left;padding:3"  class=header><b>Сохранение</b></div>
		<div style="text-align:right;padding:3" class=header>
			<span style="cursor:pointer" onclick="document.getElementById('savedialogtour').style.display='none';">x</span>
		</div>
				
		
	</div>	

<table border=0 cellspacing=0><td>

	<div id="container" style='' unselectable = "on">

	<div id=message_container class=message style="">
			<span style=""; id=systemMessage>&nbsp;</span>
	</div>

	<!-- captions -->
		<?
				
		if($id)
		{
			print "<script>ShowSystemMessage('Загрузка...')</script>";
		}

		$i = 0;
		foreach(array_keys($fields) as $cap)
		{
			$_class = ($i == 0)?"firsttabcaption":"tabcaption";
			$i++;
		}
			
		?>

	<!-- endcaptions -->

	<!-- layers -->
		
		<!-- composition -->

		<div id=tab1 style="background-image: url(
<?
if($tournament[TypeID]==1||!$id||($tournament[TypeID]!=2&&!$tournament[LimitGlad])) print "top.gif";
elseif($tournament[TypeID]==2) print "s1.gif";
else print "s".$tournament[LimitGlad].".gif";
?>
		);position:relative; background-repeat:no-repeat; visibility: visible" class=tab>
		<?

		$topPos = 5;
		$coef = 30;
		$tops = "forvTop = ".$topPos.";\n";
		$currHeight = (10)*$coef;
		$heights = "forvHeight = ".$currHeight.";\n";

		$form->draw();


	
					print  "<br><table border=0 width=300px bgcolor=78746C cellspacing=1 cellpadding=3>";

if($tournament[TypeID]==1||!$id)
{

					print "<tr bgcolor=515E64><td>Расстановка</td><td>";
?>
	<span id="schema_block">
	<select id=schemas onchange="schema_change(this.value)">
		<option value=0>пользовательская</option>
		<?
			$schemas = explode("\n",file_get_contents("schemas.dat"));
			foreach($schemas as $schema)
			{
				$content = explode(":",$schema);
				echo "\n<option value='".$content[1]."'>".$content[0]."</option>";
			}
		?>
	</select>
	</span>
<?
			print "</td>";

			print "<tr bgcolor=3B484C><td>Лидер</td><td>";
			?>
			<select name=LeaderID onchange="UnhighLightZones();">
			<option value=0>-</option>
			<?
			foreach($players as $k=>$v)
			{
				print "<option value=$v[GladiatorID]>$v[Name] [$v[Level]]</option>";
			}
			?>
			</select>
			<?

			print "</td></tr><tr bgcolor=515E64  ><td>Тактика</td><td>";
			DrawControl("squad","Tactic", "id='Tactic'");

}


if($id)
{
	$q=$tournament;

	print "<tr bgcolor=3B484C><td>Таймаут</td><td><input type=\"text\" id=\"Timer\" style=\"border:0;background-color:3B484C;color:E5CEA6\" readonly size=4></td></tr>";

	$limitglad=$q[LimitGlad];
	$extra=$q[ExtraGlad];
	$limitskl=$q[LimitSkl];

	print "<input id=GladLimit type=hidden value=$q[LimitGlad]>";
	print "<input id=SklLimit type=hidden value=$q[LimitSkl]>";
	print "<input id=Extra type=hidden value=$q[ExtraGlad]>";
}
else
{
	print "<input id=GladLimit type=hidden value=7>";
	print "<input id=SklLimit type=hidden value=0>";
	print "<input id=Extra type=hidden value=1>";
}


					print "</table>";

	$sendData = ($id)?"send_data(0,null,$id,0)":"open_saveDialog(true)";

	print "<div style='margin-top:10px;'>
<table border=0 bgcolor=78746C cellspacing=1 cellpadding=6>
<td bgcolor=#515E64><a href='javascript:$sendData;' class='blue'><img src=\"/images/icons/save.gif\" width=16px height=14px border=0  align=\"absmiddle\"><b> ".message(175)."</a>
</td></table>";


	//if($form->hint) print "<br><div id='hintdiv' >".hint($form->hint,$form->pageid,$form->name)."</div>";


print "</div>";






?>

<script language="JavaScript">

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

<?

$timeout=(($tournament[Date]+$tournament[Timeout]*60)-mktime());


if($timeout<0) $timeout=0;

$seconds=$timeout%60;
$minutes=($timeout-$seconds)/60;
?>
	cmin=<?=$minutes?>;
	csec=<?=$seconds?>;
	DownRepeat(); 
}




function DownRepeat() 
{

	csec--;

	if(csec==-1) { csec=59; cmin--; }

	window.status="На отправку состава осталось "+Display(cmin,csec);
	document.getElementById("Timer").value=Display(cmin,csec);

	if((cmin<=0&&csec<=0)||(cmin<0) ) 
	{
		alert("Время истекло");document.location.href='/xml/arena/fight.php?id=<?=$id?>';
	}
	else 	
	{
		if((cmin==1) && (csec==0)) document.getElementById("Timer").style.color='red';

		down=setTimeout("DownRepeat()",1000); 
	}
		
}		

<?if($id) print "Down() ;";?>

	    		<? echo $tops.$heights;?>


	    		makePlayersAndZones();



			document.getElementById("GladLeft").value=document.getElementById("GladLimit").value; 
			document.getElementById("SklLeft").value=document.getElementById("SklLimit").value;  


	    	</script>


		</div>

				 

		<!-- tasks -->	
		<div id=tab2 class=tab>				 
			<table border=0 width=100% bgcolor=78746C cellspacing=1 cellpadding=3>
					<?
						echo "<tr bgcolor=515E64 ><td>Атака</td><td>";
						DrawControl("tasks","Attack","id='Attack'");


					?>
			</table>
		</div>
			

		<!-- replacemnets -->
		<div id=tab3 class="tab scrolable">
			<button style = "margin: 5px;" class="button" onclick = "newsubs()"><?echo $fields["additionaldata"]["addSubs"]->caption;?></button>
			<span id=dynContainer2></span>
		</div>	

	<!-- endlayers -->
	

	</div>

</table>
	

<?





//форма для отправки данных------------------------------
?>
	
<!-- ************END TABS************* --> 			
	<form id="saving_form" action="send.php?start_debug=1" style="display:none" target="data_frame" method="POST">
		<input type=text name="filename" />
		<input type=text name="id" />
		<input type=text name="load" />

		<input type=text name="leader" />
		<input type=text name="tactic" />
		<input type=text name="zones" />
		<input type=text name="players" />

	</form>


		<script>

		processSliders();


		//show_tab(1);

		<?

		echo "window.onload = function()";
		?>
		{
			
			square = document.getElementById("tab1");
			square.onmousemove = Drag;	
			square.onmousedown = SetTargetObject;		
			square.onmouseup = EndDrag;
			
		
		}
			var bgImage = new Image(75,20);
			bgImage.src = "back.gif";
			var btImage = new Image(9,20);
			
			btImage.src = "slider.gif";

			//MakeSlider(document.getElementById("match_tactics"),bgImage,btImage,0,100,"суперзащитная(0:20),защитная(21:40),нормальная(41:60),атакующая(61:80),суператакующая(81:100)");

	</script>


<?

}

//if($id) unset($form);
	require($site_path."bottom.php");

	if($id)
		echo "<iframe src='send.php?id=$id&first=true&limitglad=$limitglad&extra=$extra&limitskl=$limitskl' id='saving_frame' name='data_frame' style='display:none' />";
	//else
		//echo "<iframe id='saving_frame' name='data_frame' style='display:none' />";
?>	