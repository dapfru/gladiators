<?php

include("../config.php");


$REMORE_ADDR=$_SERVER[REMOTE_ADDR];

if($REMOTE_ADDR!='217.199.212.3') exit;

$code_id=$_REQUEST['sms_id']; //ид смс
$text=strtoupper($_REQUEST['text']); //текст запроса 
$phone=$_REQUEST['phone']; //телефон абонента
$isnn=$_REQUEST['isnn']; //короткий номер
$op=$_REQUEST['op']; //оператор

//7250 2,5 - рф
//7250 1,99 - Украина 
//5373 4,125 - укр
//2332 5 - рф

$num=mt_rand(1,3);



//$isnn=2332;
//$code_id=mt_rand(0,123123);
//$text="butsa din";


if($isnn=="7099") $price=1;
elseif($isnn=="7250") $price=2.5;
elseif($isnn=="5373"||$isnn=="2332") $price=5;
else exit;

//glad 12345
$id=substr($text,4);
$id=trim($id);

if(is_numeric($id)) $q=select("select UserID from ut_users where UserID='$id'");	
$user=$q[UserID];


  header('Ort: OK');
  header('Content-Type: text/plain');



if(!$user) {print "Polzovatel' $id ne nayden";exit;}


$q=select("select * from sms_queries where SMS_ID='$code_id'");
if($q[0]) {print "Spasibo vash zapros obrabotan";exit;}

runsql("insert into sms_queries(SMS_ID, ShortName, UserID, Phone, Isnn, Request, Op, Date,Money) 
values ('$code_id','$shortname','$user','$phone','$isnn','$text','$op',unix_timestamp(),'$price')");

//runsql("insert into fn_sms(UserID,Money) values('$user','$price') on duplicate key update Money=Money+'$price'");


	lock_rst($user);
	$rst=read_rst($user);

	$rst[Status][4]=strval(100);
	$rst[Status][8]=strval(100);
	$rst[Status][2]=strval(100);

	write_rst($user,$rst);
	unlock_rst($user);

print "Rabotosposobnost' specialistov vosstanovlena.";

?>