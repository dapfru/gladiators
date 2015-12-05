<?
require('config.php');
require($engine_path."cls/auth/session_lite.php");

$page="first";
$first_page=1;

require("up.php");


require("left.php");


if($er)  print "<div style=\"margin-left:15px;margin-bottom:10px\"><table border=0 cellspacing=4 cellpadding=0 width=100%><td>".icon('error',$er)."</td></table></div>";




if($auth->user)
{

	print "<div style=\"margin-left:15px;margin-bottom:10px\">";

	$q=select("select a.Message,u.GuildID,u.Login,u.GuildStatusID,u.UserID from ut_announcements a join ut_users u using(UserID) where a.Active=1 order by a.Date desc limit 0,1");
	if($q[0]) 
	{
		print "<table border=0 cellspacing=4 cellpadding=0 width=485px><td>".icon('green',setTags($q[Message]."<br><div align=right>".username($q,1)."</div>"));
		print "</td></table><br>";
	}

?>

<!-- bof RedTram N4P -->   


<table border=0 width=485px cellspacing=0 cellpadding=0>
<td>
<font  style="text-decoration: none;font-weight:bold;font-size: 13px;margin-left:10px">Новое на форуме</font>
<img src=/images/hr2.gif width=180px height=10px>
<table border=0 width=240px cellspacing=0 cellpadding=0>
<?
include("php/informer1.html");
?></table>
</td><td>

<font  style="text-decoration: none;font-weight:bold;font-size: 13px;margin-left:10px">Популярные темы</font>
<img src=/images/hr2.gif width=180px height=10px>
<table border=0 width=240px cellspacing=0 cellpadding=0>
<?
include("php/informer2.html");
?></table>
</table>

<table cellspacing="0" cellpadding="0" border="0" width="443">

<tr>

<td colspan="3" bgcolor="#515E64" style="padding-left:10px;">

<font style="text-decoration: none;font-weight:bold;font-size: 13px">Интересные факты от RedTram</font>

</td>

</tr>

<tr><td><img src="/images/hr.gif" height="10"  width=473></td>

</tr>

<tr>

<td width="441" align="center" bgcolor="#515E64"><div id="rtn4p_len">  <center>Загрузка ...</center></div>

</td>

</tr>

<tr>

<td colspan="3"><img src="/images/hr.gif" height="10"  width=473></td>

</tr>

</table>

<!-- eof RedTram N4P --> 



<!-- bof RedTram N4P -->   

<table cellspacing="0" cellpadding="0" border="0" width="443" >


</tr>



<tr>

<td width="441" align="center" bgcolor="#515E64"><div id="rtn4p_len2">  <center>Загрузка ...</center></div>

</td>

</tr>

<tr>

<td colspan="3"><img src="/images/hr.gif" height="10" width=473></td>

</tr>

</table>

<!-- eof RedTram N4P --> 

</div>
<?
}
else
{
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


			  <p>Вам будет доступно 10 исторически достоверных типов гладиаторов, включая конных, лучников и колесничих. Каждый тип обладает своими преимуществами и недостатками, изучив которые, Вы научитесь побеждать.</p>



			<p>Кроме боёв, Вы сможете управлять школой гладиаторов и другими постройками, нанимать мастеров, торговать и обмениваться бойцами с другими участниками игры, вступать в гильдии и вести политическую деятельность в Сенате.</p>

			<p>Увлекательный игровой процесс подарит Вам много положительных эмоций! Чтобы начать играть уже сейчас, начните с <a href=/xml/main/register.php><font color=48310A><u><b>быстрой процедуры регистрации</u></b></font></a>.</p>
<?

/*
			<p>уникальных преимуществ <b>Гладиаторов</b> является зрелищный <b>3d-показ</b>, позволяющий погрузиться 
в неповторимую атмосферу гладиаторских боёв!</p>
*/
?>


		

                        </div></td>
                    </tr>
                  </table>


				

<?
}

require("bottom.php");