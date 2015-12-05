<?
		//таблицы mysql
	define ("TAB_USERS",  "top_users");
	define ("TAB_LOG",  "top_log");

foreach($_REQUEST as $k=>$v)
{
  if(!is_Array($v))
  {
	$v=preg_replace("/ union /i"," <span>union</span> ",$v);
	$v=preg_replace("/ join /i"," <span>join</span> ",$v);

	$_REQUEST[$k]=addslashes($v);
	$$k=addslashes($v);
	$_GET[$k]=addslashes($v);
	$_GET[$k]=str_replace("#","",$v);	
  }
}


if(!eregi( "^[a-zA-Z\-_0-9/-]+$", $type )) unset($type);
if(!eregi( "^[a-zA-Z\-_0-9/]+$", $act )) unset($act);
if(!eregi( "^[a-zA-Z\-_0-9/]+$", $id )) unset($id);

?>