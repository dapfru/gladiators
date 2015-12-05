<?
require('../../config.php');

require($engine_path."cls/auth/session_lite.php");


//$first_page=1;

$form_title=message(33);

if(!$act) $act="select";
$type="main/news";

require($site_path."up.php");
//$page="first";

if($act=="addcomment") $form=new cls_form($type,"select");

require($site_path."left.php");

?>

<table border=0 cellpadding=4 cellspacing=1 width=100%>
<?

$res=$form->sqlres;
while($r=mysql_fetch_array($res))
{

?>

                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="0">
                              <tr>
                                <td width="20px" align="center" valign="middle"><img src="/images/marker2.gif" width="16" height="16"></td>
                                <td align="left" valign="middle"><font  class="blue-b"><?=date("d.m.Y H:i",$r[Date])?>

				</td>

<?
if($r[Small]) 
{
	print "<td rowspan=2>";
	if(strlen($r[Small])!=strlen($r[Image])) print "<a href=\"$img_url?id=$r[NewsID]&table=ut_news&record=22\" target=_blank>";
	print "<img src=\"$img_url?id=$r[NewsID]&table=ut_news&record=23\" border=0 align=right>";
	print "</td>";
}
?>

				</tr><tr><td></td><td>




<?

print "<b><font color=#F5D59E>$r[Name]</font></b><br>";


if($id&&$r[Message]) print setTags($r[Message]);
else print setTags($r[Headline]);

if($r[Message]&&!$id) print " <a href=\"/xml/main/news.php?id=$r[NewsID]\"><b>".message(34)."  »</b></a>";


?>
				 </td>
                              </tr>

				<tr><td></td><td><img src="/images/hr.gif" height=10px></td>
                            </table></td>
                          </tr>

<?
}
?>
                         <?=$form->Pages(2)?>
<?
print "</table>";

if($id) 
{

	if($act=="addcomment"&&!$er) unset($do);
$auth->rang=1;
	if($do!=addcomment&&$auth->rang>0&&$auth->user) print "<center><a href=\"$PHP_SELF?id=$id&do=addcomment\">".message(38)."</a></center>";
	elseif($auth->rang>0&&$auth->user) 
	{
		print "<br>";
		$form=new cls_form($type,$do);
		$form->Draw();
	}

		print "<br>";


$form=new cls_form($type,'comments');
	$res=$form->sqlres;
	$i=1;

print "</center><div align=right><a href=$PHP_SELF>вернуться к списку</a> <img src=\"/images/marker3.gif\" width=11 height=11 border=0></center>";
?>

<table border=0  width=100% bgcolor=#78746C cellpadding=4 cellspacing=1>
<?




	while($r=mysql_fetch_array($res))
	{

		print "<table border=0  width=100% bgcolor=#78746C cellpadding=4 cellspacing=1>";

		print "<tr bgcolor=#56666B><td bgcolor=3B484C valign=top align=center rowspan=2 width=100px>";

		if($r[Approved]==1) print "<img src=\"/images/ut_users/small/$r[UserID].jpg\" border=0><br>";

		print "<center><a href=\"/users/$r[UserID]\"><b>Профиль</b></a></td>";

		if(!$r[Login]) $r[Login]=$r[FirstName]." ".$r[LastName];

		print "<td colspan=2 class=header><table border=0 cellspacing=0 cellpadding=0 width=100%  style=\"color:4F7BA6\"><td><b>$r[Login]</td><td align=\"right\"><b>".date("d.m.Y H:i",$r[Date])."</td></table></td>";


		print "<tr bgcolor=#56666B><td height=\"100px\" valign=top>";

		if($r[Image]) 
		{
			if(strlen($r[Image])!=strlen($r[Small])) print "<center><a href=\"$img_url?id=$r[MessageID]&record=20\" target=_blank>";
			print "<img src=\"$img_url?id=$r[MessageID]&record=21\" border=0></a></center><br>";
		}


		print $r[Comment];

		print "</td></tr>";

		print "</table><br>";
	}

	pages();

}



require($site_path."bottom.php");
?>
