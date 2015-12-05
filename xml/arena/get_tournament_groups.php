<?
require('../../config.php');

header("Content-type: text/html;charset=windows-1251");


require_once $engine_path."xml/arena/load/jshttp.class.php";
$JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");


$result['answer'] = "";


$form=new cls_form('arena/tournaments','group');
$form->draw();
print "<br>";

$_RESULT = $result;
?>