<?require('../../config.php');
//$form_width=170;
require($engine_path."cls/auth/session_lite.php");


if(!$id||!is_numeric($id)) $id=$auth->user;
$_POST['id']=$id;


$user=$id;


if(!$act) $act="select";

$type="gladiators/roster";

$_POST['user']=$user;


require($site_path."up.php");

require($site_path."left.php");


require("gladiators.php");



require($site_path."bottom.php");

?>