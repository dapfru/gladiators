<script language="JavaScript" src="http://www.ultrex.ru/js/ajax_ru/vesna.php"></script>
<table>
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="4" style="BORDER: #6677aa 1px solid" bgcolor='#ffffff'>
<tr><td bgcolor="#88aadd" class=whitesmall align='center' height="25" style="BORDER-BOTTOM: #6677aa 1px solid"><H1>Лотерея "Весна"</H1></td></tr><tr>
    <td align='center'><table width=95% align=center cellspacing="0" cellpadding="0">
          <td align=center>
            <FIELDSET style='PADDING-RIGHT: 6px; PADDING-LEFT: 6px; FONT-SIZE: 11px; PADDING-BOTTOM: 6px; BORDER: #e2e2e2 1px solid; WIDTH: 100%;'><STRONG><LEGEND align=center><b><a id=block_title>Правила игры</a></b></STRONG></LEGEND><br><a id=res>Внимательно посмотрите на каждую из корзин! Выберите ту, в которой, по вашему мнению, находятся <font color='#ff0000'><u>розы</u></font>! Если Вы правильно угадаете, то получите мгновенно на свой счет сумму Вашей ставки, увеличенной в <font color='green' size='2'><strong>6</strong></font> раз.</a></FIELDSET></td><tr valign="top"><td align="right" valign="top"><a href="#" onmouseover=view_rules(); class="section"><small>Правила игры</a></td></table></tr></td>

  <tr>
    <td align='center'><table cellspacing=0 cellpadding=1 border=0 align='center'>

<form name="form1">

<INPUT type=hidden value=<? echo $id; ?> name=p>
<INPUT type=hidden value=<? echo $url; ?> name=url>

<br><br>
<table width="30%" align="center" border="0" cellspacing="0" cellpadding="4" style="BORDER: #7aa46e 1px solid">
<tr bgcolor="#7aa46e" class=whitesmall align="center"> 
    <td height="22" style="border-bottom: 1px solid #7aa46e; border-right: 1px solid #ffffff" nowrap> 
      <div align="center">&nbsp;&nbsp;&nbsp;&nbsp;размер ставки&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td style="border-bottom: 1px solid #7aa46e" nowrap> 
      <div align="center">&nbsp;&nbsp;&nbsp;&nbsp;тип валюты&nbsp;&nbsp;&nbsp;&nbsp;</div></td></tr>
 <tr align="center"> 
    <td height="22" style="border-right: 1px solid #7aa46e">

<!-- Ставки -->
<select name="moneys" class="input_text_casino">
<option value="100" style="color:blue">100&nbsp;&nbsp;&nbsp;&nbsp;</option>
<option value="70">70</option>
<option value="50">50</option>
<option value="30">30</option>
<option value="20">20</option>				
<option value="10" style="color:maroon">10</option>
<option value="7">7</option>
<option value="5">5</option>
<option value="3">3</option>
<option value="2">2</option>				
<option value="1" style="color:red">1</option>
<option value="0.7">0.7</option>
<option value="0.5">0.5</option>
<option value="0.3">0.3</option>
<option value="0.2">0.2</option>
<option value="0.1" selected>0.1</option>
</select>
<!-- /Ставки -->
</td>
    <td height="22" nowrap> 
<select name="type" class="input_text_casino">
<option selected value="Z" style="color:green">WMZ
<option value="E" style="color:blue">WME&nbsp;&nbsp;&nbsp;
<option value="R" style="color:red">WMR
<option value="U" style="color:olive">WMU
</select></tr></td></tr></table>
<br><p align='center'>Нажмите на одну из корзин, чтобы сыграть:</p><br>  
<center><img id=korzina1 src="img/korzina.gif" width="72" height="97" alt="Выберите корзину" style="cursor: hand;" onclick="GameRequest(1);">&nbsp;
<img id=korzina2 src="img/korzina.gif" width="72" height="97" alt="Выберите корзину" style="cursor: hand;" onclick="GameRequest(2);">&nbsp;
<img id=korzina3 src="img/korzina.gif" width="72" height="97" alt="Выберите корзину" style="cursor: hand;" onclick="GameRequest(3);">&nbsp;
<img id=korzina4 src="img/korzina.gif" width="72" height="97" alt="Выберите корзину" style="cursor: hand;" onclick="GameRequest(4);">&nbsp;
<img id=korzina5 src="img/korzina.gif" width="72" height="97" alt="Выберите корзину" style="cursor: hand;" onclick="GameRequest(5);">&nbsp;
<img id=korzina6 src="img/korzina.gif" width="72" height="97" alt="Выберите корзину" style="cursor: hand;" onclick="GameRequest(6);">&nbsp;
</form></table>