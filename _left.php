<?

if($login)
{

	if(!$auth_name||!$auth_pass) $er= message(49);
	elseif(!$auth->user)  
	{
		$q=select("select * from ut_users where Login='$auth_name'");

		if(!$q[UserID]) $er= message(8);
		elseif($q[Active])	$er= message(7);
		else	$er= message(48);
	}


}



if(!$hide_menu)
{

if($auth->user)
{
//---------- вывод базовой статистики пользователя-----------



$r1=select("select count(MessageID) from ut_messages where UserID2='$auth->user' and Status<2 and Support<>1");
$mailnum=$r1[0];
$r1=select("select count(MessageID) from ut_messages where UserID2='$auth->user' and Status=0 and Support<>1");
$unreadnum=$r1[0];


$r1=select("select HolidayID,Name_$lang Name from ut_holidays
 where (from_unixtime(unix_timestamp(),'%d')>=Day1 and from_unixtime(unix_timestamp(),'%m')=Month1)
 or (from_unixtime(unix_timestamp(),'%d')<=Day2 and from_unixtime(unix_timestamp(),'%m')=Month2)");
if($r1[HolidayID]) $curholiday=$r1[Name];


print "<tr><td><table border=0 cellspacing=0 cellpadding=0 width=180px  class=menu>

<tr><td><img src=\"/images/icons/profile.gif\"></td><td colspan=2>
<table border=0 cellspacing=0 cellpadding=0 width=100%><td><a href=\"/xml/residence/info.php\"><b>Логин:</a></b></td><td align=right><a href=\"/xml/residence/info.php\">$auth->nick</a></b></table></td>
<tr><td colspan=3><img src=\"/images/hr2.gif\" height=10px width=180px></td>";

if(!$hide_finances) print "<tr><td><img src=\"/images/icons/finance.gif\"></td><td><a href=\"/xml/residence/treasury.php\"><b>Финансы:</a></b></td><td align=right><a href=\"/xml/residence/treasury.php\">".dots($auth->rst[Money])."</a></td>
<tr><td colspan=3><img src=\"/images/hr2.gif\" height=10px width=180px></td>";

print "<tr><td><img src=\"/images/icons/sword.gif\"></td><td><b><a href=\"/xml/gladiators/\">Гладиаторы:</a></b></td><td align=right><a href=\"/xml/gladiators/\">".count($auth->rst[Gladiators])."</a></td>
<tr><td colspan=3><img src=\"/images/hr2.gif\" height=10px width=180px></td>
<tr><td><img src=\"/images/icons/";

if($unreadnum>0) print "blink";
print "mail.gif\"></td><td><b><a href=/xml/residence/mail.php>Почта:</a></b></td><td align=right><a href=/xml/residence/mail.php>";

if($unreadnum>0) print "<b>";

print "$unreadnum</font></b>/$mailnum</td>";

if($curholiday)
{
print "<tr><td colspan=3><img src=\"/images/hr2.gif\" height=10px width=180px></td>
<tr><td><img src=\"/images/icons/cup.gif\"></td><td colspan=2>
<table border=0 cellspacing=0 cellpadding=0 width=100%><td><b><a href=\"/xml/misc/holidays.php\">Праздник:</a></b></td><td align=right><a href=\"/xml/misc/holidays.php#$r1[HolidayID]\">$curholiday</a></b></table></td>
";
}


print "<tr><td colspan=3><img src=\"/images/hr2.gif\" height=10px width=180px></td>
<tr><td><img src=\"/images/types/4.gif\"></td><td>";


$q=select("select * from ft_agreements where (UserID1='$auth->user' or UserID2='$auth->user') 
and StatusID=2");

if($q[0])
{
	if(file_exists($site_path."files/ord/".$q[0]."-".$auth->user.".ord")) print "<a href=\"/xml/arena/fight.php?id=$q[0]\"><b>Ожидание боя</b></a>";
	else print "<a href=\"/builder/?id=$q[0]\"><b>Подготовка к бою</b></a>";
}
else
{
	print "<a href=\"/xml/arena/lastfight.php\"><b>Предыдущий бой</b></a>";
}


//print "Подготовка к бою";
//print "Ожидание боя";
//print "Ожидание турнира";
//print "Предыдущий бой";

print "</b></a></td>";



print "<tr><td colspan=3><img src=\"/images/hr2.gif\" height=10px width=180px></td><tr height=10px><td colspan=3 valign=middle align=center><a href=\"/xml/main/logout.php?do=logout\">выйти из игры</a></td>";
print "<tr height=20px><td colspan=3 valign=middle><img src=\"/images/sep.gif\" height=1px width=180px></td><tr height=10px><td colspan=3></td></tr>
</table></td></tr>";
//-----------------------------------------------------------
}

//if(!$menu&&!$leftcontent&&(!$auth->user||$first_page==1))
if($first_page==1||$type=="main/news")
{
?>
                    <tr> 
                      <td><font size=4>Новости игры</td>
                    </tr>

<? 
	if($auth->user) $lim=4;
	else $lim=5;

	$res=runsql("select NewsID,Name, Headline, Message, Date from ut_news order by Date desc limit 0,$lim");
	
	while($r1=mysql_fetch_array($res))
	{
?>
                    <tr> 
                      <td><img src="<?=$site_url?>images/line-sep.gif" width="180" height="30"></td>
                    </tr>
                    <tr> 
                      <td>
			<?

			print date("d.m.Y",$r1[Date])." // ".date("H:i",$r1[Date])."<br>
	<strong><br><font color=#F5D59E>$r1[Name]"."</font></strong><br>
                        $r1[Headline] ";
			print "<nobr><a href=\"$site_url"."xml/main/news.php?id=$r1[NewsID]\"><b>".message(34)."  »</a></b></nobr>";
?>
		</td>
                    </tr>
                   
                  
<?	}	

?>
                      <tr>
                        <td align="center" valign="middle">&nbsp;</td>
                      </tr>
 		<tr height=100%>
                        <td align="center" valign="bottom"><br>
<a href="<?=$site_url?>xml/main/news.php" class="orange-b"><?=upstr(message(33))?> </b></a>
			</tr>
                      <tr>
                        <td align="center" valign="middle">&nbsp;</td>
                      </tr>
<?
}
else
{
		$i=0;
		foreach($menu as $a)
		{

			if($a)
			{


?>
                          <tr class=menu>
				<td height=20px>
<?

				if(strstr($a,"##")) 
				{
					$b=explode("##",$a);
					print "<table border=0 cellspacing=0 cellpadding=0 width=180px><tr>";

					print "<td width=14px><img src=\"/images/marker3.gif\" width=11 height=11   align=\"absmiddle\"/></td><td>";

					print "$b[0]</td><td align=right><nobr>$b[1]</td></table>";
				}
				else
				{
					if(!strstr($a,"<img")) 	print "<img src=\"/images/marker3.gif\" width=11 height=11/>";
					print " $a</td>";
				}

                        	print "</tr>";
	
				print "<tr><td><img src=\"/images/hr2.gif\" height=10px width=180px></td></tr>";

			}

			$i++;
		}
print "<tr><td>".$leftcontent."</td></tr>";

	print "<tr height=100%><td>&nbsp;</td></tr>";
}

print "</table></td><td width=\"520\" valign=\"top\">";

}

if($form->image)
{
?>
<center><img src="<?=$form->image?>" width=500px height=300px></center><br>
<?
}

if($form_result) print $form_result;
elseif($step&&!$runsql&&$form) $form->runsql();

if(($oldact!=$act)&&$er&&$step) {$form = new cls_form($type,$oldact);$act=$oldact;}



?>