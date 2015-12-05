<?
require("config.php");
require($engine_path."cls/auth/session_lite.php");
if($auth_name||$auth_pass) 
{
	$step=1;
	
}


$type="main/authorize";
$act="auth";

if($url&&$auth->user) {header("Location:$url");exit;}

require("up.php");

//require("news.php");
//require("left.php");
$act="auth";

if(!$form_ok) $form->Draw();
/*else
{
print "<br>";
$id=$auth->user;
$form=new cls_form("main/users","info");
$form->Draw();

print "<center><a href=\"/profile.php?act=update\">Изменить мою информацию</a></center>";

}
*/
require("bottom.php");
?>