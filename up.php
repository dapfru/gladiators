<?

header("Content-type: text/html;charset=windows-1251");


$site="";





if($type&&$act)
{



	$form = new cls_form($type,$act);
	unset($form_result);

	if($step&&$form->act=="search")
	{
		$searchform=$form;

		$form = new cls_form($type,'select');

		$form->sql=$searchform->sql;
		$form->vip=$searchform->vip;

		$form->getrows();

		unset($step);
	}

	if($step&&!$form->sql) $form->sql=$form->select;

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


}




$page_title=message(52);

if($form_title) $page_title=$form_title;
if($form->title) $page_title=$form->title;


if(!$user) $user=$auth->user;
$enableChat = true;

if($auth->user&&$enableChat)
{
	require("chat.php");
}
if($login&&$auth->user)
{
	//if(!$url) header("Location:$site_url"."admin/");
	//else 

	if($url) header("Location:$url");
}


function getform($name,$type,$act,$id)
{
	$objResponse =  new xajaxResponse();


	ob_start(); 

	$_GET['InfoID']=$id;

	$form=new cls_form($type,$act);
	$form->draw();


	$output = ob_get_contents(); 
	ob_end_clean(); 

	//$objResponse->setCharEncoding("windows-1251");

	$output = iconv('windows-1251','utf-8',$output);

	$objResponse->addAssign($name,"innerHTML",$output);

	return $objResponse;
}


function hidehint($type,$pageID,$act,$userID)
{
	$objResponse =  new xajaxResponse();

	if($userID&&$pageID&&$act)
	{

		if($type==1) mysql_query("insert ignore into ut_hint_status values($pageID,$userID,'$act')");
		else mysql_query("delete from ut_hint_status where PageID=$pageID and UserID=$userID");

		//$objResponse->addAlert("$type,$pageID,$act,$userID ".mysql_error());



	}

	return $objResponse;
}

if($xajax)
{

$xajax->registerFunction("hidehint",XAJAX_GET);
$xajax->registerFunction("getform",XAJAX_GET);
$xajax->processRequests();
$xajax->printJavascript("http://".$_SERVER["SERVER_ADDR"].'/cls/ajax/');

}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name="Description" content="интернет игра, онлайн игра, браузерная игра, менеджер, гладиаторы, фэнтези, рпг, турнир, клан, экономическая игра, стратегия, финансы"/>
<meta name="Keywords" content="интернет игра, онлайн игра, браузерная игра, менеджер, гладиаторы, фэнтези, рпг, турнир, клан, экономическая игра, стратегия, финансы"/>

<title>Гладиаторы: <?=$page_title?></title>
<link href="<?=$site_url?>css.css" rel="stylesheet" type="text/css"/>

</head>

<?


print "<script src='".$path."functions.js' language='javascript' type='text/javascript'></script>";

?>

<body>
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center" class="table-border">

  <tr> 
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>&nbsp;</td>
          <td width="768" height="28" valign="top" class="index-top3" >
<center><a href=http://www.gladiators.ru/xml/main/news.php?id=9><font size=+1>Идет бета-тестирование игры</font></a><br><br>
	  </td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>


  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>&nbsp;</td>
          <td width="768" valign="top" class="index-menu">
<table width="100%" height="37" border="0" cellspacing="0" cellpadding="0">
              <tr class=menu> 
                <td width="150">&nbsp;</td>
<?

$i=1;

$ar=DrawMenu(1,0);
foreach($ar as $a) 
{

	print "<td  align=center><center>$a</a></td>";

	if($i<count($ar))
	{
?>
                <td width="22"><img src="<?=$site_url?>images/index-menu-sep.gif" alt="" width="22" height="37"></td>				
<?
	}

	$i++;
} 

?>

<td width="150">&nbsp;</td>
              </tr>
            </table></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td align="center" valign="top"><a href="/"><img src="<?=$site_url?>images/logo1.jpg" alt="" width="800" height="171" border="0"></a></td></tr>


<?
if($auth->user)
{
				if(!$type) $TypeLevel=explode("/","residence/main");
				elseif(!$type_level) $TypeLevel=explode("/",$type);
				else $TypeLevel=explode("/",$type_level);

?>

<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0 
  window.open(theURL,winName,features);
}


//-->
</script>


  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">


        <tr class=menu> 
          <td>&nbsp;</td>
          <td width="768" class="index2-menu2"><center><table width=100% height="37" border="0" cellpadding="0" cellspacing="0">



              <tr>
                <td width="32">&nbsp;</td>

<?

	if(!$font1) $font1="<u>";
	if(!$font2) $font2="</u>";

	$res=runsql("select *,Name_$lang as name from en_menu where Parent='2' order by Rang");

$curmenu='';

	while($r=mysql_fetch_array($res))
	{

			if($TypeLevel[0]==$r[Title]&&$TypeLevel[0]) 
			{
				$u1=$font1;
				$u2=$font2;
			}
			else
			{
				unset($u1);
				unset($u2);
			}


		$r[Url]=set_params($r[Url]);

		if($r[Url]&&!strstr($r[Url],"http://")) $r[Url]="$site_url".$r[Url];

		if($r[Target]) $target=" target=\"$r[Target]\"";
		else unset($target);


		if($u1) {print "<script>var curmenu=$r[MenuID];</script>";$class="class=active";$curmenu=$r[MenuID];}
		else $class="";

		if(!$r[Url]) $a="<font color=dedede>$r[name]</font>";
		else $a= "<a href=\"$r[Url]\" $target onclick='return setcurmenu($r[MenuID]);'><div id='upmenu$r[MenuID]' $class>".$r[name]."</div></a>";

		print "<td width=\"22\"><img src=\"$site_url"."images/marker2.gif\" name=\"Image$i\" alt=\"\" width=\"16\" height=\"16\" border=\"0\"></td>
                <td onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image$i','','/images/marker2_2.gif',1)\"><nobr>$a</td><td width=40px>";

print "<div id=bottommenu$r[MenuID] style=\"display:none\"><table height=29 border=0 cellpadding=0 cellspacing=0><td width=\"64\">&nbsp;</td>";

	$res1=runsql("select *,Name_$lang as name from en_menu where Parent='$r[MenuID]' order by Rang");
	$j=0;


	while($r1=mysql_fetch_array($res1))
	{

			if($TypeLevel[1]==$r1[Title]&&$TypeLevel[1]) 
			{
				$u1=$font1;
				$u2=$font2;
			}
			else
			{
				unset($u1);
				unset($u2);
			}

			$r1[Url]=set_params($r1[Url]);

			if(!strstr($r1[Url],"http://")) $r1[Url]="$site_url".$r1[Url];

			if($r1[Target]) $target=" target=\"$r1[Target]\"";
			else unset($target);

			$a="<a href=\"$r1[Url]\"  $target>$u1".$r1[name]."$u2</a>";

              		print "<td width=\"18\"><img src=\"".$site_url."images/marker3.gif\" alt=\"\" width=\"11\" height=\"11\" border=\"0\"></td><td>$a</td>";

			print "<td width=50px></td>";

			$j++;
		
	}

print "</table></div>";

print "&nbsp;</td>";
		$i++;
	}	

if(!$curmenu) print "<script>var curmenu=9;</script>";

					
		$chatData = select("select count(*) from chat_users");
		$chatersCount = ($chatData)?$chatData[0]:0;
		print"<td width=\"22\"><img src=\"$site_url"."images/marker2.gif\" name=\"Image$i\" alt=\"\" width=\"16\" height=\"16\" border=\"0\"></td>
<td onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image$i','','/images/marker2_2.gif',1)\">
<a href=\"javascript:loginChat()\">Чат [<span id=chatersCount>$chatersCount</span>]</a></td><td width=32>&nbsp;</td>";

?> 
              </tr>
            </table></td>
          <td>&nbsp;</td>
        </tr>
        <tr class=menu>
          <td>&nbsp;</td>
          <td class="index2-menu3" id="bottommenu" align=center>

		<table height="29" border="0" cellpadding="0" cellspacing="0">

              <tr>

<script>


function setcurmenu(menuid)
{



	document.getElementById('upmenu'+curmenu).className='';
	document.getElementById('upmenu'+menuid).className='active';

	document.getElementById('bottommenu').innerHTML=document.getElementById('bottommenu'+menuid).innerHTML;

	if(menuid!=curmenu) {curmenu=menuid;return false;}

	


}
</script>

                <td width="64">&nbsp;</td>
<?

$ar=explode("/",$type);
$a=$ar[0];
$b=$ar[1];


if($type=="residence/friends") $b="profile";


$m=select("select m1.MenuID as Name from en_menu m1 left outer join en_menu m2 on (m1.Parent=m2.MenuID)
where m1.Title='$b' and m2.Title='$a' and m2.Parent=2");

if($m[0]) $menu=Drawmenu($m[0],3);


if($a=="main"||!$a) $q[0]=9; 
else  $q=select("select MenuID from en_menu where Title='$a' and Parent=2");


$ar=DrawMenu($q[0],$TypeLevel[1],'','');

foreach($ar as $a) 
{
                print"<td width=\"18\"><img src=\"".$site_url."images/marker3.gif\" alt=\"\" width=\"11\" height=\"11\" border=\"0\"></td>
                <td>$a</td><td width=50px></td>";
}

?>
              </tr>
            </table></td>
          <td>&nbsp;</td>
        </tr>

      </table></td>

		<?
			if($auth->user &&  $enableChat) require("chatcontent.php");
		?>
  </tr>
  <tr> 
    <td valign="top"><table width="100%" border="0"  cellspacing="0" cellpadding="0">
        <tr>

          <td>&nbsp;</td>
<?
if(!$hide_menu) print "<td width=768><img src=/images/index-top-main.gif width=768 height=17 border=0>";
else print "<td width=768><img src=/images/topline2.gif width=768 height=17 border=0>";
?>
	  <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
<?

}
else
{
?>


  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>&nbsp;</td>
          <td width="768" class="index-menu2">

              <table width="100%" height="37" border="0" cellpadding="0" cellspacing="0">
                <tr> 
<form name="insert" method="post" enctype="multipart/form-data" action="<?=$site_url?>index.php?login=1">
<input type="hidden" name="step" value="1"/>
<input type="hidden" name="url" value="<?=$url?>"/>


                  <td width="20">&nbsp;</td>
                  <td width="32">Логин:</td>
                  <td width="8">&nbsp;</td>
                  <td width="108">
<input type="text" name="auth_name"  style="width: 108px;background-color:#16191C;color:E5CEA6;border:1px solid #53585B;height:20px;background-image:url('/images/formbg.gif');"></td>
                  <td width="38">&nbsp;</td>
                  <td width="39">Пароль:</td>
                  <td width="8">&nbsp;</td>
                  <td width="108" >
<input type="password" name="auth_pass"  style="width: 108px;background-color:#16191C;color:E5CEA6;border:1px solid #53585B;height:20px;background-image:url('/images/formbg.gif');"></td>
                  <td width="17">&nbsp;</td>
                  <td width="49">
<input type="submit" style="background-color:#16191C;color:E5CEA6;border:1px solid #53585B;height:20px;background-image:url('/images/formbg.gif');" value="Войти">

</td>
                  <td width="65"  onclick="document.forms.insert.submit()" style="cursor:hand">&nbsp;</td>
                  <td width="21">
<img src="<?=$site_url?>images/btn-led1.gif" width="21" height="37" border="0"/>

</td>
                  <td width="60">&nbsp;</td>
</form>
                  <td width="76">Выбор языка:</td>
                  <td width="34" align="center"><a href="#"><img src="<?=$site_url?>images/lang-ru.gif" alt="" width="15" height="14" border="0"></a></td>
                  <td width="34" align="center"><a href="#"><img src="<?=$site_url?>images/lang-us.gif" alt="" width="15" height="14" border="0"></a></td>
                  <td width="34" align="center"><a href="#"><img src="<?=$site_url?>images/lang-de.gif" alt="" width="15" height="14" border="0"></a></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>

<?
if(!$hide_menu) print "<td width=768><img src=/images/index-top-main.gif width=768 height=17 border=0>";
else print "<td width=768><img src=/images/topline2.gif width=768 height=17 border=0>";
?>


          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
<?
}
?>


  <tr> 
    <td valign="top" height="606">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="768"  height="606" valign="top" class="table-main" style="background-image: url(/images/index-main-bg<?if($hide_menu) print "2";?>.gif);">



<table width="100%"  height="606" border="0" cellspacing="0" cellpadding="0">


              <tr>

<?

if(!$hide_menu)
{
?>
                <td width="226" valign="top" class="index-left-menu">
<table width="186" border="0" height=100% cellspacing="0" cellpadding="0">

<?
}
else print "<td valign=top style='padding-left:30'>";