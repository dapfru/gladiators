<?
if($first_page==1)
{
?>
		<table width="100%" height="32" border="0" cellspacing="0" cellpadding="0">					
                    <tr>
                      <td width="24">&nbsp;</td>
                      <td width="174"><a href=<?=$site_url."xml/main/register.php";?>><img src="<?=$site_url?>images/text-register.gif" alt="" width="136" height="17" border="0"></a></td>
                      <td width="190"><a href="/demo.php"><img src="<?=$site_url?>images/text-guest.gif" alt="" width="172" height="17" border="0"></a></td>
                      <td><a href="/screenshots.php"><img src="<?=$site_url?>images/text-screenshots.gif" alt="" width="121" height="17" border="0"></a></td>
                    </tr>
                  </table>
<?
if($type!="main/screenshots")
{
?>
				  
		<table width="500" border="0" cellspacing="8" cellpadding="0" style="margin: 0px 0px 0px 16px;">
                    <tr>
<?
$res=runsql("select ScreenshotID,Name_$lang as Name from ut_screenshots order by rand() limit 0,3");
while($r=mysql_fetch_array($res))
{
?>
                            <td width="33%" align="center" valign="top">

	<?
		print "<a href=\"screen.php?record=14&amp;id=$r[0]\">";
		print "<img src=\"/images/ut_screenshots/small/$r[0].jpg\" border=0 ";
		if($r[Name]) print " alt=\"$r[Name]\" title=\"$r[Name]\"";
		print "/> \n";
	?>
	</a></td>
<?
}
?>
                    </tr>
                  </table>

<?
}

}
?>

<br><?
if($form->hint) print hint($form->hint,$form->pageid,$form->name)."<br>";

?>
				  </td><td width=30px>&nbsp;</td>
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
          <td width="768"  class="bottom"><table width="100%" height="89" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="50">&nbsp;</td>
                <td width="44"><a href="mailto:info@nekki.ru"><img src="<?=$site_url?>images/email-img.gif" alt="email" width="29" height="27" border="0"></a></td>
                <td width="164" class="bottom-text"><strong><a href="mailto:info@nekki.ru">info@nekki.ru</a></strong></td>
                <td width="100"><a href="http://www.nekki.ru" target=_blank><img src="<?=$site_url?>images/banner-nekki.gif" alt="" width="83" height="40" border="0"></a></td>
                <td width="210" class="bottom-text"><strong>Онлайн игра "Гладиаторы"<br>© ООО &quot;Некки&quot; 
                  2005-<?=date("Y",mktime())?><br>
                  Все права защищены.</strong></td>
<td  style='padding-right:5px;padding-top:5px' width=98px>

<!--Gladiators.ru COUNTER--><a target=_top
href="http://www.gladiators.ru"><img
src="http://www.gladiators.ru/counter/cnt.php?id=1"
border=0 height=31 width=88
alt="Онлайн игра Гладиаторы"
title="Онлайн игра Гладиаторы"/></a><!--/COUNTER-->


</td>
                <td width=120px  >



<?
if($type!="gladiators/builder")
{
?>

<!--Rating@Mail.ru COUNTEr--><a target=_top
href="http://top.mail.ru/jump?from=1157417"><img
src="http://d9.ca.b1.a1.top.list.ru/counter?id=1157417;t=84"
style="filter:alpha(Opacity=50)"
border=0 height=18 width=88
alt="Рейтинг@Mail.ru"/></a><!--/COUNTER-->

<br>


<!--LiveInternet counter--><script type="text/javascript"><!--
document.write('<a href="http://www.liveinternet.ru/click" '+
'target=_blank><img src="http://counter.yadro.ru/hit?t25.6;r'+
escape(document.referrer)+((typeof(screen)=='undefined')?'':
';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+';u'+escape(document.URL)+
';'+Math.random()+
'" alt="" title="LiveInternet: показано число посетителей за сегодн\я" '+
'border=0 style=filter:alpha(Opacity=50) width=88 height=15><\/a>')//--></script><!--/LiveInternet-->

<?
}
?>


</td>
              </tr>
            </table></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<?
if($auth->user)
{
?>
<script language="javascript" type="text/javascript" src="http://js.redtram.com/n4p/g/l/gladiators.ru.len.js"></script>
<script language="javascript" type="text/javascript" src="http://js.redtram.com/n4p/g/l/gladiators.ru.len2.js"></script>
<?
}
?>
</body>
</html>
<script>
if(document.getElementById("chatContent")) document.getElementById("chatContent").scrollTop=1000000;
</script>
<?

$db->close();
?>
