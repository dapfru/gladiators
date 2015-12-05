<?
header("Content-type: text/html;charset=windows-1251");
include("../config.php");

$site="admin/";
$lang="rus";

if(!$act) $act="select";
if(!$type) $type="engine/menu";


require($engine_path."cls/auth/session.php");

require("admin_functions.php");






function mult($v1,$v2)
{
	
		$i=0;
	foreach($v1 as $k=>$v)
	{

		$i++;
		$sum=0;

		$c=count($v1);
		for($j=1;$j<=$c;$j++)
		{

			$sum+=$v2[$j][$i]*$v1[$j];
			//print "$i,$j +=".$v2[$j][$i]."*".$v1[$j]."<br>";
		}


		$r[$i]=$sum;
	}



	return($r);

}

function rec2($parent)
{


$res=runsql("select * from en_menu where Parent=$parent");

while($r=mysql_fetch_array($res))
{


	print "<td>$r[Name_rus]</td>";


	if(mysql_num_rows($res)>0) rec2($r[MenuID]);
}


}


function search($menu, $m,$parent)
{
	global $topparent;

$q=select("select Parent from en_menu where MenuID='$menu'");

//print "$q[0], $menu, $m<br>";

if($q[0]==$m) return 1;



$q1=select("select Parent from en_menu where MenuID='$q[0]'");


if(!strlen($q1[0])) return 0;

$res=runsql("select * from en_menu where Parent=$q1[0]");

while($r=mysql_fetch_array($res))
{
	if($r[MenuID]==$m) return 1;
}




$q1=select("select Parent from en_menu where MenuID='$q1[0]'");

if(!strlen($q1[0])) return 0;

$res=runsql("select * from en_menu where Parent=$q1[0]");

while($r=mysql_fetch_array($res))
{
	if($r[MenuID]==$m) return 1;
}


	

$q1=select("select Parent from en_menu where MenuID='$q1[0]'");

if(!strlen($q1[0])) return 0;

$res=runsql("select * from en_menu where Parent=$q1[0]");

while($r=mysql_fetch_array($res))
{
	if($r[MenuID]==$m) return 1;
}


}


function rec3($parent,$p,$menu,$i)
{
	global $ar;


$res=runsql("select * from en_menu where Parent=$parent");


while($r=mysql_fetch_array($res))
{



	print "<td>";

	if($r[MenuID]==$menu) $a= "0";
	elseif($r[Parent]==$menu) $a= "1";
	elseif($r[Parent]==$p) $a=1;
	elseif($r[MenuID]==$p) $a=1;
	elseif(search($menu,$r[MenuID])) $a= "1";
	else $a= "0";

	print $a;

	$ar[$menu][$r[MenuID]]=$a;

	//if($r[Parent]==$p) print "1";

	print " </td>";


	if(mysql_num_rows($res)>0) rec3($r[MenuID],$p,$menu,$do);
}


}



function rec($parent,$top)
{
	global $i,$ar,$topparent;

$res=runsql("select * from en_menu where Parent=$parent");

while($r=mysql_fetch_array($res))
{
	print "<tr>";

	$q=select("select count(*) from en_menu where Parent=$r[MenuID]");

	$outerlinks=mysql_num_rows($res)+$top+$q[0];

	$i++;
//<td>$outerlinks</td>
	print "<td>$i. $r[Name_rus]</td>";

	//$ar[MenuID]=$r[MenuID];
	
	rec3($topparent,$r[Parent],$r[MenuID],$i);


	print "</tr>";

	if(mysql_num_rows($res)>0) rec($r[MenuID],$top+mysql_num_rows($res));
}
}



function makepr($parent)
{
	global $ar,$i,$topparent;

$topparent=$parent;

print "<table border=1>";

print "<tr><td></td>";

print rec2($parent);

print "</tr>";

rec($parent);

print "</table>";


unset($m);

$i=0;

print "<table border=1>";

print "<tr><td></td>";

rec2($parent);


foreach($ar as $k=>$v)
{
	$i++;

	$q=select("select Name_rus from en_menu where MenuID='$k'");

	print "<tr><td><b>$q[0]</b></td>";

	$sum=0;
	foreach($v as $k1=>$v1)
	{

		$sum+=$v1;
	}
	
	reset($v);

	$j=0;
	foreach($v as $k1=>$v1)
	{
		$j++;

		$v1=round($v1/$sum,2);
		print "<td><center>$v1</td>";
		$ar[$k][$k1]=$v1;
		$m[$i][$j]=$v1;
	}

}

print "</table>";

$c=count($ar);

for($i=1;$i<=$c;$i++)
{
	$pr[$i]=1/$c;

}


$sum=0;


foreach($pr as $k=>$v)
{
	$sum+=$v;
}



for($i=1;$i<100;$i++)
{
$pr=mult($pr,$m);
}


$sum=0;
foreach($pr as $k=>$v)
{
	$sum+=round($v,3);
}
reset($pr);

foreach($pr as $k=>$v)
{
	$pr[$k]=round($v/$sum,3);
}

reset($pr);

//расчет PR
$i=1;

unset($menu);
foreach($ar as $k=>$v)
{
	$menu[$i]=$k;
	$i++;
}

$i=1;
//print count($pr)."<hr>";
foreach($pr as $k=>$v)
{
	print "$k=>$v<br>";
	$v=round($v*count($pr)*0.85+0.15,1);

	$m=$menu[$i];
	runsql("update en_menu set PR='$v' where MenuID='$m'");
	$i++;
}


}

$res=runsql("select MenuID from en_menu where Parent=0");
while($r=mysql_fetch_array($res))
{	
	PRINT "<b>Расчет PR для $r[0]</b><br>";
	makepr($r[0]);


unset($pr);
unset($ar);
unset($m);
unset($v);
}
print "PageRank успешно посчитан!";




$db->close();
//require('bottom.php');
?>