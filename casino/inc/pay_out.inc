<table>
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="4" style="BORDER: #6677aa 1px solid" bgcolor='#ffffff'>
<tr><td bgcolor="#88aadd" class=whitesmall align='center' height="25" style="BORDER-BOTTOM: #6677aa 1px solid"><H1>������ �� �����</H1></td></tr><tr>
   <tr>
    <td align='left'><br>

<SCRIPT language=javascript> 

function WM_FormPost(){
	if(document.all){
                if(wm_payout.purse.value.length != 13){
			alert('���������� ������� ������� ����������!');
			return;
                }
                if(wm_payout.amount.value.length == 0){
			alert('���������� ������� ����� ��������!');
			return;
		}             
                if(wm_payout.amount.value <= 0.01){
			alert('����� �������� ������ ���� ������ 0.01 USD!');
			return;
		}         
                if(isNaN(wm_payout.amount.value)) 
                {
                alert("������� �� �������� �������� � ���� ����� ��������! ������� ��������.");                              
                wm_payout.amount.focus();
                return false;
                }
                document.getElementById('user').value = gamer; 
		wm_payout.submit();
	}	
}
function EG_FormPost(){
	if(document.all){
                if(eg_payout.account.value.length == 0){
			alert('���������� ������� ������� ����������!');
			return;
                }
                if(eg_payout.amount.value.length == 0){
			alert('���������� ������� ����� ��������!');
			return;
		}             
                if(eg_payout.amount.value <= 0.01){
			alert('����� �������� ������ ���� ������ 0.01 USD!');
			return;
		}        
                if(isNaN(eg_payout.amount.value)) 
                {
                alert("������� �� �������� �������� � ���� ����� ��������! ������� ��������.");                              
                eg_payout.amount.focus();
                return false;
                } 
                document.getElementById('user').value = gamer; 
		eg_payout.submit();
	}	
}
</SCRIPT>

<table border='0' width='100%' cellspacing='0' cellpadding='0'>
  <tr>
    <td nowrap class=blackvsmall><p align='left'><strong>�������� ��� ������:</strong></p></td>
    <td rowspan="5" width="20">&nbsp;</td>
    <td rowspan="5" valign="top" class=blackvsmall><font color='#ff0000'><strong>��������!</strong></font><!-- � ����� ������������ ������ ������� �� ����� �������� ������ �� WM-�������� ������������� WMID#webmoney73.<br><br>-->  �� ����� ������� ��������� �������� <strong>0.8%</strong>, �� �� ����� <strong><font color='green'>0.01</font> WM</strong> (<i>��� WebMoney</i>)<br><br>������ ������� �������� ������ � �� ��������� �������, ����� ������� ����������� ���������� ����� (<i>������ ��� <strong>WM<font color='green'>Z</font></strong>)</i></td>
  </tr>
  <tr>
    <td nowrap class=blackvsmall><p align='left'><img src=/img/ico_5.gif width=7 height=7> <strong><font color='green'><u><script language="JavaScript">
<!--
document.write(wmz_real); 
//-->
</script></u></font></strong> <strong>WM<font color='green'>Z</font></strong></p></td>    
  </tr>
  <tr>
    <td nowrap class=blackvsmall><p align='left'><img src=/img/ico_5.gif width=7 height=7> <strong><font color='#ff0000'><u><script language="JavaScript">
<!--
document.write(wmr_real); 
//-->
</script></u></font></strong> <strong>WM<font color='#ff0000'>R</font></strong></p></td>   
  </tr>
  <tr>
    <td nowrap class=blackvsmall><p align='left'><img src=/img/ico_5.gif width=7 height=7> <strong><font color='blue'><u><script language="JavaScript">
<!--
document.write(wme_real); 
//-->
</script></u></font></strong> <strong>WM<font color='blue'>E</font></strong></p></td>    
  </tr>
  <tr>
    <td nowrap class=blackvsmall><p align='left'><img src=/img/ico_5.gif width=7 height=7> <strong><font color='olive'><u><script language="JavaScript">
<!--
document.write(wmu_real); 
//-->
</script></u></font></strong> <strong>WM<font color='olive'>U</font></strong></p></td>    
  </tr>
</table>


<br><br>



<table border='0' width='90%' cellspacing='0' cellpadding='0' style='border: 1 solid #7aa46e' align="center"><tr>
<form method='POST' action='http://www.ultrex.ru/js/reg_game_ru/pay_out.php' name='wm_payout' target=z>
<input type='hidden' name='wm_pay_out' value='ok'>
<input type='hidden' name='user' value=''>
<td width='95%' height='25' style='border-right: 1 solid #7aa46e' bgcolor='#ffffff'><table cellspacing='0' cellpadding='0'><tr><td style='border-bottom: 1 solid #ffffff; border-right: 1 solid #7aa46e' width='20%' nowrap bgcolor="#7aa46e" class=whitesmall><p valign='top'>������� ����������:</p></td><td class='row2' style='border-bottom: 1 solid #7aa46e'><p valign='center'><input type=text name='purse' value='' size='25' maxlength="13" class=input_login_casino></p></td>

<tr><td style='border-right: 1 solid #7aa46e' width='20%' nowrap bgcolor="#7aa46e" class=whitesmall><p valign='top'>����� ��������:</p></td><td class='row2'><p valign='center'><input type=text name='amount' value='' size='25' class=input_login_casino></p></td></table></td>
<td width='95%' height='25' rowspan='4' bgcolor='#ffffff'><p><input type="button" onClick=WM_FormPost() value='����� �� �����!' class=button2></p></td></tr></form></table><br>

<br><br>
<table border='0' width='90%' cellspacing='0' cellpadding='0' style='border: 1 solid #7aa46e' align="center"><tr>
<form method='POST' action='http://www.ultrex.ru/js/reg_game_ru/pay_out.php' name='eg_payout' target=z>
<input type='hidden' name='eg_pay_out' value='ok'>
<input type='hidden' name='user' value=''>
<td width='95%' height='25' style='border-right: 1 solid #7aa46e' bgcolor='#ffffff'><table cellspacing='0' cellpadding='0'><tr><td style='border-bottom: 1 solid #ffffff; border-right: 1 solid #7aa46e' width='20%' nowrap bgcolor="#7aa46e" class=whitesmall><p valign='top'>E-gold �������:</p></td><td class='row2' style='border-bottom: 1 solid #7aa46e'><p valign='center'><input type=text name='account' value='' size='25' maxlength="13" class=input_login_casino></p></td>

<tr><td style='border-right: 1 solid #7aa46e' width='20%' nowrap bgcolor="#7aa46e" class=whitesmall><p valign='top'>����� ��������:</p></td><td class='row2'><p valign='center'><input type=text name='amount' value='' size='25' class=input_login_casino> <strong>US<font color='green'>D</strong></font></p></td></table></td>
<td width='95%' height='25' rowspan='4' bgcolor='#ffffff'><p><input type="button" onClick=EG_FormPost() value='����� �� �����!' class=button2></p></td></tr></form></table><br>
<iframe width=0 height=0 frameborder=0 name=z id=z src=blank.htm></iframe>


</td></tr>
</tr></td>
  </tr>
</table>