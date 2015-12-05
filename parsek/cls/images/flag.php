<?php

require("../../config.php");

require($engine_path."cls/auth/session_lite.php");

$res=mysql_query("select * from ut_countries where CountryID='$id'");
$r=mysql_fetch_array($res);
header("Content-type: image/gif");
header('Content-Length: '.strlen($r[Flag]));
header('Cache-control: public');
print $r[Flag];




$db->close();
?>