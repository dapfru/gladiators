<?

//-----функция генерит параметры лошадей(на очередной заезд ($cnt-тый от следующего))---
function horses_generate($seed)
{
	global $horses_wins,$cnt,$horses_count,$races_count,$horses_coefficients,$horses_names;
	
	if(!$seed) $seed=getseed(time()+30*60*$cnt);
//print $seed."<br>";
	//srand($seed);
	srand();

	$s=$races_count;
       //print "--".$horses_count;exit;
	$res1=runsql("select Name from ut_gladiator_names where CountryID='1' order by rand($seed) limit 0,$horses_count");	

	for($i=1;$i<=$horses_count;$i++)
	{
		if($i==$horses_count) $horses_wins[$i]=$s;
		 elseif($i==1) $horses_wins[$i]=round(rand(1,$s+i-$horses_count)/2);
		else $horses_wins[$i]=rand(1,$s+i-$horses_count);
	
//print "- $horses_wins[$i]<br>";
		if($horses_wins[$i]==0) $horses_wins[$i]=1;
		$s=$s-$horses_wins[$i];
		$horses_coefficients[$i]=round(($races_count/$horses_wins[$i])*(0.9+rand(-0.1,0.1)),1);
		
		$r1=mysql_fetch_array($res1);
		$horses_names[$i]=$r1[0];
	}
	

} //------------------------------------------------- 


//-------- функция используется в функции вычисления результата гонки--------------
function rechorse($i,$n)
	{
   	  global $j,$sm,$horses_wins,$horses_num,$horses_win,$horses_names,$race_res;

   	
	if($sm<=0) return '';
	if($horses_win[$i]<=0) return '';

  if($n<=$horses_win[$i]*10) 
	  {

		$sm=$sm-$horses_win[$i]*10;
		unset($horses_win[$i]);

		arsort($horses_win);
		$ar=$horses_win;

		if($j==5)
		{ 
			$race_res[0].="$horses_num[$i]";
 			$race_res[1].=$horses_names[$horses_num[$i]];
		}
		else 
		{ 
			$race_res[0].="$horses_num[$i]"."/";
			$race_res[1].=$horses_names[$horses_num[$i]]."/";
		}
		//print "$j ".$horses_num[$i]."--".$horses_names[$horses_num[$i]]."<br>";

		$i=0;
		foreach($ar as $k=>$v) {
if($v&&$horses_num[$k]) 
{
	//print "$i, ".$horses_num[$k]."=>$v<br>";
	$horses_num2[$i]=$horses_num[$k];$horses_win[$i]=$v;
	$i++;
}
		}
$horses_num=$horses_num2;

		$j++;

		rechorse(0,rand(0,$sm));
	  }
    	  elseif($i+($j-1)<=5) return rechorse($i+1,$n-$horses_win[$i]*10);
	}
//-----------------------------------------------------------------

//---------------------функция вычисляет результат гонки----------- 
function race()
{
	global $sm,$horses_count,$races_count,$j,$horses_wins,$horses_num,$horses_win,$horses_names,$race_res;
	
	$sm=10*$races_count;

	arsort($horses_wins);

	$i=0;
	$j=1;
	foreach($horses_wins as $k=>$v) {
$horses_num[$i]=$k;$horses_win[$i]=$v;$i++;}

srand();
	print rechorse(0,rand(0,$sm));


}

//--------------------------------------------------------------


function takerace()
{
global $lang, $auth,$horses_count,$races_count,$horses_names,
$horses_wins,$horses_coefficients,$resarr,$race_res,$takenrace;

$horses_count=5;
$races_count=20;

//--------------------проводим очередную гонку---------------------------

$res=runsql("select * from ut_races where Result_Names='' and Date<=unix_timestamp() order by Date");
while($r=mysql_fetch_array($res))
{


$resarr_nm=explode("/",$r[Horses_Names]);
$resarr_wn=explode("/",$r[Horses_Wins]);
for($i1=1;$i1<=$horses_count;$i1++)
{
$horses_names[$i1]=$resarr_nm[$i1-1];
$horses_wins[$i1]=$resarr_wn[$i1-1];

}

//------------------------гонка проводится (таблица обновляется)---------------

   race(); mysql_query("update ut_races set Result_Numbers='$race_res[0]', Result_Names='$race_res[1]' where RaceID='$r[RaceID]'"); $takenrace=$r[RaceID];

//-------------------------------------------------------------------------------

}


//---------------------инициализация переменных------------------


$q1=select("select count(*) from ut_races where Result_Names='' and Date>unix_timestamp()");

for($i=$q1[0];$i<4;$i++)
{

unset($resarr_nm);
unset($resarr_wn);
unset($resarr_co);

//--------------------добавляем новый рейс в список планируемых----------
horses_generate(($i+1).time());

for($i1=1;$i1<=$horses_count;$i1++)
{
	if($i1==$horses_count)
	{ 
		$resarr_nm.=$horses_names[$i1];
		$resarr_wn.=$horses_wins[$i1];
		$resarr_co.=$horses_coefficients[$i1];
	}
	else
	{
		$resarr_nm.=$horses_names[$i1]."/";
		$resarr_wn.=$horses_wins[$i1]."/";
		$resarr_co.=$horses_coefficients[$i1]."/";
	}
}




$tm=time(); 
$q=select("select Date from ut_races where Result_Names='' order by Date desc limit 0,1");
if($q[0]) $dt=$q[0]+30*60;
else
{	 
	if(date("i",$tm)>=30) $curmin=60; else $curmin=30;
	$dt=mktime(date("H",$tm),$curmin,0,date("m",$tm),date("d",$tm),date("Y",$tm));

}




runsql("insert into ut_races(Horses_Names,Horses_Wins,Horses_Coefficients,Date)
 values('$resarr_nm','$resarr_wn','$resarr_co','$dt')");

}

//$q=select("select * from ut_races where Result_Names='' order by Date desc limit 0,1");



} 


require('config.php');

takerace();



?>