<?
require('../../config.php');


$type="main/contacts";



require($engine_path."cls/auth/session_lite.php");

if($auth->user) $form_width="170";
else $showmenu=0;

if(!$act) $act="select";


require($site_path."up.php");



$i=0;

$res=runsql("select ClassID,Name_$lang as Name from ut_post_classes order by Rang,Name");
while($r=mysql_fetch_array($res))
{

	if($id==$r[0])  $menu[$i]="<font class='current'>$r[1]</font>";
	else $menu[$i]="<a href=\"$PHP_SELF?id=$r[0]\">$r[1]</a>";

	$i++;
}

require($site_path."left.php");


if(!$id)
{


?>
<center>
<table width="100%" border=0 cellspacing=0 cellpadding=0 height=80px>
<td background="/images/logobk.gif" bgcolor=F5CE27 style="CURSOR: hand" onclick="window.location.href='http://www.nekki.ru', '_blank'" ><center><a href="http://www.nekki.ru" target=_blank><img width=130 height=80px src="/images/nekkibig.gif" border=0></a></td></table>
<img src="/images/hr.gif"><br>Разработчик и издатель игры - ООО "Некки"
<br>Официальный сайт компании: <a href="http://www.nekki.ru" target=_blank>www.nekki.ru</a>
<img src="/images/hr.gif"><br><b>
По вопросам сотрудничества и рекламы обращайтесь по адресу <a href="mailto:info@nekki.ru">info@nekki.ru</a>

<img src="/images/hr.gif"></b>



<table border=0 cellspacing=1 cellpadding=5>
<tr valign=top>

<td><a href=http://www.gladiators.ru><img src=http://www.gladiators.ru/images/88x31.gif title="Онлайн игра Гладиаторы" border=0></a>
</td>

<td><b>
Кнопка:<br>
<textarea cols=75 rows=4>
&lt;a href=http://www.gladiators.ru&gt;&lt;img src=http://www.gladiators.ru/images/88x31.gif title="Онлайн игра Гладиаторы" target=_blank border=0&gt;&lt;/a&gt;
</textarea>

<br>Текстовая ссылка:<br>
<textarea cols=75 rows=3>
Бесплатная многопользовательская &lt;a href=http://www.gladiators.ru/  target=_blank&gt;онлайн игра&lt;/a&gt; Гладиаторы  
</textarea>

</td>
</table>

</center>
<?
}
elseif($auth->user) $form->Draw();

//if(!$auth->user) { print icon("quest", "Список контактов администрации проекта Вы сможете найти на этой странице после авторизации.");}

require($site_path."bottom.php");
?>
