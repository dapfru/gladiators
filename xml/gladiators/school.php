<?
require('../../config.php');
require($engine_path."cls/auth/session.php");

if(!$id) $id = 0;
if(!$act) $act='list';
if(!$type) $type='players/school';

	$form = new cls_form($type,$act);
        $form->Draw();

require($site_path."bottom.php");

?>