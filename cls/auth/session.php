<?

require($engine_path."cls/auth/cls_auth.php");

$auth=new cls_auth(0,$auth_name,$auth_pass);


//if($auth->lang) $lang=$auth->lang;
//writelog("1) "."$lang ".$_COOKIE['cookie_lang']);


if(($_COOKIE['cookie_lang']!="rus")&&($_COOKIE['cookie_lang']!="ita")&&($_COOKIE['cookie_lang']!="ger")&&($_COOKIE['cookie_lang']!="eng")) 
{
	$_COOKIE['cookie_lang']="rus";
}



if(!$lang) $lang=$_COOKIE['cookie_lang'];
else $tmp=$_COOKIE['cookie_lang'];

if(!$lang) $lang="rus";

//writelog("2) ".$lang);

setcookie('cookie_lang',$lang,time()+30*24*3600, "/");

//writelog("3) ".$_COOKIE['cookie_lang']);
//writelog("---");

?>