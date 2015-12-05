<?
$type="main";
require("config.php");

$first_page=1;
$form_title="Подписка";

require("up.php");

if($unsubscribe==1)
{
	if(!$email) 
	{
	print icon("error","Вы не заполнили поле \"E-mail\"! Пожалуйста, заполните поле \"E-mail\" и повторите попытку.");
	}
	elseif(!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/", $email ))
	{
	print icon("error","Неверный адрес e-mail. Пожалуйста, введите корректный адрес e-mail и повторите попытку.");
	}
	else
	{
	$res=select("select * from ut_subscribe where Email='$email'");
	if(!$res[SubscribeID])
		{
		print icon("error","На данный адрес e-mail рассылка новостей не ведётся.");
		}
	else
		{
		runsql("delete from ut_subscribe where Email='$email'");
		print icon("green","Вы успешно отписались от новостей компании \"Парсек\"");
		}
	}
}
else
{
	if(!$email) 
	{
	print icon("error","Вы не заполнили поле \"E-mail\"! Пожалуйста, заполните поле \"E-mail\" и повторите попытку.");
	}
	elseif(!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/", $email ))
	{
	print icon("error","Неверный адрес e-mail. Пожалуйста, введите корректный адрес e-mail и повторите попытку.");
	}
	else
	{
	$res=select("select * from ut_subscribe where Email='$email'");
	if($res[SubscribeID])
		{
		print icon("green","Вы уже имеете подписку на новости компании \"Парсек\"");
		}
	else
		{
		runsql("insert into ut_subscribe (Name,Email) values ('$name','$email')");
		print icon("green","Вы успешно подписались на новости компании \"Парсек\"");
		}
	}
}

require("bottom.php");

?>