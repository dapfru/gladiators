<?
require('../../config.php');
require($engine_path."cls/auth/session_lite.php");


$fname=gampath($id)."/".$id.".gam";


if($id&&file_exists($fname))
{

$file=fopen($fname,"r");
$str=fread($file,filesize($fname));
$ar=explode("RST",$str);

$game=unserialize(substr($ar[0],39,strlen($ar[0])-4-39));

$ar2=explode("ORD",$ar[1]);
$rst1=unserialize(substr($ar2[0],36));
$ord1=unserialize(substr($ar2[1],36));

$ar2=explode("ORD",$ar[2]);
$rst2=unserialize(substr($ar2[0],36));
$ord2=unserialize(substr($ar2[1],36));


$rst1[Gladiators]=repairHash($rst1[Gladiators]);
$rst2[Gladiators]=repairHash($rst2[Gladiators]);


$file=fopen(gampath($id)."/$id.rep","r");

$str=fread($file,filesize(gampath($id)."/$id.rep"));



$ar=unserialize($str);

}
?>
<html>
<head>
<title><?="$rst1[Login] vs $rst2[Login]"?></title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<link href="<?=$site_url?>css.css" rel="stylesheet" type="text/css"/>
<center>

  <table width=85% height=100% bgcolor=515E64 align="center" valign="top" border=0
 cellpadding=0 cellspacing=0>
  <!--verhnii>

  <!--sredni>
  <tr>

<td width=8px background="chain.gif" valign=top><img src=chain.gif width=4px height=6px></td>

<td width=100% style='padding:12' valign=top>
	<center>


<?




function repairHash($array)
{
  foreach ($array as $k => $v)
{

    $result[$k]=$v;
}
  return $result;    
}





if(!$id||!file_exists($fname))
{
	print icon("error","Ѕой не найден");
}
else
{


?>
<script src="hint.js"></script>
<script src="/builder/browserCommon.js"></script>

<script language="JavaScript">



var common = new Common();
var draging = false;
var mouseX=0,mouseY=0;
var pause=0;
var q=0;
var speed=1000;
var cnt=-1;
var gid=0;
var gid2=0;

var attacker=1;
var pause=0;

		document.onmousemove = function ChangeMouseCoord(e)
		{
			mouseX = e ? e.pageX : event.clientX+document.body.scrollLeft;
			mouseY = e ? e.pageY : event.clientY+document.body.scrollTop;
		}

function ch()
{
	if(pause==0)
	{
		document.game.pause.value="ѕродолжить";
		pause=1;
	}
	else
	{
		document.game.pause.value="ѕауза";
		pause=0;
	}
}

function ch2()
{
	if(pause==0)
	{
		document.game.pause.value="ѕродолжить";
		
	}
	pause=0;

	m_line();

	pause=1;
}

function startshow() 
{
	q++;


	if(q==2)
	{
		speed=1;
	}
	else
	{
		m_line();
	}
}

function m_line() {
 

	document.game.start.value="«акончить";

	if(pause!=1) 
	{
		 cnt++;
	}

	q=1;


	if(q==2)
	{
		speed=0;
	}

if (cnt<ar.length)
{


if(pause!=1)
{

 if(ar[cnt+2].substring(0,1)=="|") 
 {


	if(gid) document.getElementById("border"+gid).style.border='1px solid #515E64';
	if(gid2) document.getElementById("border"+gid2).style.border='1px solid #515E64';

   gid=ar[cnt];
   cnt++;
   gid2=ar[cnt];
   cnt++;

	document.getElementById("border"+gid).style.border='1px solid #D5D5D5';



   ar[cnt]=ar[cnt].substring(1,ar[cnt].length);


 document.getElementById("moments").innerHTML=ar[cnt].substring(0,ar[cnt].indexOf("width=100%"))+ar[cnt].substring(ar[cnt].indexOf(">"),ar[cnt].length);

   document.getElementById("momentsfull").innerHTML=ar[cnt]+'\r\n'+document.getElementById("momentsfull").innerHTML;


	document.getElementById("border"+gid2).style.border='1px solid #FF3939';
 }
 else
 {

 var type=ar[cnt];
 cnt++;

 var id=ar[cnt];
 cnt++;

 if(type>13) 
 {
	if(gid) document.getElementById("border"+gid).style.border='1px solid #515E64';
	if(gid2) document.getElementById("border"+gid2).style.border='1px solid #515E64';

 }



 document.getElementById("moments").innerHTML=ar[cnt].substring(0,ar[cnt].indexOf("width=100%"))+ar[cnt].substring(ar[cnt].indexOf(">"),ar[cnt].length);
 document.getElementById("momentsfull").innerHTML=ar[cnt]+'\r\n'+document.getElementById("momentsfull").innerHTML;


 if(type==14)
 {

   cnt++;
   gid=ar[cnt];

   cnt++;
   gid2=ar[cnt];


	document.getElementById("border"+gid).style.border='1px solid #FF3939';
	document.getElementById("border"+gid2).style.border='1px solid #FF3939';
 }

 if(type==10) 
 {
   cnt++;
   var id2=ar[cnt];
   cnt++;
   var hits=ar[cnt];


document.getElementById("Hits"+id2).value=document.getElementById("Hits"+id2).value-hits;
if(document.getElementById("Hits"+id2).value<0) document.getElementById("Hits"+id2).value=0;


if(document.getElementById("Hits"+id2).value<=0 ) 
{
	document.getElementById("player"+id2).style.filter="gray();";
	document.getElementById("player"+id2).style.MozOpacity=.25;
	document.getElementById("player"+id2).style.opacity=.25;

	document.getElementById("border"+id).style.border='1px solid #515E64';
}	



reloadplayer(id2,hits);

 setTimeout("reloadplayer("+id2+",0)", 1000);


 }


if(type>=50 && type<=59) 
{
	document.getElementById("player"+id).style.filter="gray();";
	document.getElementById("player"+id).style.MozOpacity=.25;
	document.getElementById("player"+id).style.opacity=.25;
	document.getElementById("border"+id).style.border='1px solid #515E64';
}


 }
}

if(pause==0) setTimeout('m_line()',speed);
}	


}


function pausecomp(millis) 
{
var date = new Date();
var curDate = null;

do { curDate = new Date(); } 
while(curDate-date < millis);
} 


function reloadplayer(id,hits)
{
	document.getElementById("stripe"+id).innerHTML=getStripe2(document.getElementById("Hits"+id).value,document.getElementById("FullHits"+id).value,eval(document.getElementById("Hits"+id).value)+eval(hits));

	document.getElementById("life"+id).innerHTML=document.getElementById("Hits"+id).value+'('+document.getElementById("FullHits"+id).value+')';
}

function getStripe(value, colorMake, koef)
{
	var result = "";
	if(!colorMake)
	{
		for(i=0;i<((value*100)/84);i++)
		{
			var color = "rgb("+i*4*3+","+i*4*3+","+(155+i*4)+")";
			result += "<span style='font-size:7px;background-color:"+color+"'>&nbsp</span>";
		}
	}
	else
	{
		if(koef)
		{
			value = Math.round(value*koef);
		}

		var color = "red";
		if(value >0 && value <= 40)
			color = "red";
		if(value >40 && value <= 60)

			color = "orange";
		if(value >60 && value <= 80)
			color = "yellow";
		if(value >80 && value <= 90)
			color = "lightgreen";
		if(value >90 && value <= 100)
			color = "green";
		result += "<div  style='float:left; margin-top: 3px;margin-right: 5px; background-color:"+color+";width:"+(value)+"px; font-size:7px'>&nbsp;</div>";
	}
	return result;
}



function getStripe2(value,  koef,value2)
{
	var result = "";


		if(koef)
		{
			value = Math.floor(value*100/koef);
		}

		if(value2)
		{
			value2 = Math.floor(value2*100/koef)-value;
		}


		var color = "red";
		if(value >0 && value <= 40)
			color = "red";
		if(value >40 && value <= 60)

			color = "orange";
		if(value >60 && value <= 80)
			color = "yellow";
		if(value >80 && value <= 90)
			color = "lightgreen";
		if(value >90 && value <= 100)
			color = "green";

		if(value<0) value=0;

		var border=1;

		if(value==0) {color="";border=0;}


if(value2&&(value2+value)==100) result += "<div style='width:50px;border:1px solid black;height:3px;background-color:#00A2FF;';'><div  style='border-right:"+border+"px solid black;float:left; background-color:"+color+";width:"+(value)+"%; height:3px;font-size:3px;'></div></div>";
else if(value2) 		result += "<div style='width:50px;border:1px solid black;height:3px';'><div  style='border-right:"+border+"px solid black;float:left; background-color:"+color+";width:"+(value)+"%;height:3px;font-size:3px'></div><div  style='float:left; background-color:#00A2FF;border-right:1px solid black;width:"+(value2)+"%;height:3px;font-size:3px'></div></div>";
else if(value<100)		result += "<div style='width:50px;border:1px solid black;height:3px';'><div  style='border-right:"+border+"px solid black;float:left; background-color:"+color+";width:"+(value)+"%; height:3px;font-size:3px;'></div></div>";
else		result += "<div style='width:50px;border:1px solid black;height:3px'><div  style='float:left; background-color:"+color+";width:"+(value)+"%; font-size:3px;height:3px'></div></div>";


	return result;
}



initHint();


</script>



<style>

.t {border:0; height:20px; padding: 1; border-spacing: 0;}
.t td {font-size:14px }
.red {background-color:#AD1414;border:1px solid #E5CEA6;width:10px;height:10px;float:left;margin-right:1px;font-size:5px}
.green {background-color:green;border:1px solid #E5CEA6;width:10px;height:10px;float:left;margin-right:1px;font-size:5px}
.lightblue {background-color:darkblue;border:1px solid #E5CEA6;width:10px;height:10px;float:left;margin-right:1px;font-size:5px}

</style>

<center>
<?



function gladiatorname($id)
{
	global $rst1,$rst2;


	$str="<b>";
	if($rst1[Gladiators][$id]) $str.= "<font color=#FF9600>".addslashes(trim($rst1[Gladiators][$id][Name]));
	elseif($rst2[Gladiators][$id]) $str.= "<font color=#D5D5D5>".addslashes(trim($rst2[Gladiators][$id][Name]));
	else $str.= $id;

	return $str."</font></b>";
}
function makecomment($v)
{
global $exchange,$b,$rst1,$rst2;


	$type=reset($v);

//print $type."<br>";

	if($b=="bgcolor=#3b484c") $b="bgcolor=#515e64";
	else $b="bgcolor=#3b484c";


	$id=next($v);
	$name=gladiatorname($id);


	if($type<=13) 
	{

		$udar='';

		$id2=next($v);
		$name2=gladiatorname($id2);

		$strength=next($v);
	 	$level=next($v);
		$kind=next($v);
		$battle_mode=next($v);
		$side=next($v);

		$s="быстрый удар";
		$st="быстрым ударом";

		if($strength=="1")
		{
			$s="сильный удар";
			$st="сильным ударом";
		}

		if($level=="1")
		{
			$s="удар по ногам";
			$st="ударом по ногам";
		}
		if(!$exchange)
		{

			$str="'$id','$id2', ";

			if($battle_mode)
			{
				$str.="'|<table  class=t width=100% $b><td>$name атаковал $name2 $st...</td></table>', ";
			}
			else
			{
				if (($kind==3)||($kind==0))
					$str.="'|<table class=t  width=100% $b><td>$name нанес $s...</td></table>', ";
				elseif ($kind==1)
					$str.="'|<table class=t width=100% $b><td>$name нанес $s на опережение...</td></table>', ";
				elseif ($kind==2)
					$str.="'|<table class=t width=100% $b><td>$name контратаковал $st...</td></table>', ";
			}

	if($b=="bgcolor=#3b484c") $b="bgcolor=#515e64";
	else $b="bgcolor=#3b484c";

		}
	


	}

	if($type=="10") 
	{

		//$b="bgcolor=4b0404";

		$critical=next($v);
		$criticaltype=next($v);
		$hits=next($v);

		$add.="'$id2','$hits', ";
		if($critical) 
		{
			if($criticaltype=="0") $criticaltype="голову";
			elseif($criticaltype=="1") $criticaltype="корпус";
			elseif($criticaltype=="2") $criticaltype="руку";
			else $criticaltype="ногу";

			if ($exchange)
			{
				$c= "<div class=red></div></td><td>...$name $st критически ранил $name2 в $criticaltype [-$hits]";
				$exchange--;
			}
			else
				$c= "<div class=red></div></td><td>...и критически ранил $name2 в $criticaltype [-$hits]";
		}
		else
			if ($exchange)
			{
				$c= "<div class=red></div></td><td>...$name $st ранил $name2 [-$hits]";
				$exchange--;
			}
			else
				$c= "<div class=red></div></td><td>...и ранил $name2 [-$hits]";

	}
	elseif($type=="11") 
	{

		//$b="bgcolor=083201";

		$retreat=next($v);
		if ($retreat==0)
			$c= "<div class=green></div></td><td>...$name2 заблокировал";
		else
			$c= "<div class=green></div></td><td>...$name2 с трудом заблокировал, отступив";
	}
	elseif($type=="12") 
	{
		//$b="bgcolor=083201";

		$retreat=next($v);


		if ($retreat==0)
			$c= "<div class=green></div></td><td>...$name2 увернулс€";
		else
			$c= "<div class=green></div></td><td>...$name2 с трудом успел отскочить";
	}
	elseif($type=="13") 
	{
		//$b="bgcolor=083201";

		$c= "<div class=green></div></td><td>...но не дот€нулс€";
	}
	elseif($type=="14") 
	{

		$id2=next($v);
		$name2=gladiatorname($id2);

		$add="'$id','$id2', ";

		$c= "<div class=green></div></td><td>$name и $name2 одновременно поразили друг друга:";
		$exchange=2;
	}
	elseif($type=="20") 
	{
		$c= "$name от удара упал!";
	}
	elseif($type=="21") 
	{
		$c= "$name успел встать на ноги";
	}
	elseif($type=="22") 
	{
		$c= "$name оглушен!";
	}
	elseif($type=="23") 
	{
		$c= "$name пришел в себ€";
	}
	elseif($type=="24") 
	{
		$c= "$name впал в €рость!";
	}
	elseif($type=="25") 
	{
		$c= "$name умерил свой пыл";
	}
	elseif($type=="26") 
	{
		$c= "$name выбилс€ из сил!";
	}
	elseif($type=="27") 
	{
		$c= "$name собрал последние силы";
	}
	elseif($type=="50") 
	{
		$c= "<div class=lightblue></div></td><td><font color=#00f6ff><b>$name бросил оружие и сдалс€!</font>";
	}
	elseif($type=="51") 
	{
		//$b="bgcolor=170140";
		$c= "<div class=lightblue></div></td><td><font color=#00f6ff><b>$name потер€л сознание!</font>";
	}
	elseif($type=="52") 
	{
		$c= "<div class=lightblue></div></td><td><font color=#00f6ff><b>$name ранен в руку, выронил оружие и сдалс€!</font>";
	}
	elseif($type=="53") 
	{
		$id2=next($v);
		$name2=gladiatorname($id2);
		$c= "<div class=lightblue></div></td><td><font color=#00f6ff><b>$name2 успел прижать упавшего $name ногой и $name сдалс€!</font>";
	}
	elseif($type=="73") 
	{
		$id2=next($v);
		$name2=gladiatorname($id2);
		$c= "<font color=yellow><b>$name2 осталс€ с $name сражатьс€ один на один!</b></font>";
	}
	elseif($type=="60") 
	{
		$counter=next($v);
		$value=next($v);

		if($counter==0)
			$c= "<font color=yellow><b>$name нанес подр€д уже $value удара!</b></font>";
		elseif($counter=="1")
			$c= "<font color=yellow><b>$name нанес уже $value удара, не получив ни одного!</b></font>";
		elseif($counter=="2")
			$c= "<font color=yellow><b>$name оттеснил противника уже на $value шага!</b></font>";
		elseif($counter=="3")
			$c= "<font color=yellow><b>$name уже $value-й раз бьет без промаха!</b></font>";
		elseif($counter=="4")
			$c= "<font color=yellow><b>$name действует безупречно!</b></font>";


	}
	elseif($type=="61") 
	{
		$counter=next($v);
		$value=next($v);
		$points=next($v);

		if($counter=="0")
			$c= "<font color=yellow><b>$name за комбинацию из $value ударов: +$points очков</b></font>";
		elseif($counter=="1")
			$c= "<font color=yellow><b>$name за серию из $value ударов: +$points очков</b></font>";
		elseif($counter=="2")
			$c= "<font color=yellow><b>$name за натиск в $value шага: +$points очков</b></font>";
		elseif($counter=="3")
			$c= "<font color=yellow><b>$name за $value удара без промаха: +$points очков</b></font>";
		elseif($counter=="4")
			$c= "<font color=yellow><b>$name за $value безупречных действий: +$points очков</b></font>";
	}
	elseif($type=="62") 
	{
		$counter=next($v);
		$value=next($v);

		if($counter=="0")
			$c= "<font color=yellow><b>ѕротивники поочередно обмениваютс€ ударами, не уступа€ друг другу!</b></font>";
		elseif($counter=="1")
			$c= "<font color=yellow><b>ѕротивники безжалостно руб€т друг друга!</b></font>";
		elseif($counter=="2")
			$c= "<font color=yellow><b>ѕротивники сражаютс€ на равных, не уступа€ друг другу!</b></font>";
	}
	elseif($type=="64") 
	{

		$counter=next($v);
		$value=next($v);

		if($counter=="0")
			$c= "<font color=yellow><b>$name отбиваетс€ одновременно от $value-х противников!</b></font>";
		elseif($counter=="1")
			$c= "<font color=yellow><b>$name поверг уже $value-х противников!</b></font>";
	}

	if(strstr($c,"<div")) $t=" width=10px";
	else unset($t);

	$str.= "'$type','$id','<table class=t width=100%  $b><td $t>".$c."</td></table>', ".$add;


	return $str;
}

$str='';
foreach($ar as $k=>$v)
{
	$str.=makecomment($v);
}

if($b=="bgcolor=#3b484c") $b="bgcolor=#515e64";
else $b="bgcolor=#3b484c";

$file=fopen(gampath($id)."/$id.res","r");
$st=fread($file,filesize(gampath($id)."/$id.res"));

$res=unserialize($st);

$score1=reset($res[Score]);
$score2=next($res[Score]);

if($score1>$score2) $winner="ѕобедил <b>".$rst1[Login]."!</b>";
elseif($score2>$score1) $winner="ѕобедил <b>".$rst2[Login]."!</b>";
else $winner="Ѕой завершилс€ вничью!";

$gstr="";
foreach($res[Gladiators] as $k=>$v)
{
	
	if($rst1[Gladiators][$k]||$rst2[Gladiators][$k]) 
	{

		$gstr.=gladiatorname($k)." - <img src=/images/up.gif width=11px height=11px title=ќпыт><b>".round($v[Exp])."</b>";
		if($v[Injury]) $gstr.=", <img src=/images/icons/inj.gif width=11px height=11px title=“равма><b> $v[Injury]</b>";
		$gstr.=", ";
 
	}


}

$gstr=substr($gstr,0,strlen($gstr)-2);

$str.= "'1','','<table class=t width=100%  $b><td $t><b>$winner</td></table>', ";

if($b=="bgcolor=#3b484c") $b="bgcolor=#515e64";
else $b="bgcolor=#3b484c";


$str.= "'1','','<table class=t width=100%  $b><td $t><font color=yellow><b>ƒеньги за бой: $res[Money]</font></td></table>', ";

if($b=="bgcolor=#3b484c") $b="bgcolor=#515e64";
else $b="bgcolor=#3b484c";


$str.= "'1','','<table class=t width=100%  $b><td $t>$gstr</font></td></table>', ";


print "<script>var ar=Array(";
print substr($str,0,strlen($str)-2);
print ");</script>";


$i=0;


function draw_gladiators($gam,$rst,$ord,$num)
{


$glad=$rst[Gladiators];



foreach($ord as $k=>$ar)
{


	asort($ar);
	foreach($ar as $k1=>$v1)
	{

	$k=$v1;
	$v=$glad[$v1];

	$v[Name]=trim($v[Name]);

	$i++;

	if(!$v[PercentTrain]) $v[PercentTrain]=0;
	$coef=10+(100-$v[PercentTrain])*30/100;

	if($gam[Date]) $v[Stamina]=intval($v[Stamina]+$coef*($gam[Date]-$rst[Date])/3600);


	//if($gam[Date]) $v[Stamina]=round($v[Stamina]+10*($gam[Date]-$rst[Date])/3600);

	if($v[Stamina]>100) $v[Stamina]=100;

	$v[Hits]=round($v[Stamina]*$v[Vit]/10);
	$v[FullHits]=round(100*$v[Vit]/10);


	if($i<=7) 
	{


print "<div style='float:";

if($num==2) print "left";
else print "right";

print "'><table border=0 cellspacing=0 cellpadding=0><tr><td><center>
<div id=\"border$k\" style='border:1px solid #515E64;padding-bottom:8px;margin-top:5px' ><img id=\"player$k\" style='border:0px solid #515E64;'";


if($num==2) print "' src=\"/images/gladiators/$v[TypeID]_2.png\"";
else print "' src=\"/images/gladiators/$v[TypeID]_1.png\"";

print "  ></div>
<input type=\"hidden\" id=Hits$k value=\"$v[Hits]\">
<input type=\"hidden\" id=FullHits$k value=\"$v[FullHits]\">
<tr><td align=center>$v[Name] [$v[Level]]
<tr><td align=center><div id=stripe$k></div>
<tr><td align=center><div id=life$k>$v[Hits]($v[FullHits])</div>";

print "</table></div>";

if(!$v[Morale]) $v[Morale]=0;

print "<script>";


print "
document.getElementById(\"stripe$k\").innerHTML=getStripe2($v[Hits],$v[FullHits],0);

var hint=\"<table border=0 width=100% bgcolor=#E5CEA6 cellspacing=1 cellpadding=4>\";
hint +=\"<tr bgcolor=#515E64><td colspan=2><center><b>$v[Name] [$v[Level]] </td></tr>\";
hint +=\"<tr bgcolor=#3B484C><td width=90px><b>¬озраст: </td width=110px><td><nobr>$v[Age]</td></tr>\"
hint +=\"<tr bgcolor=#515E64><td><b>ћораль: </td><td><nobr>\"+getStripe($v[Morale],true,5)+\" $v[Morale]</td></tr>\";
hint +=\"<tr bgcolor=#3B484C><td><b>¬ыносливость: </td><td>\"+getStripe($v[Vit])+\" ".round($v[Vit])."</td></tr>\";
hint +=\"<tr bgcolor=#515E64><td><b>Ћовкость: </td><td>\"+getStripe($v[Dex])+\" ".round($v[Dex])."</td></tr>\";
hint +=\"<tr bgcolor=#3B484C><td><b>“очность: </td><td>\"+getStripe($v[Acc])+\" ".round($v[Acc])."</td></tr>\";
hint +=\"<tr bgcolor=#515E64><td><b>—ила: </td><td>\"+getStripe($v[Str])+\" ".round($v[Str])."</td></tr>\";
hint +=\"</table>\";

addHint(document.getElementById(\"player$k\"),hint);

</script>";

	}

	}
}

}


		if($game[TournamentID])
		{
			$q=select("select Name from ft_tournaments where TournamentID='$game[TournamentID]'");
					print "<div ><a href=/xml/arena/tournaments.php?id=$game[TournamentID] style='font-size:12pt;'><b>$q[0]</b></a></div>";
		}

		print "<div style='font-size:24pt;'>";

		//if($rst1[GuildStatusID]==1) print guildlogo($rst1[GuildID],1)." ";

		print "<a href=/users/$rst1[UserID] style='color:#FF9600;font-size:24pt;'>$rst1[Login]</a>";
		print " vs. ";

		//if($rst2[GuildStatusID]==1) print guildlogo($rst2[GuildID],1)." ";

		print "<a href=/users/$rst2[UserID] style='color:#D5D5D5;font-size:24pt;'>$rst2[Login]</a>";
		print "</div>";

		print "<table width=100% border=0 cellspacing=0 cellpadding=0>";
		print "<td valign=top width=50% style='padding-right:10'>";

		draw_gladiators($game,$rst1,$ord1[Squad],1);


		print "<td valign=top align=left  width=50% style='padding-left:10'>";

		draw_gladiators($game,$rst2,$ord2[Squad],2);

		print "</td></table>";




?>
<form name=game>
<br><center>


<div style="width:500px;border:1px solid #E7CFA5;height:20px;
padding:3;font-size:14px;vertical-align:middle" id="moments">

<table border=0 cellspacing=0 height=20px cellpadding=0><td align=center valign=middle>

<center>

<input type=button class=button  value="Ќачать просмотр" onclick="startshow();">

</td></table>

</center>

</div>

<br>



</center>


<center>

<br>

<table  border=0 cellspacing=1 cellpadding=1 width=500px style="border:1px solid black;height:20px;background-color:#BAAE9C;">


<td >

<input type=button name=start value="Ќачать" onclick="startshow();">
</td>
<td><font color=black><center>

 <input type=radio value=1 name=1 onclick='speed=3500'> ћедленно
 <input type=radio value=2 name=1 checked onclick='speed=1000'> Ќормально
 <input type=radio value=3 name=1 onclick='speed=500'> Ѕыстро

</font>
</td><td align="right" width=100px><input type=button value="ѕауза" name=pause onclick="ch();">
</td><td width=20px><input type=button value="Ўаг" name=step onclick="ch2();">

</tr>
</table>
<br>
<a href="javascript:;" onclick="document.getElementById('momentsfull').style.display= (document.getElementById('momentsfull').style.display=='block') ? 'none' : 'block';">[полный отчет]</a>


</center><br>


<div id=momentsfull style="display:none;text-align:left"></div>




<?
}



?>

       </td>
<td width=8px background="chain.gif" valign=top><img src=chain.gif width=4px height=6px></td>
</tr>
  <!--nizhnij>

  </table>

</body>
</html>