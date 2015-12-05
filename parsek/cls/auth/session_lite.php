<?
require($engine_path."cls/auth/cls_auth.php");
$auth=new cls_auth(1,$auth_name,$auth_pass);



if(!$lang) $lang=$_COOKIE['cookie_lang'];
else $tmp=$_COOKIE['cookie_lang'];

if(!$lang) $lang="rus";

setcookie('cookie_lang',$lang,time()+30*24*3600, "/");


?>