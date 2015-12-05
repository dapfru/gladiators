<?
header("Content-type: text/html;charset=windows-1251");
$site="guild/";
$lang="rus";

if(!$act) $act="select";
if(!$type) $type="main/newbies";



require($engine_path."cls/auth/session.php");

if(!$id) $id=$auth->guild;

require("admin_functions.php");



if($act=="search"&&$step)
{

 $searchform = new cls_form($type,'search');
 $form  = new cls_form($type,'select');
 $searchform->set_form_params($searchform->sql);

 $form->sql=$searchform->sql;

}
else
{

$form = new cls_form($type,$act);




	unset($runsql);


	if($step) {
		$form_result=$form->runsql(1); $runsql=1;

		if(!$er&&$form->action) $form=new cls_form($type,$act);
	}

	if($form_ok==1) 
	{

		$form_result=icon('ok',set_params($form->success))."<br/>";
	}

	if($form->redirect) $form->redirect=set_params($form->redirect);


	if($step&&!$er&&$form->redirect&&$form_result) 
	{
		if(strstr($form->redirect,"?")) header("Location:$form->redirect&form_ok=1");
		else header("Location:$form->redirect?form_ok=1");
	}
	elseif($step&&!$er&&$form_result) 
	{

		if(strstr($QUERY_STRING,"step")) $QUERY_STRING=str_replace("step","st",$QUERY_STRING);

		if($id) $QUERY_STRING.="&id=$id";
		header("Location:$PHP_SELF?$QUERY_STRING&form_ok=1");
	}



//if($step||$act=="delete"||$act=="create"||$act=="drop") $form->runsql('');

if($step&&$act=="update"&&!$er) {$form = new cls_form($type,"select"); unset($id); unset($act);}

}

if($step&&!$er&&$form->action) $form=new cls_form($type,$act);


?>

<head>
<link href="<?=$site_url?>css.css" rel="stylesheet" type="text/css">
</head><body><center>
<?
print "<script src='".$path."functions.js' language='javascript' type='text/javascript'></script>";

print "<table width=600px bgcolor=515E64  border=0 cellspacing=0 cellpadding=4 height=100%><td background=\"/images/admin-bg.gif\">

<table width=592px   border=0 cellspacing=0 cellpadding=0 height=100%>

<td valign=top  ><div style=\"margin:6\">";



//$q=select("select PermissionID from en_permissions where (Site='$site' or Site='".substr($site,0,strlen($site)-1)."'  or Type='**') and (UserID='$auth->user' or TypeID in (select TypeID from ut_posts where UserID='$auth->user'))");
$q=select("select UserID from gd_guilds where GuildID='$auth->guild'");

if(!$auth->guild) {print icon('error',"Вы не состоите в гильдии");exit;}

if($q[0]!=$auth->user&&$auth->user!=32) {print icon("error","У вас нет прав доступа");exit;}






print "
Вы авторизованы как $auth->nick. <a href=\"/register.php?do=logout&act=auth&type=main/authorize\">[выйти]</a> <a href=\"/\">[главная страница]</a> ";


$menu=new cls_menu("menu/menu","toolbar",1);
$menu->bgcolor="";
$menu->align="center";
$menu->headerbg="";
$menu->height="15px";
$menu->width="100%";
$menu->cellspacing=0;
$menu->cellpadding=0;
$menu->bgcolor="";
$menu->hcolor="";
$menu->headerclass="";
$menu->rowcolor="";

$menu->icon= "<img src=\"/images/marker2.gif\" width=16px height=16px>&nbsp;</td><td> ";



?>
</tr>


<tr>
<td height=35px style="background-image: url(/images/index2-menu2-bg.jpg);
	background-repeat: no-repeat;
	background-position: center top;" valign=middle><?
$menu->Draw('');



$menu=new cls_menu("menu/menu","toolbar2/".substr($type,0,strpos($type,"/")),2);
$menu->bgcolor="";
$menu->align="center";
$menu->headerbg="";
$menu->height="25px";
$menu->width="100%";
$menu->cellspacing=0;
$menu->cellpadding=0;
$menu->bgcolor="";
$menu->hcolor="";
$menu->border="0";
$menu->headerclass="";
$menu->rowcolor="";
$menu->icon= "<img src=\"/images/marker3.gif\" width=11px height=11px>&nbsp;</td><td> ";

?>
</tr>


<tr>
<td height=20px style="background-image: url(/images/index2-menu3-bg.jpg);
	background-repeat: no-repeat;
	background-position: center top;" bgcolor=ffffff>
<?

$menu->Draw('');


?>
</tr>


<tr>
<td height=100% valign=top ><table width=100% cellpadding=6 cellspacing=0 border=0><td>


<?

if($form_result) print $form_result;

if($type=="engine/tags"&&$step&&!$er)
{


	$r=select("select t.*,p.Type,p.Site from en_tags t join en_pages p using(PageID) where t.TagID='$id'");

	$Type=$r[Type];
	$Act=$r[Act];
	$Site=$r[Site];

	makexml($Site,$Type,$Act);

	$Xml=$r[Xml];


	//$Xml=settags($Xml);

	$PageID=$r[PageID];


	xml2bd();
	unset($r);

}
elseif($type=="engine/pages"&&$step&&!$er)
{
	$res=runsql("select t.*,p.Type,p.Site from en_pages p join en_tags t using(PageID) where p.PageID='$id'");
	while($r=mysql_fetch_array($res))
	{

		$Type=$r[Type];
		$Act=$r[Act];
		$Site=$r[Site];

		makexml($Site,$Type,$Act);

		$Xml=$r[Xml];
		//$Xml=settags($Xml);
		$PageID=$r[PageID];

//print "$Site,$Type,$Act";
		xml2bd();
		unset($r);
	}
//exit;
}	


if($act=="delete"&&$form_ok&&!$er) {$form=new cls_form($type,"select");$act="select";}
if($act=="insert"&&$form_ok&&!$er) {$form=new cls_form($type,"select");$act="select";}
?>