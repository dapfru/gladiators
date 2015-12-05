<table><table width="100%" align="center" border="0" cellspacing="0" cellpadding="4" style="border: 1 solid #6677aa" nowrap bgcolor='#ffffff'>
<tr><td bgcolor="#88aadd" class=whitesmall align='center' height="25" style="BORDER-BOTTOM: #6677aa 1px solid"><H1>Пополнение счета</H1></td></tr><tr>
<tr>
    <td align='left'>
<table cellpadding=0 cellspacing=0 width=100% height=100%><tr><td valign=middle align=left>

	<table cellpadding=4 cellspacing=0 align="center"><tr><td>

<?
if($_GET['st'] == '0')
{
echo "<table border='0' width='90%' cellpadding='0' align='center' cellspacing='0' style='border: 1 solid #ff0000'><tr><td width='10%' height='30' align='center' valign='center'><p><font color='#ff0000'><strong>Вы отказались от оплаты!</strong></font></p></td></tr></table><br>";
}
if($_GET['st'] == '2')
{
echo "
<table border='0' width='90%' cellpadding='0' align='center' cellspacing='0' style='border: 1 solid #7aa46e'><tr><td width='10%' height='30' align='center' valign='center'><p><font color='green'><strong>Платеж успешно зачислен на Ваш счет!</strong></font></p></td></tr></table><br>";
}
?>

<SCRIPT language=javascript> 

function FormPost_merchant(){
	if(document.all){
                if(pay_merchant.LMI_PAYMENT_AMOUNT.value.length == 0){
			alert('Укажите сумму пополнения!');
			return;
		}  
                if(pay_merchant.LMI_PAYMENT_AMOUNT.value > 5000){
			alert('Максимально допустимая сумма пополнения 5000 WM, измените значение!');
			return;
		}              
                document.getElementById('wmid').value = gamer; 
                document.getElementById('desc').value = "Пополнение игрового счета, пользователь "+gamer;
               		pay_merchant.submit();
	}	
}

function FormPost_egold(){
	if(document.all){
                if(pay_egold.PAYMENT_AMOUNT.value.length == 0){
			alert('Укажите сумму пополнения!');
			return;
		}  
                if(pay_egold.PAYMENT_AMOUNT.value > 5000){
			alert('Максимально допустимая сумма пополнения 5000 WM, измените значение!');
			return;
		}                   
                document.getElementById('user').value = gamer; 
                document.getElementById('memo').value = "Updating of game account, the user "+gamer; 
                pay_egold.submit();
                
	}	
}
</SCRIPT>


<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>    
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td><p align="center">Оплата через <a href="https://merchant.webmoney.ru/" target=_blank class="section">WM Merchant</a></p></td></tr></table>   

<table border='0' width='90%' cellspacing='0' cellpadding='0' style='border: 1 solid #7aa46e' align="center"><tr>
<form method='POST' name='pay_merchant' action='https://merchant.webmoney.ru/lmi/payment.asp' onsubmit=return!1>
<input type='hidden' name='pay_merchant' value='ok'>
<input type='hidden' name='PAYMENT_WMID' id=wmid value=''>
<input type='hidden' name='LMI_SUCCESS_URL' value='<? echo $url; ?>/?page=pay&t=merchant&st=2'>
<input type='hidden' name='LMI_SUCCESS_METHOD' value='GET'>
<input type='hidden' name='LMI_FAIL_URL' value='<? echo $url; ?>/?page=pay&t=merchant&st=0'>
<input type='hidden' name='LMI_FAIL_METHOD' value='GET'>
<input type='hidden' name='LMI_PAYMENT_DESC' id=desc value=''>
<td width='95%' height='25' style='border-right: 1 solid #7aa46e' bgcolor='#ffffff'><table cellspacing='0' cellpadding='0'><tr><td style='border-bottom: 1 solid #ffffff; border-right: 1 solid #7aa46e' width='20%' nowrap bgcolor="#7aa46e" class=whitesmall><p valign='top'>Сумма пополнения:</td><td class='row2' style='border-bottom: 1 solid #7aa46e'><p valign='center'><input name='LMI_PAYMENT_AMOUNT' type='text' size='10' maxlength="4" id='LMI_PAYMENT_AMOUNT' class='input_login_casino'></p></td>
 
<tr><td style='border-right: 1 solid #6677aa' width='20%' nowrap bgcolor="#7aa46e" class=whitesmall><p valign='top'>Валюта</p></td><td class='row2'><p valign='center'>
<select name="LMI_PAYEE_PURSE" class="input_text_casino">
<option selected value="Z774879011987" style="color:green">WMZ
<option value="E317300419985" style="color:blue">WME&nbsp;&nbsp;&nbsp;
<option value="R686828632895" style="color:red">WMR
<option value="U786938634964" style="color:olive">WMU
</select></p></td></table></td>
<td width='95%' height='25' rowspan='4' bgcolor='#ffffff'><p><input type="button" onClick=FormPost_merchant() value='Пополнить счет!' class=button2></p></td></tr></form></table><br><br>

 <table width="100%" align="center" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td><p align="center">Оплата через <a href="http://www.e-gold.com/" target=_blank class="section">E-gold</a></p></td></tr></table>   


 <table width="70%" align="center" border="0" cellspacing="0" cellpadding="4" style='border: 1 solid #7aa46e'>
<form method='POST' name='pay_egold' action='https://www.e-gold.com/sci_asp/payments.asp' onsubmit=return!1>
<input type='hidden' name='PAYEE_ACCOUNT' value='2633488'>
<input type='hidden' name='PAYEE_NAME' value='ULTREX.RU'>
<input type='hidden' name='PAYMENT_UNITS' value='1'>
<input type='hidden' name='PAYMENT_METAL_ID' value='1'>
<input type='hidden' name='STATUS_URL' value='http://www.ultrex.ru/egold.php?st=1'>
<input type='hidden' name='PAYMENT_URL' value='<? echo $url; ?>/?page=pay&t=egold&st=2'> 
<input type='hidden' name='NOPAYMENT_URL' value='<? echo $url; ?>/?page=pay&t=egold&st=0'>
<input type='hidden' name='SUGGESTED_MEMO' id=memo value=''>
<input type='hidden' name='BAGGAGE_FIELDS' value='USER_ID'>
<input type='hidden' name='USER_ID' id=user value=''>
        <tr>         
          <td style='border-right: 1 solid #7aa46e' width='20%' nowrap bgcolor="#7aa46e" class=whitesmall><p valign='top'>Сумма пополнения:</p></td><td style="border-right: 1 solid #7aa46e" class="row2" nowrap><p><input name='PAYMENT_AMOUNT' type='text' size='10' maxlength="4" class='input_login_casino'>&nbsp;<strong>US<font color="green">D</font></strong></p></td>
          <td align="center" width="100%"><p><input type="button" onClick=FormPost_egold() value='Пополнить счет!' class=button2></p></td></tr></form></table><br><br> 

	  <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td></td>          
        </tr>
      </table>
    </td>
  </tr>
</table>

</td>
  </tr>
</table>
</tr></td></table>


</td></tr>
</tr></td>
  </tr>
</table>