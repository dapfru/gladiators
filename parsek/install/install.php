<?
require("../config.php");
$f=fopen("dump.sql","r");
$str=fread($f,filesize("dump.sql"));
runsql($str);
//$site="admin/";
//$form = new cls_form("install/install","insert");
//$form->Draw();
?>