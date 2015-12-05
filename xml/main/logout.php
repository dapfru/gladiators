<?
require('../../config.php');

$first_page=1;

if ($do == "logout") 
{ 

 

 $_SESSION = array(); 

 empty ( $_COOKIE['cookie_nick']);
 empty ( $_COOKIE['cookie_password']);

setcookie('cookie_nick', '', time() - 3600,"/");
setcookie('cookie_password','',time() - 3600,"/");

	$_COOKIE['cookie_nick']='';
	$_COOKIE['cookie_password']='';

// session_destroy();



}



$form_width=170;

require($engine_path."cls/auth/session_lite.php");


$form_title=message(23)."!";

require($site_path."up.php");

require($site_path."left.php");

print "<center><b>".message(222)."</b><br><a href=\"$site_url\">".message(223)."</a></center>";

require($site_path."bottom.php");
?>
