<?
//exit;

require('config.php');
require($engine_path."cls/auth/session_lite.php");

$page="first";
$first_page=1;

require("up.php");


require("left.php");


if($er)  print "<div style=\"margin-left:15px;margin-bottom:10px\"><table border=0 cellspacing=4 cellpadding=0 width=100%><td>".icon('error',$er)."</td></table></div>";

?>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main-sheet">
                    <tr> 

                      <th>ДОБРО ПОЖАЛОВАТЬ</th>
                    </tr>
                    <tr> 
                      <td valign="top"><div class="main-sheet-text"> 

                          <p><i>Толпа всегда хотела хлеба и зрелищ. Увидев сверкающие славой арены Рима, ты начинаешь это понимать, как никогда раньше...</i> </p>
                          <p><b>Гладиаторы</b> - бесплатная массовая многопользовательская <b>онлайн игра</b>. В ней Вы соревнуетесь с другими игроками, управляя отрядом отважных гладиаторов и участвуя в различных турнирах.
</p><p> Для игры <b>не требуется</b> установки никакого программного обеспечения, Вы можете играть с любого компьютера и в любое время.
				</p>

<p><i>...А еще толпа любит героев. Любой, кто выходит на арену, должен это понять...</i></p>




			  <p>Вам будет доступно 10 исторически достоверных типов гладиаторов, включая конных, лучников и колесничих. Каждый тип обладает своими преимуществами и недостатками, изучив которые, Вы научитесь побеждать.</p>

<p><i>...Если ты можешь удивить толпу, став хотя бы на миг их божеством, 
неважно будет насколько ты искусный воин. А слава победителя в Риме всегда дорого стоит.</i></p>

			<p>Кроме боёв, Вы сможете застраивать свой лагерь, нанимать специалистов в школу гладиаторов, торговать и обмениваться бойцами с другими участниками игры, вступать в гильдии и вести политическую деятельность в Сенате.</p>
<?
/*
			<p>уникальных преимуществ <b>Гладиаторов</b> является зрелищный <b>3d-показ</b>, позволяющий погрузиться 
в неповторимую атмосферу гладиаторских боёв!</p>
*/
?>


		

                        </div></td>
                    </tr>
                  </table>

		<table width="100%" height="32" border="0" cellspacing="0" cellpadding="0">					
                    <tr>
                      <td width="24">&nbsp;</td>
                      <td width="164"><a href=<?=$site_url."xml/main/register.php";?>><img src="<?=$site_url?>images/text-register.gif" alt="" width="136" height="17" border="0"></a></td>
                      <td width="200"><a href="#"><img src="<?=$site_url?>images/text-guest.gif" alt="" width="172" height="17" border="0"></a></td>
                      <td><a href="screenshots.php"><img src="<?=$site_url?>images/text-screenshots.gif" alt="" width="121" height="17" border="0"></a></td>
                    </tr>
                  </table>
				  
		<table width="500" border="0" cellspacing="8" cellpadding="0" style="margin: 0px 0px 0px 16px;">
                    <tr>
<?
$res=runsql("select ScreenshotID,Name_$lang as Name from ut_screenshots order by rand() limit 0,3");
while($r=mysql_fetch_array($res))
{
?>
                            <td width="33%" align="center" valign="top">

	<?
		print "<a href=\"screen.php?record=14&amp;id=$r[0]\" target=_blank>";
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


require("bottom.php");
?>
