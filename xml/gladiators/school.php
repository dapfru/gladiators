<?
require('../../config.php');
require($engine_path."cls/auth/session.php");
$menu[0] = '<a href=/>На главную</a>';$menu[1] = '<a href=school.php>ДЮСШ</a>';require($site_path."up.php");require($site_path."left.php");
if(!$id) $id = 0;
if(!$act) $act='list';
if(!$type) $type='players/school';

	$form = new cls_form($type,$act);
        $form->Draw();

require($site_path."bottom.php");

?>