<?
require("cls_games.php");
$tournament=new cls_games();

print "<b><center>".$tournament->Name($id)."</b></center>";

$tournament->DrawTour();

?>