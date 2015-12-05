<?
require('../config.php');

unset($act);

		$type="gladiators/builder";
		$act="select";


require($engine_path."cls/auth/session.php");

$glad2=get_gladiators($auth->user);
$glad2=$serialized;



require($site_path."up.php");


$fields = Array();

	if(!$id) 
	{
		$q=select("select * from ft_agreements where (UserID1='$auth->user' or UserID2='$auth->user') and Approved=1");
		$id=$q[RecordID];
	}


$ob=xml_contents($engine_path."/xml/gladiators/builder.xml");

$ar=$ob->childNodes();
$localization = "";
foreach($ar as $a)
{

 $forma = new cls_form("gladiators/builder",$a->tagname);


 $arr = Array();


 foreach($forma->getfields() as $field)
 {


 	$control = new cls_controls($field,$this); 

 	if($control)
		$arr[$control->name] = $control;
 }
 $fields[$a->tagname] = $arr;
}

function DrawControl($game,$type,$formaat)
{
	global $fields;
	if($fields[$game][$type])
	{
		$fields[$game][$type]->format = $formaat;
		$fields[$game][$type]->Draw(0,'');
	}
}
function DrawControlTb($game,$type,$formaat)
{
	global $fields;
	if($fields[$game][$type])
	{
		$fields[$game][$type]->format = $formaat;
		$fields[$game][$type]->Draw(1,'');
	}
}



$t = 0;
$i=0;

/*
	foreach(array_keys($fields) as $cap)
	{
		$_class = ($i == 0)?"firsttabcaption":"tabcaption";
		$tabIndex = $i+1;



		if($caption=$fields[$cap]["caption"]->caption) $menu[$t] = "<a href='javascript:show_tab($tabIndex)' ><font id='menu_item$tabIndex'>$caption</font></a>";
		$i++;
		$t++;
	}

	$sendData = ($id)?"send_data(0,null,$id,0)":"open_saveDialog(true)";
	$menu[$t+1]="<a href='javascript:$sendData;' class='blue'><img src=\"/images/icons/save.gif\" width=16px height=14px border=0  align=\"absmiddle\"> ".message(175)."</a>";
	//$menu[$t+2]="<a href='javascript:open_saveDialog();'><img src=\"/images/icons/save.gif\" width=16px height=14px border=0  align=\"absmiddle\"> "."Сохранить"."</a>";
	//$menu[$t+3]="<a href='javascript:list_files()'><img src=\"/images/icons/load.gif\" width=16px height=14px border=0  align=\"absmiddle\"> ".message(176)."</a>";
*/


if(!$id) unset($menu);

require($site_path."left.php");


unset($tournament);
unset($order);

if($id)	
{
	//$tournament=select("select * from ft_agreements where RecordID='$id'");

	$tournament=select("select a.*,u1.Login Login1, u2.Login Login2
			from ft_agreements a
			join ut_users u1 on u1.UserID=a.UserID1
			join ut_users u2 on u2.UserID=a.UserID2 
			where a.RecordID='$id'");

		print "<center><div style='font-size:24pt;'><a href=/users/$tournament[UserID1] style='color:FF9600;font-size:24pt;'>$tournament[Login1]</a> vs. <a href=/users/$tournament[UserID2] style='color:D5D5D5;font-size:24pt;'>$tournament[Login2]</a></div><br></center>";

}
else
{
	$form=new cls_form($type,"empty");
}

?>