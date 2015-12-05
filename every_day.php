<?
require('config.php');


$res=runsql("select UserID from ut_users");

while($r=mysql_fetch_array($res))
{
	lock_rst($r[UserID]);

	$rst=read_rst($r[UserID]);



	$serialized=$rst[Gladiators];

	$salary=0;	

	foreach($rst[Gladiators] as $k=>$gladiator)
	{
		//старение---------------------

		if(round(date("d",mktime()))==1) $rst[Gladiators][$k][Age]=$rst[Gladiators][$k][Age]+1;

		//тренировка--------------------

		$exp=expgained($rst,1);

if($k==103)
{
	print "$exp -- ";
exit;
}
		if(strlen($exp))
		{



		$rst[Gladiators][$k][Exp]=floor($rst[Gladiators][$k][Exp]+$exp);

		//print "$k=> ".$rst[Gladiators][$k][Exp]." = ".expgained($rst,1)."<br>";


		$rst[Gladiators][$k][NextTrain]=0;


		runsql("update ut_gladiators 
set 
Exp='".$rst[Gladiators][$k][Exp]."',
Level='".$rst[Gladiators][$k][Level]."',
TypeID='".$rst[Gladiators][$k][TypeID]."',
Rating='".$rst[Gladiators][$k][Rating]."',
Vit='".$rst[Gladiators][$k][Vit]."',
Dex='".$rst[Gladiators][$k][Dex]."',
Acc='".$rst[Gladiators][$k][Acc]."',
Str='".$rst[Gladiators][$k][Str]."',
Vit='".$rst[Gladiators][$k][Vit]."',

Win='".$rst[Gladiators][$k][Win]."',
Tie='".$rst[Gladiators][$k][Tie]."',
Lose='".$rst[Gladiators][$k][Lose]."'

where GladiatorID='$k'");



		}

		if($rst[Gladiators][$k][StatusID]>1) $salary+=round($rst[Gladiators][$k][Price]/10);

	}


	$rst[TrainDate]=mktime();


	$money=moneygained($rst,1);
	$rst[ShopDate]=mktime();


//print "$money,1,$r[UserID] (лавка)<br>---------------";
	if($money>0) $rst=short_transfer_money($rst,$money,1,$r[UserID],20,0);

//print "$salary,$r[UserID],1 (зарплата гладиаторов)<br>---------------";
	if($salary>0) $rst=short_transfer_money($rst,$salary,$r[UserID],1,19,0);
	

//print $staffsalary[$r[UserID]].",$r[UserID],1 (зарплата спецов)<br>---------------";
	if($staffsalary[$r[UserID]]>0) $rst=short_transfer_money($rst,$staffsalary[$r[UserID]],$r[UserID],1,9,0);

//print $repair[$r[UserID]].",$r[UserID],1 (поддержка построек)<br>---------------";
	if($repair[$r[UserID]]>0) $rst=short_transfer_money($rst,$repair[$r[UserID]],$r[UserID],1,7,0);


	//write_rst($r[UserID],$rst);



	mysql_query("update fn_accounts set Money='$rst[Money]' where UserID='$r[UserID]'");


	unlock_rst($r[UserID]);
}

//mysql_query("delete from ut_races where Date<unix_timestamp()-86400*7");
//mysql_query("delete from ut_stakes where Date<unix_timestamp()-86400*7");

$db->close();
?>