<?
require('../../config.php');

require($engine_path."cls/auth/session_lite.php");


$form_width=170;


$type="main/news";



require($site_path."up.php");



$leftcontent="<center><a href=http://www.rovercomputers.ru target=_blank><img src=/images/misc/rover.gif  border=0></a> 
<br><br><a href=http://www.manowar.ru target=_blank><img src=/images/misc/manowarru.gif  border=0></a>
<br><br><a href=http://www.nekki.ru target=_blank><img src=/images/misc/nekki.gif border=0></a>";

require($site_path."left.php");



?><center>
<a href=http://www.roverpc.ru/pc/a-manovar/1.htm target=_blank><img src=/images/manowar.gif border=0></a></center>



<img src='/images/misc/phone.gif' align=right>
<br>
Во Дворце спорта «Лужники» 7 апреля 2007 года состоится грандиозный концерт группы Manowar. Концерт пройдет в рамках европейского турне в поддержку нового альбома «Gods of War». Это первый концептуальный альбом Manowar, посвященный Одину – главному Богу скандинавской мифологии. 
<br><br>
Группа была создана в 1980 году бассистом Joey De Maio и гитаристом Ross the Boss. Третьим членом команды стал вокалист Eric Adams, чей мощный и чистый голос превратился в одну из визитных карточек группы. Состав был доукомплектован барабанщиком Scott Columbus, после чего и началась история великой группы. 

<br><br>
В 1994 году Manowar удалось войти в Книгу рекордов Гиннеса благодаря своему мощнейшему звучанию на одном из концертов. При громкости 129,5 децибел (громче взлетающего боинга) группа добилась не только самого мощного, но и кристально чистого звука. 

<br><br>
Концерт Manowar в «Лужниках» 7 апреля 2007 года обещает быть громким, мелодичным и неповторимым. Группа сыграет как песни со своего нового альбома, так и всем полюбившиеся классические хиты. Это будет самый настоящий «гром» в апреле!

<br><br>

<font size=4>Условия конкурса</font>

<br>
<br>

Издатель и разработчик игры "Гладиаторы" - <a href=http://www.nekki.ru taret=_blank>компания Nekki</a> совместно с <a href=http://www.roverpc.ru target=_blank>RoverPC</a> и <a href=http://www.manowar.ru target=_blank>сайтом Manowar.Ru</a> проводит конкурс! 
В качестве призов будет разыграно <b>5 пар билетов на концерт</b>!
<br>
Для участия в конкурсе, Вам необходимо зарегистрироваться в нашем проекте и правильно ответить на вопросы викторины, посвященной Manowar и Rover. Конкурс проводится до 31 марта, а итоги будут подведены 2 апреля. Забрать призы можно будет в офисе Rover PC.

<br><br>

<font size=4>Викторина</font>

<br>
<br>




<?

/*
if($step==1&&$auth->user)
{

	if(count($_POST['question'])!=9) print icon("error","Ответьте на все вопросы!")."<br>";
	else 
	{

	foreach($_POST['question'] as $k=>$v)
	{
		runsql("insert into ut_votes(PollID,AnswerID,UserID) values('$k','$v','$auth->user')
on duplicate key update AnswerID='$v'");
	}

		
	}
}


$q=select("select * from ut_votes where UserID='$auth->user'");
if($q[0]) print icon("ok","Ваши ответы приняты! Вы можете изменить их до окончания конкурса.")."<br>";

if($auth->user)
{
?>
<form method='post' action='<?=$PHP_SELF?>'>
<input type='hidden' name='step' value='1'>
<table border=0 bordercolor=78746C bgcolor=78746C cellpadding=4 cellspacing=1 width=100%>
<?


$q=runsql("select p.PollID,p.Name_rus,v.AnswerID from ut_polls p left outer join ut_votes v on v.PollID=p.PollID and v.UserID='$auth->user'");

$n=1;


while($r=mysql_fetch_array($q))
{

	print "<tr><td bgcolor=3B484C>$n. <b>$r[1]</b></td></tr><tr><td bgcolor=#515E64>";

	$q1=runsql("select AnswerID,Name_$lang Name from 
ut_answers where PollId='$r[0]' and Name_$lang<>'' order by AnswerID");

while($r1=mysql_fetch_array($q1))
{
	print "<input type=radio style='background-color:#515E64' name=\"question[".$r[0]."]\" value=$r1[0] ";
	if($r1[0]==$r[2]) print "checked";
	print "> $r1[1]<br>";

}
	
	$n++;
}



?>
<tr class=header><td><input type=submit value=Отправить class=button></td>
</table>
<?
print "</form>";
}
else print icon("error","Для участия в викторине, Вам необходимо <a href=/xml/main/register.php target=_blank>зарегистрироваться</a> и авторизоваться");

*/
print icon("green","Конкурс завершен, подводятся итоги.");
require($site_path."bottom.php");
?>
