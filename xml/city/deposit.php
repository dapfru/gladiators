<?
require('../../config.php');


//translation ok 14.7.06 D.T.

require($engine_path."cls/auth/session.php");

$type="finance/deposit";


require($site_path."up.php");


require($site_path."left.php");

if(!$form_ok) $form->DrawImage();
$form->Draw();

if(!$act)
{
	$q=select("select Day from ut_leagues where LeagueID='$auth->league;'");
	print "<hr>".icon("help",message(171).": $q[0]");
}


require($site_path."bottom.php");
?>
