<? 
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
error_reporting(0);
include("config.php"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<?
if($_GET['page']=='chislo') { $page_name = "Угадай число"; }
elseif($_GET['page']=='par_prog') { $page_name = "Партнерская программа"; }
elseif($_GET['page']=='vesna') { $page_name = "Лотерея \"Весна\""; }
elseif($_GET['page']=='moment') { $page_name = "Лотерея \"Момент\""; }
elseif($_GET['page']=='dama') { $page_name = "Пиковая дама"; }
elseif($_GET['page']=='tuz') { $page_name = "Три туза"; }
elseif($_GET['page']=='rules') { $page_name = "Правила"; }
elseif($_GET['page']=='kurs') { $page_name = "Описание WebMoney"; }
elseif($_GET['page']=='nap') { $page_name = "Наперстки"; }
elseif($_GET['page']=='eagle') { $page_name = "Орел и решка"; }
elseif($_GET['page']=='kozir') { $page_name = "Козырь"; }
elseif($_GET['page']=='bandit') { $page_name = "Однорукий бандит"; }
elseif($_GET['page']=='mig_udachi') { $page_name = "Миг удачи"; }
elseif($_GET['page']=='week_bonus') { $page_name = "Еженедельный бонус"; }
elseif($_GET['page']=='stat_wins') { $page_name = "Статистика выигрышей"; }
elseif($_GET['page']=='pyramid') { $page_name = "Пирамида"; }
elseif($_GET['page']=='partner') { $page_name = "Наши партнеры"; }
elseif($_GET['page']=='pay') { $page_name = "Пополнение счета"; }
elseif($_GET['page']=='pay_out') { $page_name = "Снятие со счета"; }
elseif($_GET['page']=='light_enter') { $page_name = "Вход по паролю"; }
elseif($_GET['page']=='login') { $page_name = "Вход в игровую зону"; }
elseif($_GET['page']=='regainbonus') { $page_name = "Бонус на депозиты"; }
elseif(($_GET['page']=='')||(isset($_GET['page']))) { $page_name = "Главная страница"; }
else  { $page_name = "Страница не найдена"; }
?>
<head>
<title><? echo $title; ?> - <? echo $page_name; ?></title>
<META http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META name="keywords" Content="азартные игры лотереи, лотерея, интернет казино, игры on-line казино партнерская программа заработок">
<META name="description" Content="Азартные игры на WebMoney. Популярные игры, доступные ставки и крупные выигрыши. Испытай свою удачу!">
<META name="revisit" content="3 days">
</head>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<LINK rel="stylesheet" href="index.css" type="text/css">
<SCRIPT language=JavaScript1.2 src="user_menu.js"></SCRIPT>
<script language="JavaScript" src="http://www.ultrex.ru/js/ajax_ru/stat.php?p=<? echo $id; ?>&url=<? echo $url; ?>"></script>
<script language="JavaScript" src="http://www.ultrex.ru/ajax/jsscr.js"></script>

<!--header-->
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR bgColor=#93BEEA>
    <TD width="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD><A href="<? echo $url; ?>"><IMG height=75 alt="Азартные игры на WebMoney" 
            src="img/logo.gif" width=350 border=0></A></TD>
          <TD width="519" valign="top"><p align="center"><? include("citata.php"); ?>&nbsp;&nbsp;</p></TD></TR></TBODY></TABLE>
    <TD vAlign=bottom align=right width=250 rowSpan=3></TD></TR>
  <TR>
    <TD bgColor=#ffffff height=1></TD></TR>
  <TR>
    <TD bgColor=#6677aa>
      <TABLE cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR height=23>        
          <TD class=white_small>&nbsp;&nbsp;<A href="<? echo $url; ?>" class=whitelink>Главная</A>&nbsp;&nbsp;|</TD>
          <TD class=white_small align=left><ILAYER><LAYER 
            visibility="show">&nbsp;&nbsp;<A class=whitelink 
            onmouseover="dropit(event,(nn6) ? 'dropmenu1' : dropmenu1,'document.dropmenu1',86);" 
            href="javascript:void(0);">Игры</A>&nbsp;&nbsp;|</LAYER></ILAYER></TD>
          <TD class=white_small align=left><ILAYER><LAYER 
            visibility="show">&nbsp;&nbsp;<A class=whitelink 
            onmouseover="dropit(event,(nn6) ? 'dropmenu2' : dropmenu2,'document.dropmenu2', 142);" 
            href="javascript:void(0);">Лотереи</A>&nbsp;&nbsp;|</LAYER></ILAYER></TD>
          <TD class=white_small align=left><ILAYER><LAYER 
            visibility="show">&nbsp;&nbsp;<A class=whitelink 
            onmouseover="dropit(event,(nn6) ? 'dropmenu3' : dropmenu3,'document.dropmenu3', 142);" 
            href="javascript:void(0);">Информация</A>&nbsp;&nbsp;|</LAYER></ILAYER></TD>
          <TD class=white_small align=left nowrap><ILAYER><LAYER 
            visibility="show">&nbsp;&nbsp;<A class=whitelink 
            onmouseover="dropit(event,(nn6) ? 'dropmenu4' : dropmenu4,'document.dropmenu4', 230);" 
            href="javascript:void(0);">Партнерская программа</A>&nbsp;&nbsp;|</LAYER></ILAYER></TD>
          <TD class=white_small align=left nowrap><ILAYER><LAYER 
            visibility="show">&nbsp;&nbsp;<A href="<? echo $url; ?>/?page=partner" class=whitelink>Наши партнеры</A></LAYER></ILAYER></TD>
          <TD class=white_small width=100% align=right id=nav_login><ILAYER><LAYER 
            visibility="show">&nbsp;&nbsp;</LAYER></ILAYER></TD></TR></TBODY></TABLE></TD></TR><!--/left corner-->

<TR bgColor=#ffffff>
    <TD colSpan=2></TD></TR>
  <TR bgColor=#223388>
    <TD colSpan=2></TD></TR></TBODY></TABLE><!--/header-->
<DIV id=dropmenu1 
style="BORDER-RIGHT: #165595 1px solid; PADDING-RIGHT: 0px; BORDER-TOP: #165595 1px solid; PADDING-LEFT: 0px; LEFT: 0px; VISIBILITY: hidden; PADDING-BOTTOM: 0px; BORDER-LEFT: #165595 1px solid; WIDTH: 170px; PADDING-TOP: 0px; BORDER-BOTTOM: #165595 1px solid; POSITION: absolute; TOP: 0px">
<DIV 
style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px; BACKGROUND-COLOR: #6677aa">
<A class=whitelink title="Угадай число" href="<? echo $url; ?>/?page=chislo">Угадай число</A><BR>
<A class=whitelink title="Три туза" href="<? echo $url; ?>/?page=tuz">Три туза</A><BR>
<A class=whitelink title="Пиковая дама" href="<? echo $url; ?>/?page=dama">Пиковая дама</A><BR>
<A class=whitelink title="Наперстки" href="<? echo $url; ?>/?page=nap">Наперстки</A><BR>
<A class=whitelink title="Козырь" href="<? echo $url; ?>/?page=kozir">Козырь</A><BR>
<A class=whitelink title="Орел и решка" href="<? echo $url; ?>/?page=eagle">Орел и решка</A><BR>
<A class=whitelink title="Однорукий бандит" href="<? echo $url; ?>/?page=bandit">Однорукий бандит</A><BR>
<A class=whitelink title="Миг удачи" href="<? echo $url; ?>/?page=mig_udachi">Миг удачи</A><BR>
<A class=whitelink title="Пирамида" href="<? echo $url; ?>/?page=pyramid">Пирамида</A><BR></DIV>
</DIV>
<DIV id=dropmenu2 
style="BORDER-RIGHT: #165595 1px solid; PADDING-RIGHT: 3px; BORDER-TOP: #165595 1px solid; PADDING-LEFT: 3px; LEFT: 0px; VISIBILITY: hidden; PADDING-BOTTOM: 3px; BORDER-LEFT: #165595 1px solid; WIDTH: 160px; PADDING-TOP: 3px; BORDER-BOTTOM: #165595 1px solid; POSITION: absolute; TOP: 0px; BACKGROUND-COLOR: #6677aa">
<A class=whitelink title="Весна" href="<? echo $url; ?>/?page=vesna">Весна</A><BR>
<A class=whitelink title="Момент" href="<? echo $url; ?>/?page=moment">Момент</A><BR></DIV>
<DIV id=dropmenu3 
style="BORDER-RIGHT: #165595 1px solid; PADDING-RIGHT: 0px; BORDER-TOP: #165595 1px solid; PADDING-LEFT: 0px; LEFT: 0px; VISIBILITY: hidden; PADDING-BOTTOM: 0px; BORDER-LEFT: #165595 1px solid; WIDTH: 170px; PADDING-TOP: 0px; BORDER-BOTTOM: #165595 1px solid; POSITION: absolute; TOP: 0px">
<DIV 
style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px; BACKGROUND-COLOR: #6677aa">
<A class=whitelink title="Правила" href="<? echo $url; ?>/?page=rules">Правила</A><BR>
<A class=whitelink title="Бонус на депозиты" href="<? echo $url; ?>/?page=regainbonus">Бонус на депозиты</A><BR>
<A class=whitelink title="Еженедельный бонус" href="<? echo $url; ?>/?page=week_bonus">Еженедельный бонус</A><BR>
<A class=whitelink title="Статистика выигрышей" href="<? echo $url; ?>/?page=stat_wins">Статистика выигрышей</A><BR>
<A class=whitelink title="Описание WebMoney" href="<? echo $url; ?>/?page=kurs">Описание WebMoney</A><BR>
</DIV></DIV>
<DIV id=dropmenu4 
style="BORDER-RIGHT: #165595 1px solid; PADDING-RIGHT: 0px; BORDER-TOP: #165595 1px solid; PADDING-LEFT: 0px; LEFT: 0px; VISIBILITY: hidden; PADDING-BOTTOM: 0px; BORDER-LEFT: #165595 1px solid; WIDTH: 240px; PADDING-TOP: 0px; BORDER-BOTTOM: #165595 1px solid; POSITION: absolute; TOP: 0px">
<DIV 
style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px; BACKGROUND-COLOR: #6677aa">
<A class=whitelink title="Правила" href="<? echo $url; ?>/?page=par_prog">Регистрация в партнерской программа</A><BR>
<A class=whitelink title="Описание WebMoney" href="http://www.ultrex.ru/?page=partner_enter">Вход для партнеров</A><BR>
</DIV></DIV>
<!------>
  <tr> 
    <td width="100%" valign="top"> 
<TABLE cellSpacing=0 cellPadding=0 border=0 bgcolor="#ffffff">
        <TBODY>
        <TR>
          <TD noWrap width="18%" height="100%" valign="top">
<table width="100%" border="0" height="100%" cellspacing="0" cellpadding="10" valign=top align="center">     
  <tr valign=top> 
          <td valign=top width="100%" bgcolor="#FFFFFF">
            <TABLE cellSpacing=0 cellPadding=0 width="170" border=0 style="BORDER: #6677aa 1px solid">
               <tr> 
          <td bgcolor="#88aadd" class=whitesmall height="25" width="170" style="BORDER-BOTTOM: #6677aa 1px solid"> 
            <div align="center">Статистика</div></td></tr>
              <TR>
                <TD vAlign=top noWrap height="100%" class=blackvsmall><br><div align='center'><font color='#333333'>Сыграло билетов: </font><span class='targetvsmall'><strong><u>
<a id=game_count><script language="JavaScript">
<!--
document.write(all_games); 
//-->
</script></a></u></strong></span><br>
<font color='#333333'>Выигрышей на сумму: </font><strong><br><br>    
<p><SPAN style="COLOR: green"><B><u>
<a id=wmz_out><script language="JavaScript">
<!--
document.write(out_wmz); 
//-->
</script></u></B></SPAN> WM<SPAN style="COLOR: green"><B>Z</B></SPAN></p>  


<p><SPAN style="COLOR: red"><B><u>
<a id=wmr_out><script language="JavaScript">
<!--
document.write(out_wmr); 
//-->
</script></a></u></B></SPAN> WM<SPAN style="COLOR: red"><B>R</B></SPAN></p> 

<p><SPAN style="COLOR: blue"><B><u>
<a id=wme_out><script language="JavaScript">
<!--
document.write(out_wme); 
//-->
</script></a></u></B></SPAN> WM<SPAN style="COLOR: blue"><B>E</B></SPAN><br> 
   
<p><SPAN style="COLOR: olive"><B><u>
<a id=wmu_out><script language="JavaScript">
<!--
document.write(out_wmu); 
//-->
</script></a></u></B></SPAN> WM<SPAN style="COLOR: olive"><B>U</B></SPAN></div><br></td></tr></table><br>

<TABLE cellSpacing=0 cellPadding=0 width="170" border=0 style="BORDER: #7aa46e 1px solid">
            


<TABLE cellSpacing=0 cellPadding=0 width="170" border=0 style="BORDER: #88aadd 1px solid">
            
<tr>
 <td bgcolor="#88aadd" class=whitesmall height="25" height="100%" width="170" style="BORDER-BOTTOM: #6677aa 1px solid"> 
            <div align="center">Наш аттестат</div></td></tr>
              <TR>
                <TD vAlign=top height="100%" align="center"><br><a class='section' href="https://passport.webmoney.ru/asp/certView.asp?wmid=<? echo $id; ?>" target=_blank><IMG SRC="http://www.ultrex.ru/images/certificate.gif" title="Здесь находится аттестат нашего WMID <? echo $id; ?>" border="0"><br><strong>Нам доверяют</strong></a><!-- end WebMoney Transfer : attestation label --><br><br></td></tr></table></tr></td></tr></table>
    <td width="100%" valign=top>
   <table width="100%" border="0" height="100%" cellspacing="0" cellpadding="10">     
  <tr> 
          <td width="100%" bgcolor="#FFFFFF" valign="top">
<?
if (isset($_GET['page']) == false)
{
include("inc/index.inc");
$_GET['page'] = 'index';
}
else 
{
if (ereg ("[a-z]", $_GET['page']) and file_exists("inc/".$_GET['page'].".inc") == true)
{ 
include("inc/".$_GET['page'].".inc");
}
else 
{ 
include("inc/404.inc"); 
}
}
?>

<td valign=top height=100% bgcolor='#FFFFFF' id=table_account style='DISPLAY: none'>
            <TABLE cellSpacing=0 cellPadding=0 width='170' height='100%' border=0 style='BORDER: #6677aa 1px solid'>
               <TR id=title_account style='DISPLAY: none'>
          <td bgcolor='#88aadd' class=whitesmall height='25' width='170' style='BORDER-BOTTOM: #6677aa 1px solid'> 
            <div align='center'>Личный счет</div></td></tr>              
                <tr id=stat_account style='DISPLAY: none'><TD vAlign=top noWrap height='100%'>


<table width='100%' border='0' valign=top align=center cellspacing='0' cellpadding='4'>
  <tr>
    <td align=right class=blackvsmall><strong><font color='green'><u><a id=zcount>0.00</a></u></font></strong></td>
    <td align=left class=blackvsmall><strong>WM<font color='green'>Z</font></strong></td>
  </tr>
  <tr>
    <td align=right class=blackvsmall><strong><font color='#ff0000'><u><a id=rcount>0.00</a></u></font></strong></td>
    <td align=left class=blackvsmall><strong>WM<font color='#ff0000'>R</font></strong></td>
  </tr>
  <tr>
    <td align=right class=blackvsmall><strong><font color='blue'><u><a id=ecount>0.00</a></u></font></strong></td>
    <td align=left class=blackvsmall><strong>WM<font color='blue'>E</font></strong></td>
  </tr>
  <tr>
    <td align=right class=blackvsmall><strong><font color='olive'><u><a id=ucount>0.00</a></u></font></strong></td>
    <td align=left class=blackvsmall><strong>WM<font color='olive'>U</font></strong></td>
  </tr>
  <tr>
    <td colspan='2' class=blackvsmall><p>&nbsp;</p><p>&nbsp;</p><p align='center'><a href="<? echo $url; ?>/?page=pay_out" title="Снять со счета" class="section"><strong>Снять</strong></a> / <a href="<? echo $url; ?>/?page=pay" title="Пополнить счет" class="section"><strong>Пополнить</strong></a></p></td></tr>
</table>
<body>
<script>update_account();</script>

</TD></TR></table>

</table></table>   
<body><script>view_account();</script>    

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR bgColor=#eeeeee>
    <TD style="BORDER-TOP: #acacac 1px solid" vAlign=top>
<!--счетчики-->
      <TABLE cellSpacing=2 cellPadding=2 width="100%" border=0>
        <TBODY>
        <TR>
          <TD class=blackvsmall width="100%"><A class=section href="http://www.wmcap.ru/" target=_blank>Интернет казино <a href="index1.php">.</a></A> разработано с 
            использованием партнерских скриптов <BR>Copyright © <? echo "".date("Y").""; ?> «<? echo $copyright; ?>»</TD>         
   <td>
      <table border=0 cellspacing=0 cellpadding=4><tr>
      <td>
<!-- Кнопка(счетчик) формата 88х31 №1 -->
</td>
<td>
<!-- Кнопка(счетчик) формата 88х31 №2 -->
</td>
<td>
<!-- Кнопка(счетчик) формата 88х31 №3 -->
</td>
<td>
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='http://counter.yadro.ru/hit?t12.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров за 24 часа, посетителей за 24 часа и за сегодня' "+
"border=0 width=88 height=31><\/a>")//--></script><!--/LiveInternet-->
</td>
<td>
<!-- SpyLOG -->
<script src="http://tools.spylog.ru/counter2.2.js" type="text/javascript" id="spylog_code" counter="924559" ></script>
<noscript>
<a href="http://u9245.59.spylog.com/cnt?cid=924559&f=3&p=0" target="_blank">
<img src="http://u9245.59.spylog.com/cnt?cid=924559&p=0" alt='SpyLOG' border='0' width=88 height=31 ></a> 
</noscript>
<!--/ SpyLOG -->
</td>
</tr></table></td>

          <TD></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>