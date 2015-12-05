<?
require("../config.php");



function int2ip($i) {

   $d[0]=(int)($i/256/256/256);

   $d[1]=(int)(($i-$d[0]*256*256*256)/256/256);

   $d[2]=(int)(($i-$d[0]*256*256*256-$d[1]*256*256)/256);

   $d[3]=$i-$d[0]*256*256*256-$d[1]*256*256-$d[2]*256;

   return "$d[0].$d[1].$d[2].$d[3]";

}

 

function ip2int($ip) {

   $a=explode(".",$ip);

   return $a[0]*256*256*256+$a[1]*256*256+$a[2]*256+$a[3];

}

 
$ip=ip2int(getenv('REMOTE_ADDR'));


mysql_query("update top_sites set Hits =Hits +1, Hosts =Hosts +if(('$id','$ip') in (select SiteID,IP from top_hosts),0,1) where SiteID='$id'");
mysql_query("insert ignore into top_hosts(SiteID,IP) values('$id','$ip')");


		//подключение счётчика
	include_once "count.php";

$db->close();
?>