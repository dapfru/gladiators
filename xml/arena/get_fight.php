<?
require('../../config.php');

header("Content-type: text/html;charset=windows-1251");


require_once $engine_path."xml/arena/load/jshttp.class.php";
$JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");

$result['answer'] = "";

$fname=$site_path."files/gam/".$id.".gam";


		if(($time-mktime()<=0 && !file_exists($fname))||(file_exists($site_path."files/ord/".$id."-$user1.ord")&&file_exists($site_path."files/ord/".$id."-$user2.ord")))
		{
			$result["redirect"] = "fight.php?id=$id";
		}

$_RESULT = $result;
?>