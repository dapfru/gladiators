<?
require('../../config.php');


//translation ok 14.7.06 D.T.

require($engine_path."cls/auth/session.php");

$type="city/usurer";
if($act=="select"||!$act) $act="deposit";

require($site_path."up.php");

require($site_path."left.php");



if($act=="deposit")
{
print"<h5>Выплаты по вкладам:</h5>";
$form->Draw();

print"<br><h5>Выплаты по кредитам:</h5>";
$form=new cls_form($type,"loan");
}

$form->Draw();



if($act!="deposit") print "<br></center><div align=right><a href=$PHP_SELF>вернуться</a> <img src=\"/images/marker3.gif\" width=11 height=11 border=0></center>";

require($site_path."bottom.php");
?>
